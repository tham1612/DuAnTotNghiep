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
        Schema::create('task_members', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Task::class)->constrained();
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->boolean('follow')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_members');
    }
};
