<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\Hobbies;
use App\Models\Location;
use App\Models\FamilyDetails;
use App\Models\UserDocuments;
use App\Models\ProfileBasicDetail;
use Laravel\Passport\HasApiTokens;
use App\Traits\HasPermissionsTrait;
use App\Models\ReligiousInformation;
use App\Models\ProfessionalInformation;
use App\Models\User\Booking;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'name',
        'last_name',
        'email',
        'phone',
        'password',
        'gender',
        'image',
        'authozation_no',
        'reg_no'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'access_token'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function generateCustBookingNo()
    {
        $last_customer_id_rqst = User::orderBy('id', 'desc')->whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->first();

        // $customer_id = str_replace('CUST', '', !empty($last_customer_id_rqst) ? $last_customer_id_rqst->customer_id  : 0);
        $customer_id = !empty($last_customer_id_rqst) ? $last_customer_id_rqst->customer_id  : 0;

        if (empty($customer_id)) {
            $request_id = '00001';
        } else {
            $request_id = sprintf("%05d", $customer_id + 1);
        }
        return $request_id;
    }

    public static function generateDriverBookingNo()
    {
        // // Check if any users with the 'user' role exist
        $hasUsersWithRole = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
            $query->orWhere('name', 'driver');
        })->exists();

        do {
            $randomNumbers = str_pad(rand(0, 99999), 5, "0", STR_PAD_LEFT);

            // Only check for duplicates if there are existing users with the 'user' role
            if ($hasUsersWithRole) {
                $hasDuplicates = User::whereHas('roles', function ($query) {
                    $query->where('name', 'user');
                    $query->orWhere('name', 'driver');
                })->where('customer_id', $randomNumbers)->exists();
            } else {
                $hasDuplicates = false; // No need to check for duplicates if no users exist
            }
        } while ($hasDuplicates);

        return $randomNumbers;
    }

    // public static function boot()
    // {
    //     parent::boot();
    //     self::creating(function ($model) {
    //         $model->customer_id = (string) User::generateCustBookingNo();
    //     });
    // }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function getProfileBasicDetails()
    {
        return $this->hasOne(ProfileBasicDetail::class, 'user_id');
    }

    public function getFamilyDetails()
    {
        return $this->hasOne(FamilyDetails::class, 'user_id');
    }

    public function getReligiousInformation()
    {
        return $this->hasOne(ReligiousInformation::class, 'user_id');
    }

    public function getProfessionalInformation()
    {
        return $this->hasOne(ProfessionalInformation::class, 'user_id');
    }

    public function getLocation()
    {
        return $this->hasOne(Location::class, 'user_id');
    }

    public function getHobbies()
    {
        return $this->hasOne(Hobbies::class, 'user_id');
    }
    public function getDocuments()
    {
        return $this->hasOne(UserDocuments::class, 'user_id');
    }
    public function getUserPreference()
    {
        return $this->hasOne(UserPreference::class, 'user_id');
    }
    public function getUserImage()
    {
        return $this->hasMany(UserImage::class, 'user_id');
    }
    public function getUserFavourite()
    {
        return $this->hasMany(UserFavourite::class, 'user_id');
    }
    public function otpVerify()
    {
        return $this->hasMany(OtpVerify::class, 'user_id');
    }
    public function getDriver()
    {
        return $this->hasOne(Driver::class, 'user_id');
    }

    public function getUserSubscription()
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }

    public function getUserBooking()
    {
        return $this->hasOne(Booking::class, 'user_id');
    }
}
