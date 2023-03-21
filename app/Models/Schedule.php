<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedule';
    protected $fillable = [
        'health_worker_id',
        'day',
        'start_time',
        'end_time',
        'visible',
        'slot',
    ];
}
