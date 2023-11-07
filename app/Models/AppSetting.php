<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class AppSetting extends Model
{
    use HasFactory;
    use  Uuids;

    protected $fillable = [
        'key','value'
    ];

    protected $hidden = [ 'id', 'created_at', 'updated_at'];
}
