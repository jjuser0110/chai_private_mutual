<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\UserRegisterHistory;
use App\Models\UserOtp;
use App\Models\User;
use App\Models\ResetPasswordOtp;
use App\Rules\ValidUser;
use App\Rules\ValidOtp;
use Carbon\Carbon;

class SMSController extends Controller
{
    private $user   = '7LDdw5ra1Y';
    private $pass   = 'RgSokHpxeSGxlRWV5QH3HhEi7YKelM0Lykg1f3oK';
    private $from   = 'ESMS';
    private $url    = 'https://sms.360.my/gw/bulk360/v3_0/send.php';

    public function __construct(){
        $this->user = urlencode($this->user);
        $this->pass = urlencode($this->pass);
        $this->url = $this->url . "?user=$this->user&pass=$this->pass&from=$this->from";
    }

    public function sendsms(Request $request) {
        $success = false;
        $validator = Validator::make($request->all(),
            [
                'username' => ['required', 'string', 'unique:users,username,NULL,id,deleted_at,NULL', 'min:8', 'max:12',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'name' => ['required', 'string', 'min:3','max:50','alpha_spaces'],
                'contact_no' => ['required', 'numeric', 'unique:users,contact_no,NULL,id,deleted_at,NULL'],
            ],
            [
                'username.min' => 'Username must be at least 8 characters.',
                'username.max' => 'Username can\'t be longer than 12 characters.',
                'username.regex' => 'Username must has alphabet and number.',
                'password.confirmed' => 'Passwords do not match.',
                'contact_no.unique' => 'Contact number is already in use.',
                'username.unique' => 'Username is already in use.',
                'name.alpha_spaces' => 'Invalid full name.',
            ]
        );

        if ($validator->fails()) {
            return [
                'msg'=>$validator->errors()->first(),
                'success'=>$success,
            ];
        }
        // dd($request->all());

        if (substr($request->contact_no, 0, 1) === '0') {
            $contact_no = substr($request->contact_no, 1);
        }else{
            $contact_no = $request->contact_no;
        }

        $request->merge(['contact_no'=>$contact_no]);
        $UserRegisterHistory = UserRegisterHistory::where('contact_no',$contact_no)->first();

        if($UserRegisterHistory){
            $last_request_time = $UserRegisterHistory->updated_at;
            $currentTime = Carbon::now();
            $timeDifference = $currentTime->diffInSeconds($last_request_time);
            if ($timeDifference < 120) {
                $cooldown = 120 - $timeDifference;
                return [
                    'msg' => "Please try again after $cooldown seconds",
                    'success' => $success,
                ];
            }
        }

        $smscode = $this->randomNum(); 
        $newnum = '61'.$contact_no; //AUD CODE
        // $newnum = '6'.$request->contact_no; //MYR CODE
        $message = 'RM0 JB7, Your Verification code is '.$smscode;

        $this->url = $this->url . "&to=".$newnum."&text=".rawurlencode($message);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $sentResult = curl_exec($ch);
        curl_close($ch);
        // dd($sentResult);
        if ($sentResult === FALSE) {
            return [
                'msg'=>'Curl failed for sending sms to crm.. '.curl_error($ch),
                'success'=>$success,
            ];;
            
        } else {
            if(isset($UserRegisterHistory)){
                $UserRegisterHistory->update($request->all());
            }else{
                $UserRegisterHistory = UserRegisterHistory::create($request->all());
            }
            $UserOtp = UserOtp::create([
                'user_register_history_id' => $UserRegisterHistory->id,
                'otp_received' => $smscode,
            ]);
            
            return [
                'msg'=>"OTP has been sent to $contact_no",
                'success'=>true,
            ];
        }
    }

    public function resetpasswordotp(Request $request) {
        // dd($request->all());
        $success = false;
        $validator = Validator::make($request->all(),
            [
                'contact_no' => ['required'],
            ]
        );
        
        if ($validator->fails()) {
            return [
                'msg'=>$validator->errors()->first(),
                'success'=>$success,
            ];
        }
        if (substr($request->contact_no, 0, 1) === '0') {
            $contact_no = substr($request->contact_no, 1);
        }else{
            $contact_no = $request->contact_no;
        }
        $user = User::where('contact_no',$contact_no)->first();
        if($user){
            $otp_requested = ResetPasswordOtp::where('user_id',$user->id)->first();
            if($otp_requested){
                $last_request_time = $otp_requested->updated_at;
                $currentTime = Carbon::now();
                $timeDifference = $currentTime->diffInSeconds($last_request_time);
                if ($timeDifference < 180) {
                    $cooldown = 180 - $timeDifference;
                    return [
                        'msg' => "Please try again after $cooldown seconds",
                        'success' => $success,
                    ];
                }
            }
            
            $phone = '61'.$user->contact_no; 
            $smscode = $this->randomNum(); 
            $message = 'JB7, Your OTP is '.$smscode;
            $this->url = $this->url . "&to=".$phone."&text=".rawurlencode($message);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $sentResult = curl_exec($ch);
            curl_close($ch);

            if ($sentResult === FALSE) {
                return [
                    'msg'=>'Curl failed for sending sms to crm.. '.curl_error($ch),
                    'success'=>$success,
                ];;
                
            } else {
                ResetPasswordOtp::updateOrCreate(
                    ['user_id' => $user->id],
                    ['otp_received' => $smscode]
                );
                
                return [
                    'msg'=>"OTP has been sent to $user->contact_no",
                    'success'=>true,
                ];
            }
        }
        else{
            return [
                'msg' => $contact_no." does not exist in JamesBond777",
                'success' => false
            ];
        }
       
    }

    private function randomNum() {
        return rand(100000, 999999);
    }
}
