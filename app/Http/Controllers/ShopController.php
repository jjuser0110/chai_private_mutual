<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\ShopItem;
use App\Models\FileAttachment;
use App\Models\Order;
use Exception;

class ShopController extends Controller
{

    function generateOrderNumber(){
        return '834768927893';
    }

    public function shop()
    {

        $items = ShopItem::where('is_active',1)->get();
        $slides = FileAttachment::where('content_type','ShopBanner')->get();
        if (request()->ajax()) {
            $view = view('shop', compact('items', 'slides'))->renderSections();
            return response()->json([
                'success' => true,
                'content' => $view['content'],
                'script' => $view['custom'] ?? ''
            ]);
        }
        return view('shop', compact('items', 'slides'));
    }

    public function view(Request $request)
    {
        $item = ShopItem::where('id',$request->id)->first();
        $images = FileAttachment::where('content_type','App\Models\ShopItem')->where('content_id',$item->id)->get();
        if (request()->ajax()) {
            $view = view('single_product', compact('item','images'))->renderSections();
            return response()->json([
                'success' => true,
                'content' => $view['content'],
                'script' => $view['custom']
            ]);
        }
        return view('single_product', compact('item','images'));
    }

    public function payment(Request $request)
    {
        $item = ShopItem::where('id',$request->id)->first();
        if(!isset($request->address)){
            $address = UserAddress::where('user_id',Auth::user()->id)->where('is_active',1)->first();
        }
        else{
            $address = UserAddress::where('id',$request->address)->where('user_id',Auth::user()->id)->first();
        }
        $images = FileAttachment::where('content_type','App\Models\ShopItem')->where('content_id',$item->id)->get();
        if (request()->ajax()) {
            $view = view('payment', compact('item','images','address'))->renderSections();
            return response()->json([
                'success' => true,
                'content' => $view['content'],
                'script' => $view['custom']
            ]);
        }
        return view('payment', compact('item','images','address'));
    }

    public function submit_payment(Request $request)
    {
        DB::beginTransaction();
        try{
            $item = ShopItem::where('id',$request->item)->first();
            $address = UserAddress::where('id',$request->address)->first();

            if(!isset($item)){
                throw new Exception('Failed to get item information.');
            }

            if($item->is_active != 1){
                throw new Exception('Selected item is no longer available.');
            }

            if(Auth::user()->shop_point < $item->item_point){
                throw new Exception('Insufficient point');
            }

            if(!isset($address)){
                throw new Exception('Please input your address.');
            }

            if($address->user_id != Auth::user()->id){
                throw new Exception('Invalid address');
            }

            Order::create([
                'user_id'=>Auth::user()->id,
                'order_no'=>$this->generateOrderNumber(),
                'shop_item_id'=>$item->id,
                'user_address_id'=>$address->id,
                'status'=>'not shipped'
            ]);
            
            Auth::user()->decrement('shop_point', $item->item_point);
            DB::commit();
            return response()->json(['success'=>true,'message'=>'Order has been placed.']);
            throw new Exception($this->error_message());
        }
        catch(Exception $e){
            DB::rollback();
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }
}
