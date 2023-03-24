<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineModel extends Model
{
    use HasFactory;

    protected $table = "medicines";
    protected $fillable = ['medicine_name', "medicine_type"];
}
