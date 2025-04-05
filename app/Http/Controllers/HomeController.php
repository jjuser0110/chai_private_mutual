<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
  
    public function index()
    {
        // $games = Game::orderBy('sequence', 'ASC')->get();
        // $depositLog = Score::where('type','deposit')->orderBy('date', 'DESC')->take(5)->get();
        // foreach($depositLog as $depo){
        //     $depo->shortname = $this->hidePartialNumber($depo->username);
        // }
        // $withdrawLog = Score::where('type','withdraw')->orderBy('date', 'DESC')->take(5)->get();
        
        // foreach($withdrawLog as $with){
        //     $with->shortname = $this->hidePartialNumber($with->username);
        // }
        
        // $user = Auth::user();
        // if(isset($user)){
        //     if($user->function_type!=null){
        //         switch ($user->function_type) {
        //             case 'bonus_event':
        //                 $game_list = UserBonus::find($user->function_id)->bonus_event->game_type??array();
        //                 break;
        //             case 'angpao':
        //                 $game_list = UserAngpao::find($user->function_id)->angpao->game_type??array();
        //                 break;
        //             case 'referral':
        //                 $referral = WinoverTurnoverSetting::where('type','referral')->first();
        //                 $game_list = $referral->game_type??array();
        //                 break;
        //             case 'manual':
        //                 $game_list = ManualTransaction::where('id',$user->function_id)->value('game_type') ??array();
        //                 break;
        //             default:
        //                 $game_list = Game::pluck('id')->toArray();
        //         }
        //         foreach($games as $g){
        //             if(!in_array($g->id, $game_list)){
        //                 $g->disabled =true;
        //             }
        //         }
        //     }
        // }
        return view('index');


       // $page = Page::where('slug', $slug)->first();

        // If the user is not authenticated, handle accordingly
        // if (!auth()->check()) {
        //     // If the request is AJAX and the user is not logged in
        //     if (request()->ajax()) {
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'Please log in to view this page.',
        //             'redirect' => route('login')
        //         ], 401); // Send Unauthorized response
        //     }
    
        //     // For non-AJAX requests, just redirect to the login page
        //     return redirect()->route('login');
        // }
    
        // If the user is authenticated and making an AJAX request, return the content
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('index', compact('content'))->render()
            ]);
        }
    
        // For non-AJAX requests (regular page load), just render the page as usual
        return view('index', compact('content'));
    }

    public function history()
    {
        $user= Auth::user();
        $getcdm = BankInDepositTransaction::where('user_id',$user->id)->orderBy('id','desc')->take(20)->get();
        $deposit = [];
        $withdraw = [];
        $game_log = [];
        foreach($getcdm as $cdm){
            if (strpos($cdm->status, "Rejected") !== false) {
                $status = "rejected";
            }else{
                $status = $cdm->status;
            }
            $deposit[] = [
                'depo_date'=>Carbon::parse($cdm->created_at)->format('Y-m-d H:i:s'),
                'transaction' => "CDM " . "(" . getenv('CURRENCY') ." ". round($cdm->amount, 2) . ")",
                'status' => $status, 
            ];
        }
        $getwithdraw = WithdrawTransaction::where('user_id',$user->id)->orderBy('id','desc')->take(20)->get();
        foreach($getwithdraw as $with){
            if (strpos($with->status, "Rejected") !== false) {
                $status = "rejected";
            }else{
                $status = $with->status;
            }
            $withdraw[] = [
                'withdraw_date'=>Carbon::parse($with->created_at)->format('Y-m-d H:i:s'),
                'transaction' => "Withdraw " . "(" . getenv('CURRENCY') ." ". round($with->amount, 2) . ")",
                'remarks' => $with->remarks,
                'status' => $status, 
            ];
        }
        
        $getgamelog = GameLog::where('user_id',$user->id)->orderBy('id','desc')->take(20)->get();
        foreach($getgamelog as $glg){
            $game_log[] = [
                'game_name' => $glg->game->game_name,
                'in' => round($glg->depo_amount, 2), 
                'out' => round($glg->withdraw_amount, 2), 
                'different' => round($glg->different, 2), 
            ];
        }
        return view('history')->with('deposit',$deposit)->with('withdraw',$withdraw)->with('game_log',$game_log);
    }

    public function bonus()
    {
        $angpao = Angpao::where('status',1)->get();
        
        $specialBonus = BonusEvent::whereIn('id',[23,24,25,26,27,28])->where('status',1)->get();
        $specialBonus2 = BonusEvent::whereIn('id',[29,30,31,32,33,34,35,36])->where('status',1)->get();
        $bonusCategory = BonusCategory::all();
        return view('bonus')->with('angpao',$angpao)->with('bonusCategory',$bonusCategory)->with('specialBonus',$specialBonus)->with('specialBonus2',$specialBonus2);
    }

    public function chat()
    {
        return view('chat');
    }

    public function profile()
    {
        return view('profile');
    }

    public function resetpassword()
    {
        return view('reset_password');
    }

    public function forgotpassword()
    {
        return view('forgot_password');
    }

    public function forgot_password_request(Request $request)
    {
        return view('forgot_password')->with('reset', true);
    }

    public function fake_login(Request $request)
    {
        return view('index')->with('user', true);
    }

    public function deposit()
    {
        $user= Auth::user();
        $game_log = GameLog::where('user_id',$user->id)->where('different',null)->orderBy('id','DESC')->first();
        if(isset($game_log)){
            return redirect()->back()->withError('Please withdraw all Money From Game');
        }
        
        if($user->main_wallet > 1){
            return redirect()->back()->withError('Make sure your wallet is less than AUD 1 to proceed');
        }
        $getcdm = BankInDepositTransaction::where('user_id',$user->id)->whereIn('status',['pending','onhold'])->get();
        $getwithdraw = WithdrawTransaction::where('user_id',$user->id)->whereIn('status',['pending','onhold'])->get();
        if($getcdm->count() > 0 || $getwithdraw->count()>0){
            return redirect()->back()->withError('You have Pending Transactions, Check your Deposit and Withdrawal');
        }

        $cdm = BankSetting::where('is_active',1)->get();
        $bonus = BonusEvent::where('status',1)->get();
        return view('deposit')->with('cdm',$cdm)->with('bonus',$bonus);
    }

    public function withdraw()
    {
        return view('withdraw');
    }

    public function add_bank()
    {
        $bank = Bank::all();
        return view('add_bank_account')->with('bank',$bank);
    }

    public function downline()
    {
        $user = Auth::user();
        $today = Carbon::now();
        $lastMonday = $today->startOfWeek()->subWeek();
        $lastSunday = $lastMonday->copy()->endOfWeek();
        $lastMonday->startOfDay();
        $lastSunday->endOfDay();
        $my_downline = ReferralClaim::where('user_id',$user->id)->where('claim_date',null)->where('created_at','>=',$lastMonday)->where('created_at','<=',$lastSunday)->get();
        return view('downline')->with('my_downline',$my_downline)->with('lastMonday',$lastMonday)->with('lastSunday',$lastSunday);
    }

    public function game_rate()
    {
        $game_rate = GameRate::all();
        return view('game_rate')->with('game_rate',$game_rate);
    }
}

