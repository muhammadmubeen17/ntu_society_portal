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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('cascade');
            $table->foreignId('staff_id')->nullable()->constrained('staff')->onDelete('cascade');
            $table->enum('role', ['student', 'staff', 'admin'])->default('staff'); // Updated roles
            $table->enum('is_active', ['0', '1'])->default('0');
            $table->timestamps();
        });

        DB::table('users')->insert([
            'id'            => 1,
            'username'      => 'mubeenahmad',
            'email'         => 'mubeenahmad1920@gmail.com',
            'password'      => bcrypt('Test@123!'),
            'is_active'     => '1',
            'role'          => 'admin',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
