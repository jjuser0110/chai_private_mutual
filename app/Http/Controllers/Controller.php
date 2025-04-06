<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('index')->renderSections()['content'],
                'script' => view('index')->renderSections()['custom'] ?? ''
            ]);
        }
        return view('index');
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

    public function shop()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('shop')->renderSections()['content'],
                'script' => view('shop')->renderSections()['custom'] ?? ''
            ]);
        }
        return view('shop');
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

    public function bank_account()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('bank.index')->renderSections()['content'],
                'script' => view('bank.index')->renderSections()['custom'] ?? '',
            ]);
        }
        return view('bank.index');
    }

    public function add_bank_account()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('bank.add')->renderSections()['content'],
                'script' => view('bank.add')->renderSections()['custom'] ?? '',
            ]);
        }
        return view('bank.add');
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
