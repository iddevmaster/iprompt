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
        Schema::create('costs_docs', function (Blueprint $table) {
            $table->id();
            $table->string('book_num');
            $table->text('submit_by');
            $table->string('created_date');
            $table->string('type');
            $table->text('title');
            $table->text('bcreater');
            $table->text('binspector');
            $table->text('bapprover');
            $table->longText('detail');
            $table->integer('edit_count')->default(0);
            $table->string('stat')->default('ยังไม่ได้ตรวจสอบ');
            $table->longText('app')->nullable();
            $table->longText('ins')->nullable();
            $table->longText('dpm')->nullable();
            $table->longText('files')->nullable();
            $table->longText('links')->nullable();
            $table->longText('shares')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costs_docs');
    }
};
