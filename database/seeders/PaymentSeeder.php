<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
                'id'    => 1,
                'title' => '',
                'slug'  => '',
            ],
        ];

        foreach ($seeds as $seed) {
            \App\Models\Model::create($seed);
        }
    }
}
