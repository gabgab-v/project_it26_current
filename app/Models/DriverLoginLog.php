<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverLoginLog extends Model
{
    use HasFactory;
    protected $fillable = ['driver_id', 'ip_address', 'user_agent'];

}
