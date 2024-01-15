<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('real_estate_properties', function (Blueprint $table) {
            $table->id();

            $table->string('type');
            $table->string('reference');
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('available');

            $table->integer('bedrooms')->nullable();
            $table->integer('full_bathrooms')->nullable();
            $table->integer('half_bathrooms')->nullable();

            $table->integer('lot_area')->nullable();
            $table->integer('construction_area')->nullable();

            $table->year('construction_year')->nullable();

            $table->foreignId('location_id')->constrained('location_sectors');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('real_estate_properties');
    }
};
