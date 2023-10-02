<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CropSeason extends Model
{
    use HasFactory;
    protected $fillable = ['crop_id', 'season_id'];
}
