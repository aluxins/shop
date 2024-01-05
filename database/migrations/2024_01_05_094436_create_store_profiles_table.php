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
        Schema::create('store_profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user')->index();
            $table->string('first_name', 63);
            $table->string('last_name', 63);
            $table->string('patronymic', 63)->nullable();
            $table->string('city', 63)->nullable();
            $table->string('street_address', 255)->nullable();
            $table->string('telephone', 15);
            $table->string('about', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_profiles');
    }
};
