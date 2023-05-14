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
        'health_worker_id',
        'user_id', 
        'message',
        'status',
        'request_date',
        'request_time'
    ];

    public function schedule(){
        return $this->hasOne(Schedule::class, 'id', 'schedule_id')->with('healthworker');
    }
    public function medical_service(){
        return $this->hasOne(MedicalService::class, 'id', 'medical_service_id');
    }
    public function patient(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function consulted(){
        return $this->hasOne(Consultation::class, 'service_request_id', 'id')->with('healthworker');
    }
}
