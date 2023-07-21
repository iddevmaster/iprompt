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
        Schema::create('announce_docs', function (Blueprint $table) {
            $table->id();
            $table->string('book_num');
            $table->string('submit_by');
            $table->date('created_date');
            $table->string('type');
            $table->string('title');
            $table->string('detail');
            $table->string('use_date');
            $table->string('anno_date');
            $table->string('sign');
            $table->string('sign_name');
            $table->string('sign_position');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announce_docs');
    }
};
