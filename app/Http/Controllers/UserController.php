<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WalletType;
use App\Models\UserWallet;
use App\Models\UserBank;
use App\Models\UserOtp;
use App\Models\UserRegisterHistory;
use App\Models\GameLog;
use App\Models\Game;
use App\Models\ManualTransaction;
use App\Models\BankInDepositTransaction;
use App\Models\WithdrawTransaction;
use App\Models\ResetPasswordOtp;
use App\Models\ReferralCount;
use App\Models\WinoverTurnoverSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\ValidBank;
use App\Rules\ValidUser;
use App\Rules\ValidOtp;
use App\Rules\ValidContactNo;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function user_register(Request $request){
        $validator = Validator::make($request->all(),
            [
                'username' => ['required', 'string', 'unique:users,username,NULL,id,deleted_at,NULL', 'min:8', 'max:12',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'name' => ['required', 'string', 'min:3','max:50','alpha_spaces'],
                'contact_no' => ['required', 'numeric', 'unique:users,contact_no,NULL,id,deleted_at,NULL'],
            ],
            [
                'username.min' => 'Username must be at least 4 characters.',
                'username.max' => 'Username can\'t be longer than 11 characters.',
                'username.regex' => 'Username must has alphabet and number.',
                'password.confirmed' => 'Passwords do not match.',
                'contact_no.unique' => 'Contact number is already in use.',
                'username.unique' => 'Username is already in use.',
                'name.alpha_spaces' => 'Invalid full name.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->all());
        }

        if (substr($request->contact_no, 0, 1) === '0') {
            $contact_no = substr($request->contact_no, 1);
        }else{
            $contact_no = $request->contact_no;
        }
        $request->merge(['contact_no'=>$contact_no]);

        $check_phonenumber = User::where('contact_no',$request->contact_no)->first();
        if(isset($check_phonenumber)){
            return redirect()->back()->withError('system already have this number..')->withInput($request->all());
        }

        $UserHistory = UserRegisterHistory::where('contact_no',$request->contact_no)->first();
        if($UserHistory){
            $latestOtp = $UserHistory->latest_otp;
            if (isset($UserHistory) && $UserHistory->latest_otp) {
                if($latestOtp && $latestOtp->otp_received == $request->otpnumber){
                    if($request->referral_code){
                        $findupline = User::where('referral_code',$request->referral_code)->first();
                        if(isset($findupline)){
                            $request->merge(['upline'=>$findupline->id]);
                        }
                        else{ 
                            return redirect()->back()->withError('Invalid Referral Code..')->withInput($request->all());
                        }
                    }
                    $hidden_contact =  substr($request->contact_no, 0, 4) . str_repeat("*", strlen($request->contact_no) - 5) . substr($request->contact_no, -1);
                    $request->merge(['password' => Hash::make($request->password),'role_id'=>3,'referral_code'=>$this->getReferral(),'hidden_contact_no'=>$hidden_contact]);
                    $player = User::create($request->all());

                    $UserHistory->update([
                        'added_to_user' => $player->id,
                    ]);
                    $UserHistory->latest_otp->update([
                        'otp_verified_at' => Carbon::now(),
                    ]);

                    // Check Referral
                    if($request->upline){
                        $referral_count = WinoverTurnoverSetting::where('type','referral_count')->first();
                        $upline = User::where('id', $request->upline)->first();
                        $total_amount = $referral_count->amount / $referral_count->pax;
                        $total_amount =  number_format($total_amount,2,'.','');
                        ReferralCount::create([
                            'user_id' => $upline->id,
                            'pax' => $referral_count->pax,
                            'amount' => $referral_count->amount,
                            'total_amount' => $total_amount,
                            'downline' => $player->id
                        ]);
                    }
        
                    Auth::login($player);
        
                    return redirect()->route('login')->withSuccess('Registration Success');

                }else{
                    return redirect()->back()->withError('Invalid OTP..')->withInput($request->all());
                }
            }else{
                return redirect()->back()->withError('Invalid OTP..')->withInput($request->all());
            }
        }
        else{
            return redirect()->back()->withError('Invalid OTP..')->withInput($request->all());
        }
    }

    public function create_user_bank(Request $request){

        $user = Auth::user();
        if(UserBank::where('user_id', $user->id)->count()>0){
            return redirect()->back()->withError('Your account already link to a bank account. Please Contact Customer Service');   
        }
        $validator = Validator::make($request->all(), [
            'bank_id' => ['required', 'integer'],
            'account_no' => ['required', 'regex:/^[0-9]+$/'],
        ]);

        if ($validator->fails()) {
            $message = "";
            foreach($validator->messages()->messages() as $m){
                foreach($m as $mm){
                    $message .=$mm.'\n';
                }
            }
            return redirect()->back()
            ->withInfo($message);
        }
        // dd($request->all());
        $request->merge(['user_id'=>$user->id]);

        $createUserBank = UserBank::create($request->all());

        return redirect()->route('profile')->withSuccess('Your bank has been added successfully.');
    }

    public function clearCredit(){
        $user = Auth::user();
        $pendingdeposit = BankInDepositTransaction::where('user_id', $user->id)
            ->where(function ($query) {
                $query->where('status', 'pending')->orWhere('status', 'onhold');
            })
            ->count();

        $pendingwithdraw = WithdrawTransaction::where('user_id',$user->id)
            ->where(function ($query) {
                $query->where('status', 'pending')->orWhere('status', 'onhold');
            })
            ->count();

        $pendinggame = GameLog::where('user_id',$user->id)->whereNull('different')->count();
        
        if($pendinggame > 0){
            return ['status'=>false,'msg'=>"Please withdraw all credits from game to proceed."];
        }

        if($pendingdeposit > 0 || $pendingwithdraw > 0){
            return ['status'=>false,'msg'=>"You still have transaction on pending"];
        }

        if($user->main_wallet == 0){
            return ['status'=>false,'msg'=>"Current amount AUD 0.00"];
        }

        if($user->main_wallet >= 5){
            return ['status'=>false,'msg'=>"Only available when credit is less than AUD 5.00"];
        }

        $original_point = $user->main_wallet;
        $new_add_point = $user->main_wallet;
        $final_point = 0;
        $games = Game::pluck('id')->toArray(); 
        $manual = ManualTransaction::create([
            'type'=>'withdraw',
            'user_id'=>$user->id,
            'amount'=>$new_add_point,
            'performed_by_id'=>$user->id,
            'remarks'=>"User empty credits by himself"
        ]);

        $user->update(['main_wallet'=>$final_point,'winover_rate'=>null,'winover_amount'=>null,'winover_total'=>null,'function_id'=>null,'function_type'=>null]);
        $manual->wallet_logs()->create([
            'user_id'=>$user->id,
            'type'=>'withdraw',
            'amount'=>abs($new_add_point),
            'prev_amount'=>$original_point,
            'total'=>$final_point
        ]);
        return ['status'=>true,'msg'=>"Successful empty wallet"];
    }

    public function form_change_password(Request $request){
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);


        if ($validator->fails()) {
            $message = "";
            foreach($validator->messages()->messages() as $m){
                foreach($m as $mm){
                    $message .=$mm.'\n';
                }
            }
            return redirect()->back()
                        ->withInfo($message);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withError('The provided current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile')->withSuccess('Password changed successfully.');
    }

    public function forgot_password_request(Request $request)
    {
        // dd($request->all());
        $user = User::where('contact_no', $request->contact_no)->first();
        if($user){
            $otp = ResetPasswordOtp::where('user_id',$user->id)->where('otp_received',$request->otp)->exists();
            if(!$otp){
                return redirect()->back()->withInfo("Invalid otp")->with('contact_no',$request->contact_no)->with('reset', false);   
            }
            $userInfo = array(
                'username'=>$user->username
            );

            return view('forgot_password')->with('reset', true)->with('user',$userInfo);

        }
        else{
            return redirect()->back()->withInfo($request->contact_no." does not exist in JamesBond777")->with('contact_no',$request->contact_no);
        }
    }

    public function forgot_password_update(Request $request){
        $user = User::where('username', $request->username)->first();
        $input = array(
            'username'=>$request->username
        );
        if(!$user){
            return view('forgot_password')->withInfo($request->username." does not exist in JamesBond777")->with('reset', true)->with('user',$input);
        }
        // VALIDATION
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
        
        // IF VALIDATION FAILED
        if ($validator->fails()) {
            $message = "";
            foreach($validator->messages()->messages() as $m){
                foreach($m as $mm){
                    $message .=$mm.'<br>';
                }
            }
            return view('forgot_password')->withInfo($message)->with('reset', true)->with('user',$input);
        }

        // IF VALIDATION PASS 
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('login')->withSuccess('Your password has been reset successfully.');
    }
}
