<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('model_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('image_id')->constrained('images');
            $table->morphs('imageable');
            $table->unsignedInteger('order');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('model_images');
    }
};
