<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
                'id'    => 1,
                'fullnames' => 'Molotsi Paul',
                'initials' => 'MP',
                'surname' => 'Pilane',
                'mobile_number' => '0817825940',
                'password' => \Hash::make('11111'),
            ],
        ];

        foreach ($seeds as $seed) {
            \App\Models\User::create($seed);
        }
    }
}
