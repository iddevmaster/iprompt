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
        Schema::create('project_docs', function (Blueprint $table) {
            $table->id();
            $table->string('proj_code');
            $table->string('submit_by');
            $table->string('type');
            $table->string('title');
            $table->string('detail');
            $table->string('sign')->nullable();
            $table->string('created_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_docs');
    }
};
