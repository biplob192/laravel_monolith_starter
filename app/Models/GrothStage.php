<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrothStage extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'crop_id', 'status'];
}
