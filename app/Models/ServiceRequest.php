<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $table = 'service_request';
    protected $fillable = [
        'medical_service_id', 
        'schedule_id', 
        'user_id', 
        'message',
        'status',
    ];
}
