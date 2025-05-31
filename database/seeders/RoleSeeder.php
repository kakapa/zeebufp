<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
                'id'    => 1,
                'slug'  => 'visitor',
                'label' => 'Visitor',
            ],
            [
                'id'    => 2,
                'slug'  => 'member',
                'label' => 'Member',
            ],
            [
                'id'    => 3,
                'slug'  => 'editor',
                'label' => 'Editor',
            ],
            [
                'id'    => 4,
                'slug'  => 'admin',
                'label' => 'Admin',
            ],
            [
                'id'    => 5,
                'slug'  => 'officer',
                'label' => 'Officer',
            ],
        ];

        foreach ($seeds as $seed) {
            \App\Models\Role::create($seed);
        }
    }
}
