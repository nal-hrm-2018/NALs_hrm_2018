<?php

use Illuminate\Database\Seeder;

class StatusProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['kick off', 'pending','in-progress','releasing','complete','planning'];
        if(!\App\Models\Status::first()){
            foreach (range(0,count($name)-1) as $index) {
                DB::table('statuses')->insert([
                    'name' => $name[$index]
                ]);
            }
        }
    }
}
