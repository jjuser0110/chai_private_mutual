<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;
use App\Models\UserGameCredential;
use App\Models\GameLog;
use App\Models\UserFirstDeposit;
use App\Models\UserDepositWinLose;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GameYLController;
use Carbon\Carbon;
use App\Models\ReferralClaim;
use App\Models\ManualTransaction;
use App\Models\UserBonus;
use App\Models\UserAngpao;
use App\Models\WithdrawTransaction;
use App\Models\BankInDepositTransaction;
use App\Models\WinoverTurnoverSetting;
use App\Models\PaymentGatewayTransaction;
use App\Models\TelcoPayTransaction;


class GameController extends Controller
{
    public function game_click($game_short_name)
    {
        $game = Game::where('game_short_name',$game_short_name)->first();
        $user = Auth::user();
        $deposit = false;

        $latestCDM = BankInDepositTransaction::where('user_id', $user->id)->whereIn('status',['pending','onhold'])->orderBy('created_at', 'desc')->first();
        if(isset($latestCDM) && ($latestCDM->status == 'pending' || $latestCDM->status == 'onhold')){
            $response = [
                'success' => false,
                'msg' => 'You have a pending transaction (CDM).',
            ];
            return $response;
        }

        if(isset($game)){
            if($user->function_id>0){
                switch ($user->function_type) {
                    case 'bonus_event':
                        $game_list = UserBonus::find($user->function_id)->bonus_event->game_type??array();
                        if($user->function_id == 0){
                            $game_list = Game::pluck('id')->toArray();
                        }
                        break;
                    case 'angpao':
                        $game_list = UserAngpao::find($user->function_id)->angpao->game_type??array();
                        if($user->function_id == 0){
                            $game_list = Angpao::find(2)->game_type??array();
                        }
                        break;
                    case 'rebate':
                        $game_list = WinoverTurnoverSetting::where('type', 'rebate')->value('game_type') ?? array();
                        break;
                    
                    case 'referral':
                        $game_list = WinoverTurnoverSetting::where('type', 'referral')->value('game_type') ?? array();
                        break;

                    case 'referral_count':
                        $game_list = WinoverTurnoverSetting::where('type', 'referral_count')->value('game_type') ?? array();
                        break;
                    
                    case 'rescue':
                        $game_list = WinoverTurnoverSetting::where('type', 'rescue')->value('game_type') ?? array();
                        break;

                    case 'monthly_bonus':
                        $game_list = WinoverTurnoverSetting::where('type', 'monthly_bonus')->value('game_type') ?? array();
                        break;

                    case 'manual':
                        $game_list = ManualTransaction::where('id',$user->function_id)->value('game_type') ??array();
                        break;

                    default:
                        $game_list = Game::pluck('id')->toArray();
                }

                if(!in_array($game->id, $game_list)){
                    $response = [
                        'success' => false,
                        'msg' => 'You dont have access for this game!',
                    ];
                    return $response;
                }
            }

            $game_log = GameLog::where('user_id',$user->id)->where('different',null)->orderBy('id','DESC')->first();
            if(isset($game_log)){
                if($game_log->game_id != $game->id){
                    $this->getWalletBalance();
                }
            }

            $user_credential = UserGameCredential::where('game_id',$game->id)->where('user_id',$user->id)->first();

            if(!isset($user_credential)){
                $controller = new GameAPIController;
                $user_credential = $controller->create_account($user,$game);
            }
            
            

            if($user_credential!="ERROR"){
                $image = asset('img/games/' . $game->game_short_name . '.webp');
                $response = [
                    'success' => true,
                    'msg' => 'Success',
                    'credential' => $user_credential,
                    'image'=>$image,
                    'username'=>$user_credential->username,
                    'password'=>$user_credential->password,
                ];
            }else{
                $response = [
                    'success' => false,
                    'msg' => 'User Credential Error',
                ];
            }
        }else{
            $response = [
                'success' => false,
                'msg' => 'No Such Game!',
            ];
        }

        return $response;
    }

    public function start_game($game_short_name)
    {
        $game = Game::where('game_short_name',$game_short_name)->first();
        $user = Auth::user();

        if(isset($game)){
            $user_credential = UserGameCredential::where('game_id',$game->id)->where('user_id',$user->id)->first();
            $game_log = GameLog::where('user_id',$user->id)->where('different',null)->orderBy('id','DESC')->first();
            $controller = new GameAPIController;
            if(isset($game_log) && $game_log->game_id == $game->id){
                $openGame = $controller->openGame($user,$game,$user_credential);
                $response = [
                    'success' => true,
                    'msg' => 'Open Game',
                    'url' => $openGame['url']
                ];
            }else{
                if($user->main_wallet <=0){
                    $openGame = $controller->openGame($user,$game,$user_credential);
                    if(isset($openGame['url']) && $openGame['url']!=""){
                        $response = [
                            'success' => true,
                            'msg' => 'Success',
                            'url' => $openGame['url']
                        ];
                    }else{
                        $response = [
                            'success' => false,
                            'msg' => 'Please Top up your wallet',
                        ];
                    }
                }else{
                    $deposit = $controller->deposit($user,$game,$user_credential);
                    if($deposit['msg'] == "SUCCESS"){
                        $openGame = $controller->openGame($user,$game,$user_credential);
                        if(isset($openGame['url']) && $openGame['url']!=""){
                            $response = [
                                'success' => true,
                                'msg' => 'Deposit Success',
                                'url' => $openGame['url']
                            ];
                        }else{
                            $response = [
                                'success' => false,
                                'msg' => 'Please Top up your wallet',
                            ];
                        }
                    }else{
                        $response = [
                            'success' => false,
                            'msg' => 'Deposit Error',
                        ];
                    }
                }
            }
        }else{
            $response = [
                'success' => false,
                'msg' => 'No Such Game!',
            ];
        }

        return $response;
    }

    public function getWalletBalance(){
        $user = Auth::user();
        $game_log = GameLog::where('user_id',$user->id)->where('different',null)->orderBy('id','DESC')->first();
        if(isset($game_log)){
            $withdraw_credential = UserGameCredential::where('game_id',$game_log->game_id)->where('user_id',$user->id)->first();
            $controller = new GameAPIController;
            $get_withdraw_balance = $controller->check_balance($user,$game_log->game, $withdraw_credential);
            if($get_withdraw_balance['msg'] == "SUCCESS"){
                $amount = $get_withdraw_balance['balance'];
                $withdraw_result = $controller->withdraw($user,$game_log->game, $withdraw_credential,$game_log,$amount);
                if($withdraw_result['msg'] == "SUCCESS"){
                    if(isset($user->firstDeposit)){
                        if(Auth::user()->main_wallet <1){
                            if($user->upline>0){
                                $setting = WinoverTurnoverSetting::where('type', 'referral')->first();
                                if(isset($setting)){
                                    ReferralClaim::create([
                                        'user_first_deposit_id'=>$user->firstDeposit->id,
                                        'user_id'=>$user->upline,
                                        'downline'=>$user->id,
                                        'amount'=>$user->firstDeposit->amount,
                                        'rate'=>$setting->bonus_rate,
                                        'total_amount'=>round($user->firstDeposit->amount*$setting->bonus_rate/100,2),
                                    ]);
                                    $user->firstDeposit->update(['checked'=>0]);
                                }
                            }else{
                                $user->firstDeposit->update(['checked'=>0]);
                            }
                        }
                    }

                    $response = [
                        'status'=>true, 
                        'msg'=>$withdraw_result['msg'], 
                        'balance'=>number_format(Auth::user()->main_wallet,2)
                    ];
                }else{
                    $response = [
                        'status'=>false, 
                        'msg'=>$withdraw_result['msg']
                    ];
                }
            }else{
                $response = [
                    'status'=>false, 
                    'msg'=>$get_withdraw_balance['msg']
                ];
            }
        }else{
            $response = [
                'status'=>false, 
                'msg'=>"Nothing to refresh.."
            ];
        }
        return $response;
    }

    
}