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
        Schema::create('detected_failures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('log_id')->constrained('logs')->onDelete('cascade');
            $table->string('failure_type', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('critical_level', 50)->nullable(); // e.g., low, medium, high
            $table->dateTime('detected_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detected_failures');
    }
};
