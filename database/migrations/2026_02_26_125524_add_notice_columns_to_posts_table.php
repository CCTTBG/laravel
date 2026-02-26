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
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('is_notice')->default(false);    // 공지 여부
            $table->timestamp('notice_start_at')->nullable();       // 공지 시작
            $table->timestamp('notice_end_at')->nullable();         // 공지 종료
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'is_notice',
                'notice_start_at',
                'notice_end_at'
            ]);
        });
    }
};
