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
        Schema::create('natural_persons', function (Blueprint $table) {
            $table->bigIncrements('natural_person_id');
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')->references('person_id')->on('persons');
            $table->string('cpf', 11)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('natural_persons');
    }
};
