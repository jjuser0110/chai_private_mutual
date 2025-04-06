<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;


class ProductController extends Controller
{
    public function view(Request $request)
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('single_product')->renderSections()['content'],
                'script' => view('single_product')->renderSections()['custom']
            ]);
        }
        return view('single_product');
    }

    
}
