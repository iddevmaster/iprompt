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
        Schema::table('mou_docs', function (Blueprint $table) {
            $table->renameColumn('mou_num', 'book_num');
        });
        Schema::table('project_docs', function (Blueprint $table) {
            $table->renameColumn('proj_num', 'book_num');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mou_docs', function (Blueprint $table) {
            //
        });
    }
};
