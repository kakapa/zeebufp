<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* \App\Models\Package::factory()
            ->count(10)
            ->create(); */

        $seeds = [
            [
                'id'    => 1,
                'slug'  => 'PKG001',
                'name' => 'Single Plan',
                'description' => 'For members 25yrs & below ONLY',
                'contribution' => 49,
                'coverage' => 0,
                'features' => 'Body collection, Mortuary storage, Death registration, Casket, Cross, Fresh flower, 150  Programmes, Enlarge framed photo, Hearse, Family car, Church deco, Recorded music, Photographer, Gazebo & chairs, Purified water, Green carpet, Lowering device, Tent & 150 chairs, Serving equipment, Pots, Tables & cloths',
                'status' => 'active',
                'notes' => 'R5000 Cash Back',
                'main' => true,
                'popular' => false,
            ],
            [
                'id'    => 2,
                'slug'  => 'PKG002',
                'name' => 'Basic Plan',
                'description' => 'For member plus 4 other people',
                'contribution' => 200,
                'coverage' => 0,
                'features' => 'Body collection, Mortuary storage, Death registration, Casket, Cross, Fresh flower, 150  Programmes, Enlarge framed photo, Hearse, Family car, Church deco, Recorded music, Photographer, Gazebo & chairs, Purified water, Green carpet, Lowering device, Tent & 150 chairs, Serving equipment, Pots, Tables & cloths',
                'status' => 'active',
                'notes' => 'R5000 Cash Back',
                'main' => true,
                'popular' => true,
            ],
            [
                'id'    => 3,
                'slug'  => 'PKG003',
                'name' => 'Standard Plan',
                'description' => 'For member plus 9 other people',
                'contribution' => 350,
                'coverage' => 0,
                'features' => 'Body collection, Mortuary storage, Death registration, Casket, Cross, Fresh flower, 150  Programmes, Enlarge framed photo, Hearse, Family car, Church deco, Recorded music, Photographer, Gazebo & chairs, Purified water, Green carpet, Lowering device, Tent & 150 chairs, Serving equipment, Pots, Tables & cloths',
                'status' => 'active',
                'notes' => 'R5000 Cash Back',
                'main' => true,
                'popular' => false,
            ],
            [
                'id'    => 4,
                'slug'  => 'PKG004',
                'name' => 'Premium Plan',
                'description' => 'For member plus 14 other people',
                'contribution' => 470,
                'coverage' => 0,
                'features' => 'Body collection, Mortuary storage, Death registration, Casket, Cross, Fresh flowers, 150 programmes, Enlarge framed photo, Hearse, Family car, Church decoration, Recorded music, Photographer, Gazebo with chairs, Purified water, Green carpet, Lowering device, Tent with 150 chairs, 150 serving sets, Cooking pots, Tables & cloths.',
                'status' => 'active',
                'notes' => 'R5000 Cash Back',
                'main' => true,
                'popular' => false,
            ],
            [
                'id'    => 5,
                'slug'  => 'PKG005',
                'name' => 'Executive Plan',
                'description' => 'For member plus 4 other people',
                'contribution' => 550,
                'coverage' => 0,
                'features' => 'Body collection, Mortuary storage, Death registration, Casket, Cross, Fresh flowers, Digital programmes, Enlarge framed photo, Hearse with trailer, 2x Family executive cars, Church decoration, Sound system, Photographer, Videographer, Gazebo & chairs, Purified water, Fruit juice, Fresh fruits, Green carpet, Lowering device, Marquee with 300 chairs, Serving equipment for 300, Pots, Tables & cloths',
                'status' => 'active',
                'notes' => 'R5000 Cash Back',
                'main' => true,
                'popular' => false,
            ],
        ];

        foreach ($seeds as $seed) {
            \App\Models\Package::create($seed);
        }
    }
}