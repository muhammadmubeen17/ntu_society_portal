<?php

namespace Modules\Society\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SocietyDatabaseSeeder extends Seeder
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

        $societyNames = [
            'Music Society',
            'Science Society',
            'Literature Society',
            'Drama Society',
            'Photography Society',
            'Chess Society',
            'Debating Society',
            'Cooking Society',
            'Football Society',
            'Tour Society',
        ];

        $borderColors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];

        $societies = [];

        foreach ($societyNames as $name) {
            $societies[] = [
                'name' => $name,
                'convener_id' => null,
                'president_id' => null,
                'border_color' => $borderColors[array_rand($borderColors)],
                'image_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('societies')->insert($societies);
    }
}
