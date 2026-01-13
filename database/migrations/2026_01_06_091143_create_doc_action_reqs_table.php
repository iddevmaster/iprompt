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
        Schema::create('doc_action_reqs', function (Blueprint $table) {
            $table->id();
            $table->string('dar_id');
            $table->string('doc_type');
            $table->string('book_num');
            $table->string('doc_owner');
            $table->string('action_type');
            $table->integer('created_by');
            $table->string('request_by');
            $table->string('request_at');
            $table->string('stat')->default('ยังไม่ได้ตรวจสอบ');
            $table->longText('app')->nullable();
            $table->longText('ins')->nullable();
            $table->longText('files')->nullable();
            $table->longText('shares')->nullable();
            $table->integer('is_approved')->default(0);
            $table->text('dpm')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_action_reqs');
    }
};
