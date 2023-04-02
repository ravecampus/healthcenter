<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnos extends Model
{
    use HasFactory;

    protected $table = 'diagnos';
    protected $fillable = [
        'service_request_id',
        'consultation_id',
        'diagnosis_name',
        'symtoms',
    ];

    public function medicine_dispense(){
        return $this->hasMany(MedicineDispense::class, 'diagnos_id', 'id')->with('medicine');
    }
}
