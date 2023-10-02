<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CropRequirement extends Model
{
    use HasFactory;
    protected $fillable = ['crop_id', 'variety_id', 'soil_type_id', 'groth_stage_id', 'water', 'nitrogen', 'potassium', 'phosphorus'];
}
