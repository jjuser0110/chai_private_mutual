<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FileAttachment;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function error_message($m){
        return 'There is something wrong, please try again.';
    }

    public function index()
    {
        $slides = FileAttachment::where('content_type','HomeBanner')->get();
        $view = view('index', compact('slides'))->renderSections();
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => $view['content'],
                'script' => $view['custom'] ?? ''
            ]);
        }
        return view('index', compact('slides'));
    }

    
    public function join()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('join')->renderSections()['content'],
                'script' => view('join')->renderSections()['custom'] ?? ''
            ]);
        }
        return view('join');
    }

    public function register()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('auth.register')->renderSections()['content'],
                'script' => view('auth.register')->renderSections()['custom'] ?? '',
                'hide_navi' => true
            ]);
        }
        return view('auth.register');
    }

    public function login()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('auth.login')->renderSections()['content'],
                'script' => view('auth.login')->renderSections()['custom'] ?? '',
                'hide_navi' => true
            ]);
        }
        return view('auth.login');
    }

    public function account()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('account')->renderSections()['content'],
                'script' => view('account')->renderSections()['custom'] ?? '',
            ]);
        }
        return view('account');
    }

    public function update_account()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('update_account')->renderSections()['content'],
                'script' => view('update_account')->renderSections()['custom'] ?? '',
            ]);
        }
        return view('update_account');
    }

    public function join_record()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('record.join')->renderSections()['content'],
                'script' => view('record.join')->renderSections()['custom'] ?? '',
            ]);
        }
        return view('record.join');
    }

    public function booking_record()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('record.booking')->renderSections()['content'],
                'script' => view('record.booking')->renderSections()['custom'] ?? '',
            ]);
        }
        return view('record.booking');
    }

    public function withdraw_record()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('record.withdraw')->renderSections()['content'],
                'script' => view('record.withdraw')->renderSections()['custom'] ?? '',
            ]);
        }
        return view('record.withdraw');
    }

    public function money_record()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('record.money')->renderSections()['content'],
                'script' => view('record.money')->renderSections()['custom'] ?? '',
            ]);
        }
        return view('record.money');
    }
    
    public function faq()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('faq')->renderSections()['content'],
                'script' => view('faq')->renderSections()['custom'] ?? '',
            ]);
        }
        return view('faq');
    }

    public function about_us()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('about_us')->renderSections()['content'],
                'script' => view('about_us')->renderSections()['custom'] ?? '',
            ]);
        }
        return view('about_us');
    }

    public function withdraw()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('withdraw')->renderSections()['content'],
                'script' => view('withdraw')->renderSections()['custom'] ?? '',
            ]);
        }
        return view('withdraw');
    }

}
