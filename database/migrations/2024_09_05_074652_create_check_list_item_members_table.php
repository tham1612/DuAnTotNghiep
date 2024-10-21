<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('check_list_item_members', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\CheckListItem::class)->constrained();
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->unique(['check_list_item_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_list_item_members');
    }
};
