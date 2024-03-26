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
        Schema::create('legal_persons', function (Blueprint $table) {
            $table->bigIncrements('legal_person_id');
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')->references('person_id')->on('persons');
            $table->string('cnpj', 14)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_persons');
    }
};
