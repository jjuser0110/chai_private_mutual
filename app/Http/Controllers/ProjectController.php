<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\JoinRecord;
use App\Models\Booking;
use App\Models\ShopItem;
use App\Models\FileAttachment;
use App\Models\Order;
use App\Models\MoneyRecord;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\RunningNumber;
use App\Models\UserShopPointHistory;
use Exception;
use Carbon\Carbon;

class ProjectController extends Controller
{
    public function single(Request $request)
    {
        if(isset($request->project)){
            $project = Product::where('id',$request->project)->select('product_category_id','id')->first();
        }

        if (request()->ajax()) {
            if(!isset($project)){
                return response()->json([
                    'success' => false,
                    'message'=> "Project not found."
                ]);
            }
            $view = view('project.single', compact('project'))->renderSections();
            return response()->json([
                'success' => true,
                'content' => $view['content'],
                'script' => $view['custom'] ?? ''
            ]);
        }
        if(!isset($project)){
            return redirect()->route('index');
        }
        return view('project.single', compact('project'));
    }

    public function submit_project_password(Request $request){
        try{
            if(!isset($request->project)){
                throw new Exception('Invalid request.');
            }

            if(!isset($request->password)){
                throw new Exception('Invalid password');
            }

            $project = Product::where('id',$request->project)->where('is_active',1)->first();
            if(!isset($project)){
                throw new Exception('Project not found.');
            }

            if($request->password != $project->category->password){
                throw new Exception('Incorrect password');
            }

            $view = view('project.template', compact('project'))->renderSections();
            return response()->json([
                'success' => true,
                'content' => $view['content'],
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function project_category(Request $request){
        if(isset($request->category)){
            $projects = Product::where('product_category_id',$request->category)->get();
        }

        if (request()->ajax()) {
            $view = view('project.list', compact('projects'))->renderSections();
            return response()->json([
                'success' => true,
                'content' => $view['content'],
                'script' => $view['custom'] ?? ''
            ]);
        }
        return view('project.list', compact('projects'));
    }

    public function submit_project_category(Request $request){
        try{
            if(!isset($request->category)){
                throw new Exception('Invalid request.');
            }

            if(!isset($request->password)){
                throw new Exception('Invalid password');
            }

            $category = ProductCategory::where('id',$request->category)->where('is_active',1)->first();
            if(!isset($category)){
                throw new Exception('Category not found.');
            }

            if($request->password != $category->password){
                throw new Exception('Incorrect password');
            }
            return response()->json([
                'success' => true,
                'link' => route('project_category',['category'=>$category->id]),
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function submit_investment(Request $request){
        try{
            DB::beginTransaction();
            if(!isset($request->project)){
                throw new Exception('Invalid project.');
            }

            $product = Product::where('id',$request->project)->first();

            $amount = $request->amount;
            if($product->product_type == 'booking'){
                $amount = $product->investment_amount;
            }

            if(!isset($product)){
                throw new Exception('Invalid project');
            }

            if($product->product_percentage >= 100){
                throw new Exception('Selected project is no longer available invest.');
            }

            if (!Hash::check($request->password, Auth::user()->password)) {
                throw new Exception('Incorrect password');
            }

            if(!isset($amount) || !is_numeric($amount)){
                throw new Exception('Invalid amount');
            }

            if($amount < $product->investment_amount){
                throw new Exception('Minimum invest amount is '.$product->investment_amount);
            }

            if(isset($product->investment_amount_to) && $amount > $product->investment_amount_to){
                throw new Exception('Maximum invest amount is '.$product->investment_amount_to);
            }

            if(!isset($request->password)){
                throw new Exception('Invalid password');
            }

            $dup = 0;
            if($product->product_type == 'booking'){
                $dup = Booking::where('user_id',Auth::user()->id)->where('product_id',$product->id)->where('status','Running')->count();
            }
            else{
                $dup = JoinRecord::where('user_id',Auth::user()->id)->where('product_id',$product->id)->where('status','Running')->count();
            }
            if($dup > 0){
                throw new Exception('You already invest this project before.');
            }

            $credit_before = Auth::user()->available_fund;
            if($credit_before<$amount){
                throw new Exception('Wallet not enough.');
            }
            if($product->product_type == 'booking'){
                $booking_record = Booking::create([
                    'user_id'=>Auth::user()->id,
                    'product_id'=>$product->id,
                    'booking_amount'=>$amount,
                    'status'=>'Running',
                    'countdown'=>Carbon::now()->addHours(48)->format('Y-m-d H:i:s'),
                    'total_payment'=>$amount
                ]);
                $money_type_id = $booking_record->id;
                $money_type = 'Booking';
                $message = 'Booking created successfully.';
                $link = route('booking_record');
            }
            else{
                $join_record = JoinRecord::create([
                    'user_id'=>Auth::user()->id,
                    'product_id'=>$product->id,
                    'investment_amount'=>$amount,
                    'status'=>'Running'
                ]);
                $money_type_id = $join_record->id;
                $money_type = 'Join';
                $message = 'Investment created successfully.';
                $link = route('join_record');
            }
            Auth::user()->decrement('available_fund', $amount);
            MoneyRecord::create([
                'user_id'=>Auth::user()->id,
                'type'=>$money_type,
                'type_id'=>$money_type_id,
                'before_amount'=>$credit_before,
                'amount'=>$amount,
                'after_amount'=>Auth::user()->available_fund
            ]);
            DB::commit();
            return response()->json(['success'=>true,'message'=>$message,'link'=>$link ?? route('join_record') ]);
        }
        catch(Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
