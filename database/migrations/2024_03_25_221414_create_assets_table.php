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
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('asset_id');
            $table->unsignedBigInteger('localization_id');
            $table->unsignedBigInteger('person_id');
            $table->foreign('localization_id')->references('localization_id')->on('localizations');
            $table->foreign('person_id')->references('person_id')->on('persons');
            $table->string('asset_name');
            $table->text('asset_description');
            $table->string('asset_category');
            $table->string('asset_type');
            $table->date('asset_acquisition_date');
            $table->float('asset_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
