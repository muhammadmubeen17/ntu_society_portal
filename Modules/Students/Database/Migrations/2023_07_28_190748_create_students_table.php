<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->string('reg_number')->nullable();
            $table->enum('role', ['president', 'member'])->default('member'); // Updated roles
            $table->enum('is_active', ['0', '1'])->default('0');
            $table->string('image_path')->nullable();
            $table->timestamps();
        });

        // DB::table('students')->insert([
        //     'id'            => 1,
        //     'full_name'     => 'Mubeen Ahmad',
        //     'username'      => 'mubeenahmad',
        //     'email'         => 'mubeenahmad1920@gmail.com',
        //     'phone_number'  => '03000000000',
        //     'reg_number'    => '19-NTU-CS-1147',
        //     'role'          => 'member',
        //     'is_active'     => '1',
        //     'password'      => bcrypt('Test@123!'),
        //     'created_at'    => Carbon::now(),
        //     'updated_at'    => Carbon::now(),
        // ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
