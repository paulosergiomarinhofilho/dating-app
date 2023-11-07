<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class AppCrash extends Model
{
    use HasFactory;
    use  Uuids;
    
    protected $fillable = [
        'os','type','message','user_id'
    ];
}
