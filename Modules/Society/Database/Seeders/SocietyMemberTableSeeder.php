<?php

namespace Modules\Society\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SocietyMemberTableSeeder extends Seeder
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

        $members = [];

        // Assuming society with ID 1 exists, you can change the society_id accordingly if needed
        $society_id = 1;

        // Assign students with IDs from 1 to 5 as members of society 1
        for ($student_id = 1; $student_id <= 5; $student_id++) {
            $members[] = [
                'student_id' => $student_id,
                'society_id' => $society_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('society_members')->insert($members);
    }
}
