<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('societies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('convener_id')->nullable();
            $table->unsignedBigInteger('president_id')->nullable();
            $table->string('border_color')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();

            $table->foreign('convener_id')->references('id')->on('staff')->onDelete('set null');
            $table->foreign('president_id')->references('id')->on('students')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('societies');
    }
};