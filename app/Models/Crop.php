<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'scientific_name', 'category_id', 'description', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function crop_season()
    {
        return $this->hasMany(CropSeason::class);
    }

    public function growth_stage()
    {
        return $this->hasMany(GrowthStage::class);
    }

    public function variety()
    {
        return $this->hasMany(Variety::class);
    }
}
