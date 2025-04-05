<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Angpao;
use App\Models\UserAngpao;
use App\Models\BonusEvent;
use App\Models\UserBonus;
use App\Models\User;
use App\Models\BankSetting;
use App\Models\BonusCategory;
use App\Models\Bank;
use App\Models\Game;
use App\Models\GameLog;
use App\Models\BankInDepositTransaction;
use App\Models\WithdrawTransaction;
use App\Models\WinoverTurnoverSetting;
use App\Models\ReferralClaim;
use App\Rules\ValidUser;
use App\Rules\ValidOtp;
use Carbon\Carbon;

class BonusController extends Controller
{
    public function check_cooldown($modal_type, $modal_id){
        if($modal_type == "angpao"){
            $angpao = Angpao::find($modal_id);
            $user = Auth::user();
            // dd($angpao);
            if ($angpao->cooldown_duration_player>0) {
                $userAngpao = UserAngpao::where('angpao_id',$angpao->id)->where('user_id',$user->id)->orderBy('id','DESC')->first();
                if(isset($userAngpao)){
                    $nextClaimDate = $userAngpao->created_at->addHours($angpao->cooldown_duration_player);
                    $response = [
                        'success' => true,
                        'after' => $nextClaimDate,
                        'now' => Carbon::now(),
                        'msg' => "Angpao Cooling Down."
                    ];
                    return $response;
                }else{
                    $response = [
                        'success' => false,
                        'msg' => "Nothing countdown."
                    ];
                    return $response;
                }
            }else{
                $response = [
                    'success' => false,
                    'msg' => "Nothing countdown."
                ];
                return $response;
            }
        }else{
            $response = [
                'success' => false,
                'msg' => "Nothing countdown."
            ];
            return $response;
        }
    }

    public function bonus_claim($modal_type, $modal_id) {
        if (!auth()->check()) {
            $response = [
                'success'=>false,
                'msg'=>"Please Login"
            ];
            return $response;
        }
        $user= Auth::user();
        $game_log = GameLog::where('user_id',$user->id)->where('different',null)->orderBy('id','DESC')->first();
        if(isset($game_log)){
            $response = [
                'success'=>false,
                'msg'=>"Please withdraw all Money From Game"
            ];
            return $response;
        }

        $getcdm = BankInDepositTransaction::where('user_id',$user->id)->whereIn('status',['pending','onhold'])->get();
        $getwithdraw = WithdrawTransaction::where('user_id',$user->id)->whereIn('status',['pending','onhold'])->get();
        if($getcdm->count() > 0 || $getwithdraw->count()>0){
            $response = [
                'success'=>false,
                'msg'=>"You have Pending Transactions, Check your Deposit and Withdrawal"
            ];
            return $response;
        }

        if($modal_type == "angpao"){
            if($user->main_wallet > 1){
                
                $response = [
                    'success'=>false,
                    'msg'=>"Make sure your wallet is less than AUD 1 to proceed"
                ];
                return $response;
            }
            $angpao = Angpao::find($modal_id);
            if($angpao->quantity_per_user != null && $angpao->quantity_per_user > 0){
                $checkUserAngpao = UserAngpao::where('angpao_id',$angpao->id)->where('user_id',$user->id)->get();
                if($checkUserAngpao->count() >= $angpao->quantity_per_user){
                    $response = [
                        'success'=>false,
                        'msg'=>"You have finish your limit to claim this angpao!"
                    ];
                    return $response;
                }
            }
            if (!is_null($angpao->claim_from_date) && !is_null($angpao->claim_to_date)) {
                $today_date = Carbon::now()->format('Y-m-d');
                if (!Carbon::parse($today_date)->between(Carbon::parse($angpao->claim_from_date), Carbon::parse($angpao->claim_to_date))) {
                    $response = [
                        'success'=>false,
                        'msg'=>"Current date is not between date range for this Angpao!"
                    ];
                    return $response;
                }
            }
            if (!is_null($angpao->claim_from_time) && !is_null($angpao->claim_to_time)) {
                $now = Carbon::now();
                $claimFromTime = Carbon::parse($angpao->claim_from_time);
                $claimToTime = Carbon::parse($angpao->claim_to_time);

                if (!$now->between($claimFromTime, $claimToTime)) {
                    $response = [
                        'success' => false,
                        'msg' => "Current time is not between time range for this Angpao!"
                    ];
                    return $response;
                }
            }
            if (!is_null($angpao->claim_day)) {
                $now = Carbon::now();

                if (!in_array($now->format('l'), $angpao->claim_day)) {
                    $response = [
                        'success' => false,
                        'msg' => "Today is not the day for this Angpao!"
                    ];
                    return $response;
                }
            }
            if ($angpao->daily_reset>0) {
                $today = Carbon::now()->format('Y-m-d');
                $checkUserAngpao = UserAngpao::where('angpao_id',$angpao->id)->where('user_id',$user->id)->whereDate('claim_date',$today)->first();

                // dd($checkUserAngpao);
                if (isset($checkUserAngpao)) {
                    $response = [
                        'success' => false,
                        'msg' => "This daily angpao you already claim today! Please come back tomorrow."
                    ];
                    return $response;
                }
            }
            // dd($angpao);
            $amount = $angpao->amount==null?$this->getAmount($angpao):$angpao->amount;
            $new_wallet = $user->main_wallet + $amount;
            $winover_rate = $angpao->winover_rate??1;
            $winover_amount = $new_wallet*$winover_rate;
            $winover_total = $winover_amount<$angpao->min_winover?$angpao->min_winover:$winover_amount;
            $now = Carbon::now();
            $userAngpao = UserAngpao::create([
                'user_id'=>$user->id,
                'angpao_id'=>$angpao->id,
                'claim_date'=>$now,
                'claim_amount'=>$amount
            ]);

            $userAngpao->wallet_logs()->create([
                'user_id'=>$user->id,
                'type'=>'angpao_claim',
                'amount'=>$amount,
                'prev_amount'=>$user->main_wallet,
                'total'=>$new_wallet,
                'winover_rate'=>$winover_rate,
                'winover_amount'=>$winover_amount,
                'winover_total'=>$winover_total,
                'function_type'=>"angpao",
                'function_id'=>$userAngpao->id,
            ]);

            $user->update([
                'main_wallet'=>$new_wallet,
                'winover_rate'=>$winover_rate,
                'winover_amount'=>$winover_amount,
                'winover_total'=>$winover_total,
                'function_type'=>"angpao",
                'function_id'=>$userAngpao->id,
            ]);

            $response = [
                'success' => true,
                'msg' => $amount." angpao claim successfully!"
            ];
            return $response;
        }else{
            $bonus = BonusEvent::find($modal_id);

            $amount = $user->main_wallet;
            $bonus_amount = $bonus->bonus_fixed_amount;
            if(!is_null($bonus->bonus_rate)){
                $bonus_amount = $amount * $bonus->bonus_rate/100;
                if($bonus->bonus_cap_limit > 0){
                    if($bonus_amount > $bonus->bonus_cap_limit){
                        $bonus_amount=$bonus->bonus_cap_limit;
                    }
                }
            }

            $user_bonus = UserBonus::create([
                'user_id'=>$user->id,
                'bonus_event_id'=>$bonus->id,
                'bonus_category_id'=>$bonus->bonus_category_id,
                'claim_date'=>Carbon::now(),
                'claim_amount'=>$bonus_amount,
                'type'=>'bonus',
                'type_id'=>null,
            ]);
            
            $total = $amount+$bonus_amount;
            $winover_rate =$bonus->winover_rate;
            $winover_amount = $bonus->winover_min_amount;
            $winover_total = round($total*$winover_rate,2);
            if(!is_null($winover_amount)&&$winover_amount>$winover_total){
                $winover_total = $winover_amount;
            }

            $user->wallet_logs()->create([
                'user_id'=>$user->id,
                'type'=>'bonus',
                'amount'=>$bonus_amount,
                'prev_amount'=>$amount,
                'total'=>$total,
                'winover_rate'=>$winover_rate,
                'winover_amount'=>$winover_amount,
                'winover_total'=>$winover_total,
                'function_type'=>'bonus_event',
                'function_id'=>$user_bonus->id,
            ]);

            $user->update([
                'main_wallet'=>round($total,2),
                'winover_rate'=>$winover_rate,
                'winover_amount'=>$winover_amount,
                'winover_total'=>$winover_total,
                'function_type'=>'bonus_event',
                'function_id'=>$user_bonus->id,
            ]);

            $response = [
                'success' => true,
                'msg' => $bonus->title." claimed successfully!"
            ];
            return $response;
        }
    }

    public function getAmount($angpao){
        $min_amount = $angpao->min_amount;
        $max_amount = $angpao->max_amount;
        $random_number = $min_amount + (mt_rand() / mt_getrandmax()) * ($max_amount - $min_amount);

        return number_format($random_number,2);
    }

    public function check_bonus($modal_type, $modal_id){
        $user = Auth::user();
        if($modal_type == "bonus"){
            $bonus = BonusEvent::find($modal_id);
            if(isset($user)){
                $game_log = GameLog::where('user_id',$user->id)->where('different',null)->orderBy('id','DESC')->first();
                if(isset($game_log)){
                    $response = [
                        'success'=>false,
                        'msg'=>"You have credit in game, please click the refresh at wallet"
                    ];
                    return $response;
                }
    
                $getcdm = BankInDepositTransaction::where('user_id',$user->id)->whereIn('status',['pending','onhold'])->get();
                $getwithdraw = WithdrawTransaction::where('user_id',$user->id)->whereIn('status',['pending','onhold'])->get();
                if($getcdm->count() > 0 || $getwithdraw->count()>0){
                    $response = [
                        'success'=>false,
                        'msg'=>"You have pending deposit or withdrawal"
                    ];
                    return $response;
                }
    
                if(!is_null($bonus->claim_qty)){
                    $findBonus = UserBonus::where('user_id',$user->id)->where('bonus_event_id',$bonus->id)->get();
                    if($findBonus->count() >= $bonus->claim_qty){
                        $response = [
                            'success' => false,
                            'msg' => "You have reach the limit to claim this bonus"
                        ];
                        return $response;
                    }

                    if($bonus->claim_qty==999){
                        $findBonus = UserBonus::where('user_id',$user->id)->where('bonus_event_id',$bonus->id)->where('type_id',999)->first();
                        if(isset($findBonus)){
                            $response = [
                                'success' => false,
                                'msg' => "You have withdraw already so no more bonus.."
                            ];
                            return $response;
                        }
                    }
                }
    
                if(!is_null($bonus->daily_deposit)){
                    $today = Carbon::now();
                    $findtodayBonus = UserBonus::where('user_id',$user->id)->where('bonus_event_id',$bonus->id)->whereDate('claim_date',$today)->first();
                    if($bonus->daily_deposit == 1){
                        if(isset($findtodayBonus)){
                            $response = [
                                'success' => false,
                                'msg' => "You have reach the limit to claim this bonus for today"
                            ];
                            return $response;
                        }
                    }
    
                    
                    if($bonus->daily_deposit == 2 || $bonus->daily_deposit == 3){
                        if($user->main_wallet > 1){
                            $response = [
                                'success' => false,
                                'msg' => "Your wallet greater than AUD 1"
                            ];
                            return $response;
                        }
                        if($bonus->daily_deposit == 2){
                            $now = Carbon::today();
                            $thisMonday = $now->startOfWeek();
                            $thisSunday = $thisMonday->copy()->endOfWeek();
                            $findtodayBonus = UserBonus::where('user_id',$user->id)->where('bonus_category_id',$bonus->bonus_category_id)->where('claim_date','>=',$thisMonday)->where('claim_date','<=',$thisSunday)->first();
    
                            if(isset($findtodayBonus)){
                                $response = [
                                    'success' => false,
                                    'msg' => "You already claim this week."
                                ];
                                return $response;
                            }
    
                            $today = Carbon::today();
                            $lastMonday = $today->startOfWeek()->subWeek();
                            $lastSunday = $lastMonday->copy()->endOfWeek();
                            $lastMonday->startOfDay();
                            $lastSunday->endOfDay();
                            
                            $deposit_amount = BankInDepositTransaction::where('user_id',$user->id)->where('status','success')->where('status_at','>=',$lastMonday)->where('status_at','<=',$lastSunday)->sum('amount');
                            // dd($deposit_amount);
                            if($deposit_amount >= $bonus->deposit_min && $deposit_amount <= $bonus->deposit_max){
                                $response = [
                                    'success' => true,
                                    'msg' => "You are in deposit amount range. Deposit : ".$deposit_amount,
                                ];
                            }else{
                                $response = [
                                    'success' => false,
                                    'msg' => "You are not in deposit amount range. Deposit : ".$deposit_amount,
                                ];
                            }
                            return $response;
                        }else{
                            $thisstartmonth = Carbon::now()->startOfMonth();
                            $thisendmonth = Carbon::now()->endOfMonth();
                            $findtodayBonus = UserBonus::where('user_id',$user->id)->where('bonus_category_id',$bonus->bonus_category_id)->where('claim_date','>=',$thisstartmonth)->where('claim_date','<=',$thisendmonth)->first();
    
                            if(isset($findtodayBonus)){
                                $response = [
                                    'success' => false,
                                    'msg' => "You already claimed this month."
                                ];
                                return $response;
                            }
    
                            $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
                            $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
                            
                            $deposit_amount = BankInDepositTransaction::where('user_id',$user->id)->where('status','success')->where('status_at','>=',$startOfLastMonth)->where('status_at','<=',$endOfLastMonth)->sum('amount');
                            // dd($deposit_amount);
                            if($deposit_amount >= $bonus->deposit_min && $deposit_amount <= $bonus->deposit_max){
                                $response = [
                                    'success' => true,
                                    'msg' => "You are in deposit amount range. Deposit : ".$deposit_amount,
                                ];
                            }else{
                                $response = [
                                    'success' => false,
                                    'msg' => "You are not in deposit amount range. Deposit : ".$deposit_amount,
                                ];
                            }
                            return $response;
                        }
                    }
                }
    
                if (!is_null($bonus->claim_from_time) && !is_null($bonus->claim_to_time)) {
                    $now = Carbon::now();
                    $claimFromTime = Carbon::parse($bonus->claim_from_time);
                    $claimToTime = Carbon::parse($bonus->claim_to_time);
    
                    if (!$now->between($claimFromTime, $claimToTime)) {
                        $response = [
                            'success' => false,
                            'msg' => "Current time is not between time range for this bonus"
                        ];
                        return $response;
                    }
                }
    
                if (!is_null($bonus->claim_day)) {
                    $now = Carbon::now();
    
                    if (!in_array($now->format('l'), $bonus->claim_day)) {
                        $response = [
                            'success' => false,
                            'msg' => "Today is not the day for this bonus!"
                        ];
                        return $response;
                    }
                }
    
                if($bonus->bonus_category_id == 2 || $bonus->bonus_category_id == 4){
                    
                    if($user->main_wallet > 1){
                        $response = [
                            'success' => false,
                            'msg' => "Your wallet greater than AUD 1"
                        ];
                        return $response;
                    }
                    //recommend
                    if($bonus->bonus_category_id == 2){
                        $depositTransaction = BankInDepositTransaction::where('user_id',$user->id)->where('status','success')->where('amount','>=',$bonus->deposit_min)->count();
                        if($depositTransaction==0){
                            $response = [
                                'success' => false,
                                'msg' => "You must deposit at least ".$bonus->deposit_min." once to claim this bonus",
                            ];
                            return $response;
                        }
                    }

                    if($bonus->id == 21){
                        $checkthisbonus = UserBonus::where('user_id',$user->id)->where('bonus_event_id',$bonus->id)->first();
                        if(isset($checkthisbonus)){
                            $response = [
                                'success' => false,
                                'msg' => "You already claim this bonus, please try again tomorrow"
                            ];
                            return $response;
                        }
                        $finddownline = User::where('upline',$user->id)->count();
                        if($finddownline >= 5){
                            $response = [
                                'success' => true,
                                'msg' => "You can claim this bonus"
                            ];
                            return $response;
                        }else{
                            $response = [
                                'success' => false,
                                'msg' => "You only have ".$finddownline." downline."
                            ];
                            return $response;
                        }
                    }
                    
                    if($bonus->id == 22){
                        $checkthisbonus = UserBonus::where('user_id',$user->id)->where('bonus_event_id',$bonus->id)->first();
                        if(isset($checkthisbonus)){
                            $response = [
                                'success' => false,
                                'msg' => "You already claim this bonus, please try again tomorrow"
                            ];
                            return $response;
                        }
                        $finddownline = User::where('upline',$user->id)->count();
                        if($finddownline >= 15){
                            $response = [
                                'success' => true,
                                'msg' => "You can claim this bonus"
                            ];
                            return $response;
                        }else{
                            $response = [
                                'success' => false,
                                'msg' => "You only have ".$finddownline." downline."
                            ];
                            return $response;
                        }
                    }
                    $today = Carbon::now()->format('Y-m-d');
                    if($bonus->id == 6){
                        $deposit_time = BankInDepositTransaction::where('user_id',$user->id)->where('status','success')->whereDate('status_at',$today)->where('amount','>=',$bonus->deposit_min)->count();
                        $checkthisbonus = UserBonus::whereDate('claim_date',$today)->where('user_id',$user->id)->where('bonus_event_id',$bonus->id)->first();
                        if(isset($checkthisbonus)){
                            $response = [
                                'success' => false,
                                'msg' => "You already claim this bonus, please try again tomorrow"
                            ];
                            return $response;
                        }
                        if($deposit_time >= 3){
                            $response = [
                                'success' => true,
                                'msg' => "You can claim this bonus"
                            ];
                            return $response;
                        }else{
                            $response = [
                                'success' => false,
                                'msg' => "You only deposit ".$deposit_time." times today"
                            ];
                            return $response;
                        }
                    }
                    
                    if($bonus->id == 9){
                        $deposit_time = BankInDepositTransaction::where('user_id',$user->id)->where('status','success')->whereDate('status_at',$today)->where('amount','>=',$bonus->deposit_min)->count();
                        $checkthisbonus = UserBonus::whereDate('claim_date',$today)->where('user_id',$user->id)->where('bonus_event_id',$bonus->id)->first();
                        if(isset($checkthisbonus)){
                            $response = [
                                'success' => false,
                                'msg' => "You already claim this bonus, please try again tomorrow"
                            ];
                            return $response;
                        }
                        if($deposit_time >= 5){
                            $response = [
                                'success' => true,
                                'msg' => "You can claim this bonus"
                            ];
                            return $response;
                        }else{
                            $response = [
                                'success' => false,
                                'msg' => "You only deposit ".$deposit_time." times today"
                            ];
                            return $response;
                        }
                    }
                }

                if($user->function_type == null){
                    if($user->main_wallet >= $bonus->deposit_min){
                        $response = [
                            'success' => true,
                            'msg' => "Bonus Able to Claim"
                        ];
                    }else{
                        $response = [
                            'success' => false,
                            'msg' => "Wallet balance not enough"
                        ];
                    }
                }else{
                    if($user->main_wallet > 1){
                        $response = [
                            'success' => false,
                            'msg' => "Wallet has another bonus!"
                        ];
                    }else{
                        if($user->main_wallet >= $bonus->deposit_min){
                            $response = [
                                'success' => true,
                                'msg' => "Bonus Able to Claim"
                            ];
                        }else{
                            $response = [
                                'success' => false,
                                'msg' => "Wallet balance not enough"
                            ];
                        }
                    }
                }
                return $response;
            }else{
                $response = [
                    'success' => true,
                    'msg' => "Login to Start Bonus!"
                ];
                return $response;
            }
        }else{
            $response = [
                'success' => false,
                'msg' => "This is not bonus"
            ];
            return $response;
        }
    }

    public function referral_claim(Request $request){
        $user= Auth::user();

        $game_log = GameLog::where('user_id',$user->id)->where('different',null)->orderBy('id','DESC')->first();
        if(isset($game_log)){
            $response = [
                'success'=>false,
                'msg'=>"Please withdraw all Money From Game"
            ];
            return $response;
        }

        $getcdm = BankInDepositTransaction::where('user_id',$user->id)->whereIn('status',['pending','onhold'])->get();
        $getwithdraw = WithdrawTransaction::where('user_id',$user->id)->whereIn('status',['pending','onhold'])->get();
        if($getcdm->count() > 0 || $getwithdraw->count()>0){
            $response = [
                'success'=>false,
                'msg'=>"You have Pending Transactions, Check your Deposit and Withdrawal"
            ];
            return $response;
        }

        if($user->main_wallet > 1){
                
            $response = [
                'success'=>false,
                'msg'=>"Make sure your wallet is less than AUD 1 to proceed"
            ];
            return $response;
        }

        $today = Carbon::now();
        $lastMonday = $today->startOfWeek()->subWeek();
        $lastSunday = $lastMonday->copy()->endOfWeek();
        $lastMonday->startOfDay();
        $lastSunday->endOfDay();
        $my_downline = ReferralClaim::where('user_id',$user->id)->where('claim_date',null)->where('created_at','>=',$lastMonday)->where('created_at','<=',$lastSunday)->get();

        if($my_downline->sum('total_amount')>0){
            $wallet= $user->main_wallet;
            $amount = $my_downline->sum('total_amount');
            $total = $wallet + $amount;
            $winover_rate = 1.5;
            $setting = WinoverTurnoverSetting::where('type', 'referral')->first();
            if(isset($setting)){
                $winover_rate = $setting->winover_rate;
            }
            $winover_total = $total*$winover_rate;

            $user->wallet_logs()->create([
                'user_id'=>$user->id,
                'type'=>'referral',
                'amount'=>$amount,
                'prev_amount'=>$wallet,
                'total'=>$total,
                'winover_rate'=>$winover_rate,
                'winover_amount'=>$winover_total,
                'winover_total'=>$winover_total,
                'function_type'=>'referral',
                'function_id'=>$setting->id,
            ]);

            $user->update([
                'main_wallet'=>round($total,2),
                'winover_rate'=>$winover_rate,
                'winover_amount'=>$winover_total,
                'winover_total'=>$winover_total,
                'function_type'=>'referral',
                'function_id'=>$setting->id,
            ]);

            foreach($my_downline as $row){
                $row->update([
                    'claim_date'=>Carbon::now(),
                ]);
            }

            $response = [
                'success' => true,
                'msg' => "Referral claimed successfully!"
            ];
            return $response;
            
        }else{
            $response = [
                'success'=>false,
                'msg'=>"Referral Bonus is Empty!"
            ];
            return $response;
        }
    }
}
