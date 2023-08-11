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
        Schema::table('departments', function (Blueprint $table) {
            $table->text('prefix')->change(); // Change the column type to TEXT
        });
        
        DB::table('departments')->insert([
            'name' => 'โรงเรียน',
            'prefix' => 'IDD',
            'branch_id' => '-'
        ]);

        DB::table('departments')->insert([
            'name' => 'ศูนย์อบรม',
            'prefix' => 'TZ',
            'branch_id' => '-'
        ]);

        DB::table('departments')->insert([
            'name' => 'ตรอ.และพรบ.',
            'prefix' => 'INS',
            'branch_id' => '-',
        ]);

        DB::table('departments')->insert([
            'name' => 'พัฒนาธุรกิจ',
            'prefix' => 'BD',
            'branch_id' => '1'
        ]);

        DB::table('departments')->insert([
            'name' => 'ผู้อำนวยการกลุ่มงานบัญชีและบริหารเงิน',
            'prefix' => json_encode(['FIN', 'ACC']),
            'branch_id' => '-',
        ]);

        DB::table('departments')->insert([
            'name' => 'ผู้อำนวยการกลุ่มงานสำนักงาน',
            'prefix' => json_encode(['IDS', 'PUR', 'HR', 'AD']),
            'branch_id' => '-',
        ]);

        DB::table('departments')->insert([
            'name' => 'ผู้อำนวยการกลุ่มงานเทคโนโลยีสารสนเทศและกฏหมาย',
            'prefix' => json_encode(['ITI', 'LEG', 'ISO']),
            'branch_id' => '-',
        ]);

        DB::table('departments')->insert([
            'name' => 'ผู้อำนวยการกลุ่มงานธุรกิจโรงเรียนและศูนย์อบรม',
            'prefix' => json_encode(['IDD', 'TZ']),
            'branch_id' => '-',
        ]);

        DB::table('departments')->insert([
            'name' => 'ผู้อำนวยการกลุ่มงานธุรกิจตรอ.และพรบ.',
            'prefix' => json_encode(['INS']),
            'branch_id' => '-',
        ]);

        DB::table('departments')->insert([
            'name' => 'ผู้อำนวยการกลุ่มงานธุรกิจโครงการและนวัตกรรม',
            'prefix' => json_encode(['PM', 'IDC']),
            'branch_id' => '-',
        ]);

        DB::table('departments')->insert([
            'name' => 'ผู้อำนวยการกลุ่มงานกลยุทธ์',
            'prefix' => json_encode(['SALE', 'MKT', 'BD']),
            'branch_id' => '-',
        ]);

        DB::table('departments')->insert([
            'name' => 'COO',
            'prefix' => json_encode(['IDD', 'TZ', 'INS', 'PM', 'IDC', 'SALE', 'MKT', 'BD']),
            'branch_id' => '-',
        ]);

        DB::table('departments')->insert([
            'name' => 'CFO',
            'prefix' => json_encode(['FIN', 'ACC', 'IDS', 'PUR', 'HR', 'AD', 'ITI', 'LEG', 'ISO']),
            'branch_id' => '-',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
