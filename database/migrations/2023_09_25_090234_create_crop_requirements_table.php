<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('crop_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crop_id');
            $table->unsignedBigInteger('variety_id');
            $table->unsignedBigInteger('soil_type_id');
            $table->unsignedBigInteger('groth_stage_id');
            $table->double('water', 8, 2);
            $table->double('nitrogen', 8, 2);
            $table->double('potassium', 8, 2);
            $table->double('phosphorus', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_requirements');
    }
};
