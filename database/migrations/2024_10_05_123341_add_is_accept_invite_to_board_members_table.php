<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAcceptInviteToBoardMembersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('board_members', function (Blueprint $table) {
            $table->boolean('is_accept_invite')->default(0); // Thêm trường mới
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('board_members', function (Blueprint $table) {
            $table->dropColumn('is_accept_invite'); // Xóa trường khi rollback
        });
    }
}
