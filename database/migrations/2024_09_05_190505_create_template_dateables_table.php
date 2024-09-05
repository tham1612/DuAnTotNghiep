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
        Schema::create('template_dateables', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('dateable_id');
            $table->string('dateable_type');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('reminder_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_dateables');
    }
};
