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
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('failure_id')->constrained('detected_failures')->onDelete('cascade');
            $table->text('action');
            $table->dateTime('action_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('performed_by', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('actions');
    }
};

