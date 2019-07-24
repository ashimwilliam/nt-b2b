<?php

use Illuminate\Database\Seeder;

class hsncodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            $faker = Faker\Factory::create();
            $data = [
                'hsncode' => 'NT-HSN-'.$faker->randomNumber(),
                'description' => $faker->sentence,
                'wef_date' => date('Y-m-d'),
                'tax' => 18,
                'additional_tax' => 0,
                'status' => array_rand(array(0,1), 1)
            ];

            \App\Hsncode::create($data);

        }
    }
}
