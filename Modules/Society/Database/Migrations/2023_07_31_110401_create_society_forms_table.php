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
        Schema::create('society_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('society_id')->constrained('societies')->onDelete('cascade');
            $table->string('form_title')->nullable();
            $table->json('form_data');
            $table->boolean('active')->nullable();
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
        Schema::dropIfExists('society_forms');
    }
};
