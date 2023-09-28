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
        Schema::create('gendocs', function (Blueprint $table) {
            $table->id();
            $table->string('book_num');
            $table->string('submit_by');
            $table->string('created_date');
            $table->string('type');
            $table->text('title');
            $table->text('bcreater');
            $table->text('binspector');
            $table->text('bapprover');
            $table->text('detail');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gendocs');
    }
};
