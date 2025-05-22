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
        Schema::create('logs', function (Blueprint $table){
            $table->id();
            $table->foreignId('router_id')->constrained('routers')->onDelete('cascade');
            $table->dateTime('log_time');
            $table->text('message');
            $table->string('level', 50)->nullable(); // e.g., info, warning, error
            $table->boolean('processed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExist('logs');
    }
};
