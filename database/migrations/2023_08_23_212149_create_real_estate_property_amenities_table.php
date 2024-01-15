<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('real_estate_property_amenities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('real_estate_properties')->cascadeOnDelete();
            $table->foreignId('amenity_id')->constrained('real_estate_amenities')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('real_estate_property_amenities');
    }
};
