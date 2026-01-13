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
            $table->longText('app')->nullable();
        });
        Schema::table('announce_docs', function (Blueprint $table) {
            $table->longText('app')->nullable();
        });
        Schema::table('mou_docs', function (Blueprint $table) {
            $table->longText('app')->nullable();
        });
        Schema::table('project_docs', function (Blueprint $table) {
            $table->longText('app')->nullable();
        });
        Schema::table('gendocs', function (Blueprint $table) {
            $table->longText('ins')->nullable();
        });
        Schema::table('announce_docs', function (Blueprint $table) {
            $table->longText('ins')->nullable();
        });
        Schema::table('mou_docs', function (Blueprint $table) {
            $table->longText('ins')->nullable();
        });
        Schema::table('project_docs', function (Blueprint $table) {
            $table->longText('ins')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gendocs', function (Blueprint $table) {
            $table->dropColumn(['app', 'ins']);
        });

        Schema::table('announce_docs', function (Blueprint $table) {
            $table->dropColumn(['app', 'ins']);
        });

        Schema::table('mou_docs', function (Blueprint $table) {
            $table->dropColumn(['app', 'ins']);
        });

        Schema::table('project_docs', function (Blueprint $table) {
            $table->dropColumn(['app', 'ins']);
        });
    }
};
