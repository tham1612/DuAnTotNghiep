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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Catalog::class)->constrained();
            $table->string('text');
            $table->text('description')->nullable();
            $table->integer('position');
            $table->string('image')->nullable();
            $table->enum('priority', \App\Enums\IndexEnum::getValues());
            $table->enum('risk', \App\Enums\IndexEnum::getValues());
            $table->float('progress')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('parent')->nullable();
            $table->integer('sortorder')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
