<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('impd_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('val')->default('other');
            $table->timestamps();
        });
        DB::table('impd_types')->insert([
            'name' => 'โครงการ',
            'val' => 'proj'
        ]);
        DB::table('impd_types')->insert([
            'name' => 'สัญญา',
            'val' => 'cont'
        ]);
        DB::table('impd_types')->insert([
            'name' => 'MoU',
            'val' => 'mou'
        ]);
        DB::table('impd_types')->insert([
            'name' => 'ประกาศ',
            'val' => 'anno'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impd_types');
    }
};
