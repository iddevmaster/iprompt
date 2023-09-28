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
        Schema::create('importeds', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('recoder');
            $table->date('receive_date');
            $table->string('book_number')->nullable();
            $table->string('receiver');
            $table->string('receiver_dpm');
            $table->string('receiver_agn');
            $table->string('receiver_brn');
            $table->text('from');
            $table->string('book_subj')->nullable();
            $table->string('respondent')->nullable();
            $table->date('resp_date')->nullable();
            $table->string('resp_time')->nullable();
            $table->string('status')->nullable();
            $table->text('note')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('importeds');
    }
};
