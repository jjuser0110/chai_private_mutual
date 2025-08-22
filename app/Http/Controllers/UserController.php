<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bank;
use App\Models\UserBank;
use App\Models\Booking;
use App\Models\JoinRecord;
use App\Models\UserAddress;
use App\Models\UserShopPointHistory;
use App\Models\UserScore;
use App\Models\Order;
use App\Models\MoneyRecord;
use App\Models\Withdraw;
use App\Models\InvitationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Exception;

class UserController extends Controller
{
    private function createInvitationCode(){
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        do {
            $code = '';
            for ($i = 0; $i < 6; $i++) {
                $code .= $characters[random_int(0, strlen($characters) - 1)];
            }
        } while (!preg_match('/[a-zA-Z]/', $code) || !preg_match('/\d/', $code));
    
        return $code;
    }

    public function submit_register(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'username' => [
                    'required',
                    'string',
                    'unique:users,username,NULL,id,deleted_at,NULL',
                    'min:8',
                    'max:25',
                    'regex:/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/'
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/^(?=.*[a-zA-Z])(?=.*\d).{8,}$/'
                ],
            ], [
                'username.min' => 'Username must be at least 8 characters.',
                'username.max' => 'Username can\'t be longer than 25 characters.',
                'username.regex' => 'Username must have both letters and numbers.',
                'username.unique' => 'Username is already in use.',
            
                'password.min' => 'Password must be at least 8 characters.',
                'password.regex' => 'Password must contain at least one letter and one number.',
                'password.confirmed' => 'Passwords do not match.',
            ]);
    
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            $invitation_code = InvitationCode::where('code',$request->invitation_code)->where('user_id',null)->first();
            if(!isset($invitation_code)){
                throw new Exception('Invalid invitation code');
            }
            // dd("A");

            $request->merge(['name'=>$request->username,'role_id'=>3,'password'=>Hash::make($request->password)]);
            $user = User::create($request->all());
            $invitation_code->update(['user_id'=>$user->id]);
            //Auth::login($user);
            return response()->json(['success'=>true,'message'=>'Register successful']);
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function submit_login(Request $request){
        try{
            $credentials = $request->validate([
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ]);
        
            // Attempt login
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful.',
                ]);
            }
            else{
                throw new Exception('Invalid credential');
            }

            throw new Exception($this->error_message());    
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function setup()
    {
        if(Auth::user()->setup == 0 || Auth::user()->setup == 4){
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'content' => view('auth.setup')->renderSections()['content'],
                    'script' => view('auth.setup')->renderSections()['custom'] ?? '',
                ]);
            }
            return view('auth.setup');
        }
        else{
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'content' => view('account')->renderSections()['content'],
                    'script' => view('account')->renderSections()['custom'] ?? '',
                ]);
            }
            return redirect()->route('index');
        }
    }

    public function submit_setup(Request $request){
        try{
            DB::beginTransaction();
            $validator = Validator::make($request->all(),[
                'nric_front' => 'required|file|image|mimes:jpg,jpeg,png,webp|max:5120',
                'nric_back' => 'required|file|image|mimes:jpg,jpeg,png,webp|max:5120',
                'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
                'email' => 'required|email',
                'contact_no' => 'required|numeric',
                'fund_password' => 'required|min:10',
                ], [
                'nric_front.required' => 'Front NRIC image is required.',
                'nric_front.image' => 'Front NRIC must be a valid image.',
                'nric_back.required' => 'Back NRIC image is required.',
                'nric_back.image' => 'Back NRIC must be a valid image.',
                'name.required' => 'Name is required.',
                'name.regex' => 'Name must contain only letters and spaces.',
                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email address.',
                'fund_password.required' => 'Fund password is required.',
                'fund_password.min' => 'Fund password must be at least 10 characters long.',
                'contact_no.required'=>'Contact no is required.',
                'contact_no.numeric'=>'Invalid contact no.'
                ]);
    
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first()); 
            }

            if(!isset($request->nric_no)){
                throw new Exception('NRIC is required.');
            }

            $nric_no = str_replace('-', '', $request->nric_no);
            // if(strlen($nric_no) < 12){
            //     throw new Exception('Invalid NRIC.');
            // }

            $timestamp = now()->timestamp;
            if ($request->hasFile('nric_front')) {
                $frontImage = $request->file('nric_front');
                $frontPath = $frontImage->storeAs(
                    "nric/".Auth::user()->id,
                    $timestamp."_front." . $frontImage->getClientOriginalExtension(),
                    'public'
                );
            }

            if($request->fund_password != $request->confirm_fund_password){
                throw new Exception('Fund passwords does not match');
            }
    
            if ($request->hasFile('nric_back')) {
                $backImage = $request->file('nric_back');
                $backPath = $backImage->storeAs(
                    "nric/".Auth::user()->id,
                    $timestamp."_back." . $backImage->getClientOriginalExtension(),
                    'public'
                );
            }
            
            $user = User::where('id', Auth::user()->id)->first();
            $user->update([
                'contact_no'=>$request->contact_no,
                'email'=>$request->email,
                'name'=>$request->name,
                'fund_password'=>$request->fund_password,
                'nric_front'=>$timestamp."_front." . $frontImage->getClientOriginalExtension(),
                'nric_back'=>$timestamp."_back." . $backImage->getClientOriginalExtension(),
                'setup'=>1,
                'nric_no'=>preg_replace('/^(\d{6})(\d{2})(\d{4})$/', '$1-$2-$3', $nric_no)
            ]);
            DB::commit();
            return response()->json(['success'=>true,'message'=>'Profile has been updated.']);
        }
        catch(Exception $e){
            DB::rollback();
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function submit_resetup(Request $request){
        try{
            if(Auth::user()->setup == 4 || Auth::user()->setup == 0){
                Auth::user()->update(['setup'=>0]);
                return response()->json(['success'=>true, 'message'=>'Re-setup account.']);
            }
            throw new Exception('There is somethibng wrong, please try again.');
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
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
        $banks = Bank::all();
       
        if (request()->ajax()) {
            $view = view('bank.add', compact('banks'))->renderSections();
            return response()->json([
                'success' => true,
                'content' => $view['content'],
                'script' => $view['custom'] ?? '',
            ]);
        }
        return view('bank.add', compact('banks'));
    }

    public function submit_add_bank(Request $request)
    {
        try{
            if (!isset($request->account_no) || !is_numeric($request->account_no) || strlen($request->account_no) < 6) {
                throw new Exception('Invalid bank account number.');
            }
            
            if (!isset($request->full_name) || !preg_match('/^[a-zA-Z\s]+$/', $request->full_name) || strlen($request->full_name) < 3) {
                throw new Exception('Invalid account holder name.');
            }

            if(!isset($request->bank_id)){
                throw new Exception('Invalid bank');
            }

            $bank = Bank::find($request->bank_id);

            if(!isset($bank)){
                throw new Exception('Invalid bank');
            }

            UserBank::create([
                'user_id'=>Auth::user()->id,
                'bank_id'=>$bank->id,
                'full_name'=>$request->full_name,
                'account_no'=>$request->account_no,
                'is_active'=>1
            ]);

            return response()->json(['success'=>true,'message'=>'Bank account has been added.']);
            throw new Exception($this->error_message());
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function submit_delete_bank(Request $request)
    {
        try{
            $bank = UserBank::where('id',$request->target)->where('user_id',Auth::user()->id)->first();
            if(!isset($bank)){
                throw new Exception('Selected bank doest not exist.');
            }
            $bank->delete();
            return response()->json(['success'=>true,'message'=>'Selected bank has been deleted.']);
            throw new Exception($this->error_message());
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function submit_update_account(Request $request){
        try{
            if (!isset($request->contact_no) || !is_numeric($request->contact_no) || strlen($request->contact_no) < 6) {
                throw new Exception('Invalid mobile number.');
            }

            if (!isset($request->id_card) || strlen($request->id_card) < 2) {
                throw new Exception('Invalid id card.');
            }
            
            if (!isset($request->name)) {
                throw new Exception('Invalid name.');
            }

            Auth::user()->update([
                'contact_no'=>$request->contact_no,
                'name'=>$request->name,
                'id_card'=>$request->id_card
            ]);

            return response()->json(['success'=>true,'message'=>'Profile has been updated.']);
            throw new Exception($this->error_message());
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function address()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('address.index')->renderSections()['content'],
                'script' => view('address.index')->renderSections()['custom'] ?? '',
            ]);
        }
        return view('address.index');
    }

    public function add_address()
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('address.add')->renderSections()['content'],
                'script' => view('address.add')->renderSections()['custom'] ?? '',
            ]);
        }
        return view('address.add');
    }

    public function submit_add_address(Request $request)
    {
        try{
            if (!isset($request->phone_no) || !is_numeric($request->phone_no) || strlen($request->phone_no) < 6) {
                throw new Exception('Invalid phone number.');
            }
            
            if (!isset($request->contact_name) || strlen($request->contact_name) < 2) {
                throw new Exception('Invalid contact name.');
            }

            if(!isset($request->address) || strlen($request->address) < 5){
                throw new Exception('Invaild address');
            }

            UserAddress::create([
                'user_id'=>Auth::user()->id,
                'contact_name'=>$request->contact_name,
                'phone_number'=>$request->phone_no,
                'address'=>$request->address,
                'is_active'=>1
            ]);

            return response()->json(['success'=>true,'message'=>'Address has been added.']);
            throw new Exception($this->error_message());
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function submit_delete_address(Request $request)
    {
        try{
            $address = UserAddress::where('id',$request->target)->where('user_id',Auth::user()->id)->first();
            if(!isset($address)){
                throw new Exception('Selected address doest not exist.');
            }
            $address->delete();
            return response()->json(['success'=>true,'message'=>'Selected address has been deleted.']);
            throw new Exception($this->error_message());
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function order(Request $request)
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'content' => view('order')->renderSections()['content'],
                'script' => view('order')->renderSections()['custom'] ?? '',
            ]);
        }
        return view('order');
    }

    public function load_order(Request $request){
        try{
            $type = !in_array($request->type,['all','shipped','not shipped','completed']) ? 'all' : $request->type;
            $query = Order::with('shop_item','user_address')->where('user_id',Auth::user()->id)->orderBy('id','ASC');
            if($type != 'all'){
                $query->where('status',$type);
            }
          //  $orders = $query->get();
            $orders = $query->get()->map(function ($order) {
                return [
                    'id' => $order->id,
                    'status' => $order->status,
                    'item_name' => optional($order->shop_item)->item_name,
                    'address' => optional($order->user_address)->address,
                    'image' => optional($order->shop_item)->thumbnail()->file_path,
                    'created_at' => $order->created_at->toDateTimeString(),
                    // add more fields as needed
                ];
            });
            return response()->json(['success'=>true,'orders'=>$orders,'message'=>'Order loaded']);
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'orders'=>[],'message'=>$e->getMessage()]);
        }
    }

    public function submit_withdraw(Request $request)
    {
        DB::beginTransaction();
        try{
            if(!isset($request->amount) || !is_numeric($request->amount)){
                throw new Exception('Invalid withdraw amount.');
            }
        
            if(Auth::user()->available_fund < $request->amount){
                throw new Exception('Insufficient amount.');
            }

            if(!isset($request->bank)){
                throw new Exception('Please select you bank account.');
            }

            if(!isset($request->fund_password) || $request->fund_password != Auth::user()->fund_password){
                throw new Exception('Invalid fund password.'); 
            }

            $bank = UserBank::where('id',$request->bank)->where('user_id',Auth::user()->id)->first();
            if(!isset($bank)){
                throw new Exception('Invalid bank account.');
            }
            
            Withdraw::create([
                'user_id'=>Auth::user()->id,
                'user_bank_id'=>$bank->id,
                'amount'=>$request->amount
            ]);

            Auth::user()->decrement('available_fund', $request->amount);
            DB::commit();
            return response()->json(['success'=>true,'message'=>'Withdraw has been submited.']);
            throw new Exception($this->error_message());
        }
        catch(Exception $e){
            DB::rollback();
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function withdraw_record()
    {
        $withdraws = Withdraw::where('user_id',Auth::user()->id)->orderBy('updated_at','DESC')->take('20')->get();
        if (request()->ajax()) {
            $view = view('record.withdraw', compact('withdraws'))->renderSections();
            return response()->json([
                'success' => true,
                'content' => $view['content'],
                'script' => $view['custom'] ?? '',
            ]);
        }
        return view('record.withdraw',compact('withdraws'));
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

    public function load_join(Request $request){
        try{
            $type = !in_array(strtolower($request->type),['running','finished']) ? 'running' : strtolower($request->type);
            $data = JoinRecord::with('product')->where('user_id',Auth::user()->id)->where('status', ucfirst($type))->orderBy('created_at','DESC')->take('20')->get();
            return response()->json(['success'=>true,'data'=>$data,'message'=>'Record loaded','type'=>$type]);
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'data'=>[],'message'=>$e->getMessage(),'type'=>$type,'qw'=>$request->type]);
        }
    }

    public function booking_record()
    {
        $records = Booking::where('user_id',Auth::user()->id)->orderBy('updated_at','DESC')->take('20')->get();
        if (request()->ajax()) {
            $view = view('record.booking',compact('records'))->renderSections();
            return response()->json([
                'success' => true,
                'content' => $view['content'],
                'script' => $view['custom'] ?? '',
            ]);
        }
        return view('record.booking',compact('records'));
    }

    public function final_payment(Request $request)
    {
        $booking = Booking::with('product')->where('id',$request->booking)->where('user_id',Auth::user()->id)->where('status', 'Pending Final Payment')->first();
        if (request()->ajax()) {
            $view = view('final_payment',compact('booking'))->renderSections();
            return response()->json([
                'success' => true,
                'content' => $view['content'],
                'script' => $view['custom'] ?? '',
            ]);
        }
        return view('final_payment',compact('booking'));
    }

    public function submit_final_payment(Request $request)
    {
        try{
            DB::beginTransaction();
            if(!isset($request->booking)){
                throw new Exception('Failed to fetch booking details, please try again.');
            }
            $booking = Booking::with('product')->where('id',$request->booking)->where('user_id',Auth::user()->id)->where('status', 'Pending Final Payment')->first();
            if(!isset($booking)){
                throw new Exception('Failed to fetch booking details, please try again.');
            }
    
            if($booking->countdown < Carbon::now()){
                throw new Exception('The booking request is expired.');
            }

            if(Auth::user()->available_fund < $booking->final_payment){
                throw new Exception('Insufficient fund');
            }
            $credit_before = Auth::user()->available_fund;
            Auth::user()->decrement('available_fund', $booking->final_payment);
            $booking->update(['status'=>'Complete Final Payment','total_payment'=>$booking->total_payment+$booking->final_payment]);
            MoneyRecord::create([
                'user_id'=>Auth::user()->id,
                'type'=>'Booking',
                'type_id'=>$booking->id,
                'before_amount'=>$credit_before,
                'amount'=>$booking->final_payment,
                'after_amount'=>Auth::user()->available_fund
            ]);
            DB::commit();
            return response()->json(['success'=>true,'message'=>"Payment submmited"]);
        }
        catch(Exception $e){
            DB::rollback();
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }

        if (request()->ajax()) {
            $view = view('final_payment',compact('booking'))->renderSections();
            return response()->json([
                'success' => true,
                'content' => $view['content'],
                'script' => $view['custom'] ?? '',
            ]);
        }
        return view('final_payment',compact('booking'));
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

    public function load_balance(Request $request){
        try{
            $data = MoneyRecord::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->take('20')->get();
            return response()->json(['success'=>true,'data'=>$data,'message'=>'Record loaded']);
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'data'=>[],'message'=>$e->getMessage()]);
        }
    }

    public function load_score(Request $request){
        try{
            $data = UserScore::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->take('20')->get();
            return response()->json(['success'=>true,'data'=>$data,'message'=>'Record loaded']);
        }
        catch(Exception $e){
            return response()->json(['success'=>false,'data'=>[],'message'=>$e->getMessage()]);
        }
    }

    function logout(){
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}
