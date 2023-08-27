<?php

namespace Modules\Staff\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StaffDatabaseSeeder extends Seeder
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

        $staffData = [];

        for ($i = 1; $i <= 10; $i++) {
            $staffData[] = [
                'full_name' => 'Staff ' . $i,
                'username' => 'staff' . $i,
                'email' => 'staff' . $i . '@example.com',
                'password' => bcrypt('password'),
                // You can use any default password here
                'phone_number' => '1234567890',
                // Replace with actual phone number if available
                'role' => 'staff',
                // All records should have 'staff' role
                'is_active' => '1',
                'image_path' => null,
                // Set image_path to null for all records
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('staff')->insert($staffData);
    }
}