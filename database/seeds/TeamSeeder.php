<?php

use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['doremon', 'bug', 'nobita', 'chaien', 'xeko'];
        if (!\App\Models\Team::first()) {
            foreach (range(1, count($name) - 1) as $index) {
                DB::table('teams')->insert([
                    'name' => $name[$index]
                ]);
            }
        }

    }
}
