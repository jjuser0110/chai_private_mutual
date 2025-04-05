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

    public function index()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('index')->render()
            ]);
        }
        return view('index');
    }

    
    public function join()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('join')->render()
            ]);
        }
        return view('join');
    }

    public function shop()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('shop')->render()
            ]);
        }
        return view('shop');
    }
}
