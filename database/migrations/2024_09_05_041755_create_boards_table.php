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
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Workspace::class)->constrained();
            $table->enum('access',\App\Enums\AccessEnum::getValues());
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('comment_rights')->default(true)->comment('có quyền cmt');
            $table->boolean('add_delete_rights')->default(true)->comment('quyền thêm , xóa');
            $table->boolean('edit_workspace')->default(true)->comment('quyền sửa');
            $table->string('link_invite');
            $table->integer('complete')->default(0);
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boards');
    }
};
