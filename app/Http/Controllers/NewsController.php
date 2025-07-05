<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Carbon\Carbon;
use Exception;


class NewsController extends Controller
{
    public function news()
    {
        $news = Product::all();
        if (request()->ajax()) {
            $view = view('news.list', compact('news'))->renderSections();
            return response()->json([
                'success' => true,
                'content' => $view['content'],
                'script' => $view['custom'] ?? ''
            ]);
        }
        return view('news.list', compact('news'));
    }

    public function single(Request $request)
    {
        if(isset($request->id)){
            $news = Product::where('id',$request->id)->first();
        }

        if (request()->ajax()) {
            if(!isset($news)){
                return response()->json([
                    'success' => false,
                    'message'=> "News not found."
                ]);
            }
            $view = view('news.single', compact('news'))->renderSections();
            return response()->json([
                'success' => true,
                'content' => $view['content'],
                'script' => $view['custom'] ?? ''
            ]);
        }
        if(!isset($news)){
            return redirect()->route('news.list');
        }
        return view('news.single', compact('news'));
    }
}
