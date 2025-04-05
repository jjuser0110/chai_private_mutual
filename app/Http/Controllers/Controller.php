<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\WinoverTurnoverSetting;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function upload($file, $module, $moduleId){
	    if (!empty($file)) {
            $filenameWithExt = $file->getClientOriginalName();
            
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            
            $extension = $file->getClientOriginalExtension();

            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            $latest_filename = $moduleId."/".$fileNameToStore;

            $path = $file->storeAs($module,$latest_filename,'public');

            return [
                'file_name' => $fileNameToStore,
                'file_path' => $path,
                'file_type' => $extension
            ];
	    }
    }

    public function getReferral(){
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random = substr(str_shuffle($chars), 0, 6);

        $user = User::where('referral_code',$random)->first();
        if(isset($user)){
            return getReferral();
        }else{
            return $random;
        }
    }

    public function randomPassword(){
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $random = substr(str_shuffle($chars), 0, 10);

        return $random;
    }

    public function getRate($type){
        $findsetting = WinoverTurnoverSetting::where('type',$type)->first();
        return $findsetting;
    }

    function hidePartialNumber($number) {
        // Check if the number has at least 6 characters
        if (strlen($number) >= 6) {
            // Extract the first three characters
            $prefix = substr($number, 0, 3);
            
            // Extract the last two characters
            $suffix = substr($number, -2);
            
            // Replace the characters in between with asterisks
            $hidden = $prefix . '****' . $suffix;
            
            return $hidden;
        } else {
            // If the number is too short, return it as is
            return $number;
        }
    }
}
