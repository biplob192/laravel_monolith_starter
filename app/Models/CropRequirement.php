<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CropRequirement extends Model
{
    use HasFactory;
    protected $fillable = ['crop_id', 'variety_id', 'soil_type_id', 'growth_stage_id', 'water', 'nitrogen', 'potassium', 'phosphorus'];

    public function growthStage()
    {
        return $this->belongsTo(GrowthStage::class);
    }
}
