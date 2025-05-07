<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRolesAndAbilities,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'code',
        'password',
        'remember_token',
        'username',
        'contact_no',
        'id_card',
        'role_id',
        'is_active',
        'upline',
        'invitation_code',
        'medal',
        'available_fund',
        'total_money',
        'unavailable_fund',
        'income',
        'credit_score',
        'shop_point',
        'account_health',
        'fund_password',
        'nric_no',
        'nric_front',
        'nric_back',
        'setup'
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

    public function user_banks()
    {
        return $this->hasMany('App\Models\UserBank');
    }

    public function user_addresses()
    {
        return $this->hasMany('App\Models\UserAddress');
    }

    public function upline_detail()
    {
        return $this->belongsTo('App\Models\User','upline');
    }

    public function user_scores()
    {
        return $this->hasMany('App\Models\UserScore')->orderBy('created_at','DESC');
    }

    public function money_records()
    {
        return $this->hasMany('App\Models\MoneyRecord')->orderBy('created_at','DESC');
    }

    public function bookings()
    {
        return $this->hasMany('App\Models\Booking')->orderBy('created_at','DESC');
    }

    public function join_records()
    {
        return $this->hasMany('App\Models\JoinRecord')->orderBy('created_at','DESC');
    }

    public function getUnavailableFundAttribute()
    {
        return round($this->bookings()->sum('total_payment')+$this->join_records()->sum('investment_amount'),2);
    }

    public function getTotalMoneyAttribute()
    {
        return round($this->unavailable_fund+$this->available_fund,2);
    }

    public function getVerificationAttribute()
    {
        if($this->setup == 0){
            $verification = "Unverified";
        }else if($this->setup == 1){
            $verification = "Pending Verification";
        }else if($this->setup == 2){
            $verification = "Verified";
        }else{
            $verification = "Verification Failed";
        };

        return $verification;
    }
}
