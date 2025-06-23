<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('log_id')->constrained('logs')->onDelete('cascade');
            $table->foreignId('analysis_type_id')->constrained('analysis_types');
            $table->text('description');
            $table->enum('severity_level', ['low', 'medium', 'high', 'critical'])->default('low');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('diagnosis_time')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('diagnoses');
    }
};
