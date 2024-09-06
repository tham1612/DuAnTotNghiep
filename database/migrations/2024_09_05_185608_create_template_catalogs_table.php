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
        Schema::create('template_catalogs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\TemplateBoard::class)->constrained();
            $table->string('name');
            $table->string('image')->nullable();
            $table->integer('position');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_catalogs');
    }
};
