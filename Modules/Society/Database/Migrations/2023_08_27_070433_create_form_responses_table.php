<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('society_id')->constrained('societies')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('form_id')->constrained('society_forms')->onDelete('cascade');
            $table->string('form_title')->nullable();
            $table->json('form_data');
            $table->enum('status', ['accept', 'pending'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_responses');
    }
};
