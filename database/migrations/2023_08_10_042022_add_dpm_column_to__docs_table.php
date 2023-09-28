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
        Schema::table('gendocs', function (Blueprint $table) {
            $table->longText('dpm')->default('-');
        });
        Schema::table('announce_docs', function (Blueprint $table) {
            $table->longText('dpm')->default('-');
        });
        Schema::table('mou_docs', function (Blueprint $table) {
            $table->longText('dpm')->default('-');
        });
        Schema::table('project_docs', function (Blueprint $table) {
            $table->longText('dpm')->default('-');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
