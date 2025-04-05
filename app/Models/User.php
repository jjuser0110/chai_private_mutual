<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserBonus;
use App\Models\UserAngpao;
use App\Models\ReferralTransaction;
use App\Models\ReferralCountTransaction;
use App\Models\ManualTransaction;
use App\Models\UserRebate;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'remember_token',
        'role_id',
        'is_active',
        'reg_date',
        'event_wallet',
        'is_banned',
        'live_chat_nickname',
        'contact_no',
        'hidden_contact_no',
        'remarks',
        'referral_code',
        'staff_tips_wallet',
        'main_wallet',
        'last_login',
        'upline',
        'winover_rate',
        'winover_amount',
        'winover_total',
        'turnover_rate',
        'turnover_amount',
        'turnover_total',
        'function_type',
        'function_id',
        'user_otp_id',
        'star_at',
        'date_of_birth',
        'whatsapp_check',
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
    
    public function activity_logs()
    {
        return $this->hasMany('App\Models\ActivityLog');
    }
    
    public function tips_transactions()
    {
        return $this->hasMany('App\Models\TipTransaction','from_user_id');
    }
    
    public function withdrawal()
    {
        return $this->hasMany('App\Models\WithdrawTransaction')->orderBy('updated_at','DESC')->take(10);
    }

    public function user_wallet()
    {
        return $this->hasMany('App\Models\UserWallet');
    }

    public function user_bank()
    {
        return $this->hasOne('App\Models\UserBank')->where('is_active',1);
    }

    public function user_banks()
    {
        return $this->hasMany('App\Models\UserBank');
    }

    public function user_bonus()
    {
        return $this->hasMany('App\Models\UserBonus')->orderBy('claim_date','DESC')->take(5);
    }

    public function user_angpao()
    {
        return $this->hasMany('App\Models\UserAngpao')->orderBy('claim_date','DESC')->take(5);
    }

    public function wallet_logs()
    {
        return $this->morphMany('App\Models\UserWalletLog', 'content');
    }

    public function referr()
    {
        return $this->hasMany('App\Models\User','upline');
    }

    public function referr_count()
    {
        return $this->hasMany('App\Models\User','upline')->count();
    }
    
    public function myupline()
    {
        return $this->belongsTo('App\Models\User','upline');
    }

    public function game_credentials()
    {
        return $this->hasMany('App\Models\UserGameCredential');
    }

    public function login_logs()
    {
        return $this->hasMany('App\Models\LoginLog');
    }

    public function game_logs()
    {
        return $this->hasMany('App\Models\GameLog')->orderBy('updated_at','DESC');
    }

    public function last_log()
    {
        return $this->hasOne('App\Models\LoginLog')->latest();
    }

    public function referral_count()
    {
        return $this->hasMany('App\Models\ReferralCount');
    }
    
    public function referral_claim()
    {
        return $this->hasMany('App\Models\ReferralClaim');
    }

    public function referral_not_yet_claim()
    {
        return $this->hasMany('App\Models\ReferralClaim')->where('claim_date',null)->orderBy('id','desc');
    }

    public function referral_claim_from_downline()
    {
        return $this->hasOne('App\Models\ReferralClaim','downline');
    }

    public function getClaimPackageAttribute()
    {
        if($this->function_id>0){
            if($this->function_type == "bonus_event"){
                $data = UserBonus::find($this->function_id);
                return $data->bonus_event->title??'';
            }else if($this->function_type == "angpao"){
                $data = UserAngpao::find($this->function_id);
                return $data->angpao->title??'';
            }else if($this->function_type == "referral"){
                return "Referral Bonus";
            }else if($this->function_type == "manual"){
                return "Manual Transaction";
            }else{
                return "No Bonus";
            } 
        }
        return "No Bonus";
    }

    public function user_otp()
    {
        return $this->belongsTo('App\Models\UserOtp');
    }

    public function rescue_claimed()
    {
        return $this->hasMany('App\Models\UserRescueTransaction')->where('claimed_at','!=',null)->orderBy('claimed_at','DESC');
    }

    public function rebate_claimed()
    {
        return $this->hasMany('App\Models\UserRebate')->where('claimed_date','!=',null)->orderBy('claimed_date','DESC');
    }

    public function referral_claimed()
    {
        return $this->hasMany('App\Models\ReferralClaim')->where('claim_date','!=',null)->orderBy('claim_date','DESC');
    }

    public function firstDeposit()
    {
        return $this->hasOne(UserFirstDeposit::class, 'user_id')->where('checked',1);
    }

    public function today_mission()
    {
        return $this->hasMany('App\Models\UserMission')->whereDate('mission_date',Carbon::now()->format('Y-m-d'));
    }

    public function firstLevelDownlines()
    {
        return $this->hasMany(User::class, 'upline', 'id');
    }

    // Level 2 downlines
    public function secondLevelDownlines()
    {
        return $this->hasManyThrough(User::class, User::class, 'upline', 'id', 'id');
    }

    // Level 3 downlines
    public function thirdLevelDownlines()
    {
        return $this->hasManyThrough(User::class, User::class, 'upline', 'id', 'id')
            ->with('secondLevelDownlines'); // Ensure that the secondLevelDownlines are eager loaded
    }

    public function last_game_log()
    {
        return $this->hasOne('App\Models\GameLog')->where('withdraw_date',null)->latest();
    }
    
    public function hasLastGameLog()
    {
        return $this->last_game_log()->exists();
    }
}
