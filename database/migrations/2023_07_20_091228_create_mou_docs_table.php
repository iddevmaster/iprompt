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
        Schema::create('mou_docs', function (Blueprint $table) {
            $table->id();
            $table->string('submit_by');
            $table->string('type');
            $table->string('title');
            $table->string('party1');
            $table->string('parties');
            $table->string('place');
            $table->string('detail');
            $table->string('sign')->nullable();
            $table->date('created_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mou_docs');
    }
};
