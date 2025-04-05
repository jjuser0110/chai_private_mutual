<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;
use App\Models\GameLog;
use App\Models\GameProblems;
use App\Models\UserGameCredential;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Exception;

class GameAPIController extends Controller
{
    public function create_account(User $user,Game $game)
    {
        $mem ="jb".Carbon::now()->timestamp;

        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $pass = substr(str_shuffle($characters), 0, 10);

        $game_details = json_decode($game->game_details, true);
        $api_url = $game_details['api_url'];
        $path = "/createplayer";
        $op = $game_details['op'];
        $secret = $game_details['secret'];

        $signature = $mem.$op.$pass.$secret;
        $sign = strtoupper(MD5($signature));

        $url = $api_url . $path;

        $data = [
            'op' => $op,
            'mem' => $mem,
            'pass' => $pass,
            'sign' => $sign,
        ];

        $response = Http::post($url, $data);
        $res = json_decode($response->getBody()->getContents());
        // dd($res->desc);
        if($res->desc == "SUCCESS"){
            $credential = UserGameCredential::create([
                'user_id'=>$user->id,
                'game_id'=>$game->id,
                'username'=>$mem,
                'password'=>$pass,
            ]);
        }else{
            return "ERROR";
        }

        return $credential;
    }

    public function deposit(User $user, Game $game ,UserGameCredential $user_credential)
    {
        $mem = $user_credential->username;
        $pass = $user_credential->password;

        $game_details = json_decode($game->game_details, true);
        $api_url = $game_details['api_url'];
        $path = "/deposit";
        $op = $game_details['op'];
        $secret = $game_details['secret'];

        $prod = $game->game_code;
        $depo_date = Carbon::now();
        $ref_no = "DEP".$depo_date->timestamp;
        $amount = $user->main_wallet;
        $signature = $amount.$mem.$op.$pass.$prod.$ref_no.$secret;
        $sign = strtoupper(MD5($signature));

        $url = $api_url . $path;

        $data = [
            'op' => $op,
            'prod' => $prod,
            'ref_no' => $ref_no,
            'amount' => $amount,
            'mem' => $mem,
            'pass' => $pass,
            'sign' => $sign,
        ];

        $response = Http::post($url, $data);
        $res = json_decode($response->getBody()->getContents());
        // dd($res);

        if($res->desc == "SUCCESS"){
            $user->update(['main_wallet'=>0]);
            $game_log = GameLog::create([
                'user_id'=>$user->id,
                'game_id'=>$game->id,
                'depo_amount'=>$amount,
                'depo_date'=>$depo_date,
                'deposit_transaction_no'=>$ref_no,
            ]);
            $game_log->wallet_logs()->create([
                'user_id'=>$user->id,
                'type'=>'deposit_game',
                'amount'=>$amount,
                'prev_amount'=>$amount,
                'total'=>0
            ]);
            $user_credential->update([
                'credit_in_game'=>$amount,
                'game_log_id'=>$game_log->id,
                'updated_date_for_credit'=>$depo_date
            ]);
            return ['msg'=>$res->desc];
        }else{
            $this->updateProblems($game->id,'deposit',$res->desc);
            return ['msg'=>$res->desc];
        }
    }

    public function openGame(User $user, Game $game ,UserGameCredential $user_credential)
    {
        $mem = $user_credential->username;
        $pass = $user_credential->password;

        $game_details = json_decode($game->game_details, true);
        $api_url = $game_details['api_url'];
        $path = "/game";
        $op = $game_details['op'];
        $secret = $game_details['secret'];
        $prod = $game->game_code;
        $type = $game->game_prod_type;
        $depo_date = Carbon::now();
        $ref_no = "DEP".$depo_date->timestamp;
        $amount = $user->main_wallet;
        $signature = $mem.$op.$pass.$prod.$type.$secret;
        $sign = strtoupper(MD5($signature));

        $url = $api_url . $path;

        $data = [
            'type' => $type,
            'h5' => 1,
            'lang' => "en-US",
            'op' => $op,
            'prod' => $prod,
            'mem' => $mem,
            'pass' => $pass,
            'sign' => $sign,
        ];

        $response = Http::post($url, $data);
        // dd($response);
        $res = json_decode($response->getBody()->getContents());
        // dd($res);
        if($res->desc == "SUCCESS"){
            return ['msg'=>$res->desc,'url'=>$res->url??''];
        }else{
            return ['msg'=>$res->desc,];
        }

    }

    public function check_balance(User $user, Game $game ,UserGameCredential $user_credential)
    {
        $mem = $user_credential->username;
        $pass = $user_credential->password;

        $game_details = json_decode($game->game_details, true);
        $api_url = $game_details['api_url'];
        $path = "/balance";
        $op = $game_details['op'];
        $secret = $game_details['secret'];
        $prod = $game->game_code;
        $signature = $mem.$op.$pass.$prod.$secret;
        $sign = strtoupper(MD5($signature));

        $url = $api_url . $path;

        $data = [
            'op' => $op,
            'prod' => $prod,
            'mem' => $mem,
            'pass' => $pass,
            'sign' => $sign,
        ];

        $response = Http::post($url, $data);
        $res = json_decode($response->getBody()->getContents());

        if($res->desc == "SUCCESS"){
            return ['msg'=>$res->desc,'balance'=>$res->balance];
        }else{
            return ['msg'=>$res->desc];
        }
    }

    public function withdraw(User $user, Game $game, UserGameCredential $user_credential, GameLog $game_log, $amount)
    {
        if($amount > 0){
            $mem = $user_credential->username;
            $pass = $user_credential->password;

            $game_details = json_decode($game->game_details, true);
            $api_url = $game_details['api_url'];
            $path = "/withdraw";
            $op = $game_details['op'];
            $secret = $game_details['secret'];
            $prod = $game->game_code;
            $with_date = Carbon::now();
            $ref_no = "WIT".$with_date->timestamp;
            $amount = $amount;
            $signature = $amount.$mem.$op.$pass.$prod.$ref_no.$secret;
            $sign = strtoupper(MD5($signature));

            $url = $api_url . $path;

            $data = [
                'op' => $op,
                'prod' => $prod,
                'ref_no' => $ref_no,
                'amount' => $amount,
                'mem' => $mem,
                'pass' => $pass,
                'sign' => $sign,
            ];

            $response = Http::post($url, $data);
            $res = json_decode($response->getBody()->getContents());
            if($res->desc == "SUCCESS"){
                $ori_main_wallet = $user->main_wallet;
                $user->update(['main_wallet'=>$ori_main_wallet+$amount]);
                $different = -$amount+$game_log->depo_amount;
                $game_log->update(['withdraw_amount'=>$amount,'withdraw_date'=>$with_date,'different'=>$different,'withdraw_transaction_no'=>$ref_no]);
                $game_log->wallet_logs()->create([
                    'user_id'=>$user->id,
                    'type'=>'withdraw_game',
                    'amount'=>$amount,
                    'prev_amount'=>$ori_main_wallet,
                    'total'=>$user->main_wallet
                ]);
                $user_credential->update([
                    'credit_in_game'=>0,
                    'game_log_id'=>$game_log->id,
                    'updated_date_for_credit'=>$with_date
                ]);
            }
            return ['msg'=>$res->desc];
        }else{
            $amount = 0;
            $with_date = Carbon::now();
            $ref_no = "WIT".$with_date->timestamp;
            $ori_main_wallet = $user->main_wallet;
            $user->update(['main_wallet'=>$ori_main_wallet+$amount]);
            $different = -$amount+$game_log->depo_amount;
            $game_log->update(['withdraw_amount'=>$amount,'withdraw_date'=>$with_date,'different'=>$different,'withdraw_transaction_no'=>$ref_no]);
            $game_log->wallet_logs()->create([
                'user_id'=>$user->id,
                'type'=>'withdraw_game',
                'amount'=>$amount,
                'prev_amount'=>$ori_main_wallet,
                'total'=>$user->main_wallet
            ]);
            $user_credential->update([
                'credit_in_game'=>0,
                'game_log_id'=>$game_log->id,
                'updated_date_for_credit'=>$with_date,
            ]);
            
            return ['msg'=>"SUCCESS"];
        }
    }

    public function updateProblems($game_id,$description,$message){
        GameProblems::create([
            'game_id'=>$game_id,
            'description'=>$description,
            'message'=>$message
        ]);
    }

}
