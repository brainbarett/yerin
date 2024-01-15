<?php

use App\Enums\RealEstate\RentTerms;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('real_estate_property_listings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('property_id')->constrained('real_estate_properties');

            $table->enum('type', ['SALE', 'RENT']);
            $table->integer('price');
            $table->enum('term', RentTerms::names())->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('real_estate_property_listings');
    }
};
