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
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Workspace::class)->constrained();
            $table->enum('access', \App\Enums\AccessEnum::getValues());
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('comment_permission', ['owner', 'board', 'workspace'])->default('owner')->comment('có quyền cmt');
            $table->enum('member_permission', ['owner', 'board'])->default('owner')->comment('quyền thêm , xóa');
            $table->enum('archiver_permission', ['owner', 'board'])->default('owner')->comment('quyền lưu trữ');
            $table->enum('edit_board', ['owner', 'board', 'workspace'])->default('owner')->comment('quyền sửa bảng');
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
