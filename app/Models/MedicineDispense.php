<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineDispense extends Model
{
    use HasFactory;

    protected $table = "medicine_dispense";
    protected $fillable = [
        'diagnos_id',
        'medicine_id',
        'quantity',
        'every_take',
        'times',
        'note',
    ];

    public function medicine(){
        return $this->hasOne(Medicine::class, 'id', 'medicine_id');
    }

}