<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class VirtualClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i=0; $i<=100; $i++):
            DB::table('virtual_classes')
                ->insert([
                    'class_title' => $faker->company,
                    'description' => $faker->paragraph,
                    'url' => $faker->url,
                    'category_id' => 1,
                    'access' => 1,
                    'status' => 1,
                    'members_count' => 0,
                    'end_date' => today()->addYear(),
                    'class_start_time' => $faker->dateTime(),
                    'class_end_time' => $faker->dateTime(),
                    'class_days' => "1,2,3,4,5",
                    'color' => str_replace('#', '', $faker->hexColor),
                    'instructor_id' => 1,
                    'guid' => uniqid(),
                ]);
        endfor;

    }
}
