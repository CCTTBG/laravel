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
        if (Schema::hasColumn('posts', 'commenet') && !Schema::hasColumn('posts', 'comment')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->renameColumn('commenet', 'comment');
            });
        }
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('comment', 'commenet');
        });
    }
};
