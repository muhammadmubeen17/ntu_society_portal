<?php

namespace Modules\Students\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StudentsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        $studentsData = [];

        for ($i = 1; $i <= 10; $i++) {
            $studentsData[] = [
                'full_name' => 'Student ' . $i,
                'username' => 'student' . $i,
                'email' => 'student' . $i . '@example.com',
                'password' => bcrypt('password'),
                // You can use any default password here
                'phone_number' => '1234567890',
                // Replace with actual phone number if available
                'reg_number' => 'REG-' . $i,
                // Replace with actual registration number if available
                'role' => 'member',
                // All records should have 'member' role
                'is_active' => '1',
                'image_path' => null,
                // Set image_path to null for all records
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('students')->insert($studentsData);
    }
}