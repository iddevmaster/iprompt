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
            $table->text('title');
            $table->longText('detail');
            $table->text('use_date');
            $table->text('anno_date');
            $table->longText('sign');
            $table->text('sign_name');
            $table->text('sign_position');
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
