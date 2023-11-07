<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use Malhal\Geographical\Geographical;

use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes, Uuids;
    use Geographical;

    const LATITUDE  = 'lat';
    const LONGITUDE = 'lng';
    protected static $kilometers = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthdate',
        'gender',
        'sexual_orientation',
        'target_gender',
        'distance',
        'description_disability',
        'show_as_gender',
        
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
        'password' => 'hashed',
        'birthdate' => 'date',
        'active' => 'boolean',
        'isAdmin' => 'boolean',
    ];

    public function getBirthdateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getCreatedAtAttribute($value)
    {
        if ($value === null) {
            return null; // Retorna null se o campo for nulo no banco de dados.
        }
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
    
    public function getUpdatedAtAttribute($value)
    {
        if ($value === null) {
            return null; // Retorna null se o campo for nulo no banco de dados.
        }
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function getDeletedAtAttribute($value)
    {
        if ($value === null) {
            return null; // Retorna null se o campo for nulo no banco de dados.
        }
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }


    public function device_information(){
        return $this->hasOne('App\Models\DeviceInformation');
    }

    public static function registeredEmail($email)
    {
        return User::where('email', $email)->exists();
    }


}
