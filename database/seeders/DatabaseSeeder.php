<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $types = ['text', 'img'];

        for ($i=0; $i<2; $i++) {
            DB::table('task_types')->insert([
                'name' => $types[$i],
            ]);
        }
    }
}
