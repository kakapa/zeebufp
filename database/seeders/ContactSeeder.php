<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
                'id'    => 1,
                'user_id' => 1,
                'title' => 'Mr',
                'name'  => 'John',
                'lastname'  => 'Doe',
                'phone'  => '0147849000',
                'email'  => 'john.doe@gmail.com',
            ],
        ];

        foreach ($seeds as $seed) {
            \App\Models\Contact::create($seed);
        }
    }
}
