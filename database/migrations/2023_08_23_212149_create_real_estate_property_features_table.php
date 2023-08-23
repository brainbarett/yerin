<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_property_features', function (Blueprint $table) {
            $table->id();
			$table->foreignId('property_id')->constrained('real_estate_properties')->cascadeOnDelete();
			$table->foreignId('feature_id')->constrained('real_estate_features')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_estate_property_features');
    }
};
