<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\BankInDepositTransaction;
use App\Models\UserBank;
use App\Models\WithdrawTransaction;
use App\Events\SendNotification;
use App\Models\BonusEvent;


class CdmController extends Controller
{
    public function submit_deposit(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'amount' => ['required', 'numeric', 'gte:10']
            ],
            [
                'amount.gte' => 'Minimum deposit amount is RM10.00',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        
        $request->merge(['user_id'=>Auth::user()->id]);

        // dd($request->all());
        if(isset($request->bonus_event_id)){
            $event = BonusEvent::where('id',$request->bonus_event_id)->first();
            if($event->deposit_min > $request->amount){
                return redirect()->back()->withError("Minimum deposit amount for $event->title is RM$event->deposit_min");
            }
            //dd($event->deposit_max.' / '.$request->amount);
            else if($event->deposit_max < $request->amount){
                return redirect()->back()->withError("Maximum deposit amount for $event->title is RM$event->deposit_max");
            }
            

        }
        $bank_in_deposit = BankInDepositTransaction::create($request->all());

        if(isset($request->fileToUpload)){
            $upload = $this->upload($request->fileToUpload, 'bank_in_slip', $bank_in_deposit->id);
            $request->merge([
                'file_name'=>$upload['file_name'],
                'file_path'=>$upload['file_path'],
                'file_type'=>$upload['file_type']
            ]);
            $bank_in_deposit->file_attachments()->create($request->all());
        }

        return redirect()->route('index')->withSuccess('Deposit Submitted!');
    }
    
    public function submit_withdraw(Request $request)
    {
        // dd($request->all());
        $wallet_amount = Auth::user()->main_wallet;
        
        if($wallet_amount<$request->amount){
            return redirect()->back()->withError('Amount exceed wallet!');
        }
        if($wallet_amount <= 0){
            return redirect()->back()->withError('Unable to withdraw RM0');
        }
        // if($wallet_amount < 50){
        //     return redirect()->back()->withError('Minimum withdraw amount is RM50');
        // }
        if($wallet_amount<Auth::user()->winover_total){
            return redirect()->back()->withError('Currently winover is '.getenv('CURRENCY').number_format(Auth::user()->winover_total,2,'.',''));
        }
        $request->merge(['user_id'=>Auth::user()->id]);
        if(isset($request->user_bank_acc_id)){
            $user_bank = UserBank::find($request->user_bank_acc_id);
            $user_bank->update($request->all());
            $request->merge(['user_bank_id'=>$user_bank->id]);
        }else{
            $user_bank = UserBank::create($request->all());
            $request->merge(['user_bank_id'=>$user_bank->id]);
        }

        $withdraw_transaction = WithdrawTransaction::create($request->all());
        Auth::user()->update(['main_wallet'=>Auth::user()->main_wallet-$withdraw_transaction->amount]);
        
        return redirect()->route('index')->withSuccess('Withdraw Submitted!');

    }
}
