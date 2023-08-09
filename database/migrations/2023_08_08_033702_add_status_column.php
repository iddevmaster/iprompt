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
        DB::table('status')->insert([
            'name' => 'ยังไม่ได้ตรวจสอบ'
        ]);
        DB::table('status')->insert([
            'name' => 'รอตรวจสอบ'
        ]);
        DB::table('status')->insert([
            'name' => 'รออนุมัติ'
        ]);
        DB::table('status')->insert([
            'name' => 'ผ่านการอนุมัติ'
        ]);
        DB::table('status')->insert([
            'name' => 'ไม่ผ่านการตรวจสอบ'
        ]);
        DB::table('status')->insert([
            'name' => 'ไม่ผ่านการอนุมัติ'
        ]);
        Schema::table('gendocs', function (Blueprint $table) {
            $table->string('stat')->default('ยังไม่ได้ตรวจสอบ');
        });
        Schema::table('announce_docs', function (Blueprint $table) {
            $table->string('stat')->default('ยังไม่ได้ตรวจสอบ');
        });
        Schema::table('mou_docs', function (Blueprint $table) {
            $table->string('stat')->default('ยังไม่ได้ตรวจสอบ');
        });
        Schema::table('project_docs', function (Blueprint $table) {
            $table->string('stat')->default('ยังไม่ได้ตรวจสอบ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gendocs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('announce_docs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('mou_docs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('project_docs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
