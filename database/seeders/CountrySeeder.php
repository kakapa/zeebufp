<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
                'id' => 1,
                'name' => 'South Africa',
                'code' => 'ZA',
                'currency_code' => 'ZAR',
                'currency_symbol' => 'R'
            ]
        ];

        foreach ($seeds as $seed) {
            \App\Models\Country::create($seed);
        }
    }
}
