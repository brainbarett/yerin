<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('location_sectors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('country_id')->constrained('location_countries');
            $table->foreignId('state_id')->constrained('location_states');
            $table->foreignId('city_id')->constrained('location_cities');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('location_sectors');
    }
};
