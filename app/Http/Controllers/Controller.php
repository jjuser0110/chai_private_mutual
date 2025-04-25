<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\FileAttachment;
use App\Models\Product;
use App\Models\ProductCategory;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function error_message($m){
        return 'There is something wrong, please try again.';
    }

    public function index()
    {
        $slides = FileAttachment::where('content_type','HomeBanner')->get();
        $projects = [];
        $categories = ProductCategory::where('is_active', 1)->get();
        foreach ($categories as $category) {
            $projects[] = [
                'name' => $category->category_name,
                'items' => Product::with('thumbnail')->where('product_category_id', $category->id)
                    ->where('display', 'like', '%home%')
                    ->where('is_active', 1)
                    ->get()
            ];
        }

        if (request()->ajax()) {
            $view = view('index', compact('slides','projects'))->renderSections();
            return response()->json([
                'success' => true,
                'content' => $view['content'],
                'script' => $view['custom'] ?? ''
            ]);
        }
        return view('index', compact('slides','projects'));
    }

    
    public function join()
    {
        $slides = FileAttachment::where('content_type','ProductBanner')->get();
        $categories = ProductCategory::where('is_active', 1)->get();
        $projects = Product::with('thumbnail')->where('display', 'like', '%join%')->where('is_active', 1)->get();
        if (request()->ajax()) {
            $view = view('join', compact('slides','categories','projects'))->renderSections();
            return response()->json([
                'success' => true,
                'content' => $view['content'],
                'script' => $view['custom'] ?? ''
            ]);
        }
        return view('join',compact('slides','categories','projects'));
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

    public function news()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('news')->renderSections()['content'],
                'script' => view('news')->renderSections()['custom'] ?? '',
            ]);
        }
        return view('news');
    }
}
