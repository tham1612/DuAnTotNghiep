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
        Schema::create('template_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\TemplateCatalog::class)->constrained();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('position');
            $table->string('image')->nullable();
            $table->enum('priority',\App\Enums\IndexEnum::getValues());
            $table->enum('risk',\App\Enums\IndexEnum::getValues());


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_tasks');
    }
};
