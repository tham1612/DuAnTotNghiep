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
        Schema::create('template_task_tags', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\TemplateTask::class)->constrained();
            $table->foreignIdFor(\App\Models\TemplateTag::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_task_tags');
    }
};
