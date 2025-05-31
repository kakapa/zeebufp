<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            ['id' => 1, 'slug' => 'accountant', 'label' => 'Accountant'],
            ['id' => 2, 'slug' => 'actor', 'label' => 'Actor'],
            ['id' => 3, 'slug' => 'actuary', 'label' => 'Actuary'],
            ['id' => 4, 'slug' => 'acupuncturist', 'label' => 'Acupuncturist'],
            ['id' => 5, 'slug' => 'administrator', 'label' => 'Administrator'],
            ['id' => 6, 'slug' => 'advertising-specialist', 'label' => 'Advertising Specialist'],
            ['id' => 7, 'slug' => 'aerospace-engineer', 'label' => 'Aerospace Engineer'],
            ['id' => 8, 'slug' => 'agricultural-engineer', 'label' => 'Agricultural Engineer'],
            ['id' => 9, 'slug' => 'air-traffic-controller', 'label' => 'Air Traffic Controller'],
            ['id' => 10, 'slug' => 'aircraft-mechanic', 'label' => 'Aircraft Mechanic'],
            ['id' => 11, 'slug' => 'animator', 'label' => 'Animator'],
            ['id' => 12, 'slug' => 'appliance-repairer', 'label' => 'Appliance Repairer'],
            ['id' => 13, 'slug' => 'architect', 'label' => 'Architect'],
            ['id' => 14, 'slug' => 'archivist', 'label' => 'Archivist'],
            ['id' => 15, 'slug' => 'artist', 'label' => 'Artist'],
            ['id' => 16, 'slug' => 'astronomer', 'label' => 'Astronomer'],
            ['id' => 17, 'slug' => 'athlete', 'label' => 'Athlete'],
            ['id' => 18, 'slug' => 'attorney', 'label' => 'Attorney'],
            ['id' => 19, 'slug' => 'audiologist', 'label' => 'Audiologist'],
            ['id' => 20, 'slug' => 'author', 'label' => 'Author'],
            ['id' => 21, 'slug' => 'baker', 'label' => 'Baker'],
            ['id' => 22, 'slug' => 'banker', 'label' => 'Banker'],
            ['id' => 23, 'slug' => 'barber', 'label' => 'Barber'],
            ['id' => 24, 'slug' => 'barista', 'label' => 'Barista'],
            ['id' => 25, 'slug' => 'bartender', 'label' => 'Bartender'],
            ['id' => 26, 'slug' => 'biologist', 'label' => 'Biologist'],
            ['id' => 27, 'slug' => 'blacksmith', 'label' => 'Blacksmith'],
            ['id' => 28, 'slug' => 'bricklayer', 'label' => 'Bricklayer'],
            ['id' => 29, 'slug' => 'bus-driver', 'label' => 'Bus Driver'],
            ['id' => 30, 'slug' => 'butcher', 'label' => 'Butcher'],
            ['id' => 31, 'slug' => 'carpenter', 'label' => 'Carpenter'],
            ['id' => 32, 'slug' => 'cashier', 'label' => 'Cashier'],
            ['id' => 33, 'slug' => 'chef', 'label' => 'Chef'],
            ['id' => 34, 'slug' => 'chemist', 'label' => 'Chemist'],
            ['id' => 35, 'slug' => 'civil-engineer', 'label' => 'Civil Engineer'],
            ['id' => 36, 'slug' => 'cleaner', 'label' => 'Cleaner'],
            ['id' => 37, 'slug' => 'clergy', 'label' => 'Clergy'],
            ['id' => 38, 'slug' => 'coach', 'label' => 'Coach'],
            ['id' => 39, 'slug' => 'computer-programmer', 'label' => 'Computer Programmer'],
            ['id' => 40, 'slug' => 'construction-worker', 'label' => 'Construction Worker'],
            ['id' => 41, 'slug' => 'consultant', 'label' => 'Consultant'],
            ['id' => 42, 'slug' => 'copywriter', 'label' => 'Copywriter'],
            ['id' => 43, 'slug' => 'counselor', 'label' => 'Counselor'],
            ['id' => 44, 'slug' => 'crane-operator', 'label' => 'Crane Operator'],
            ['id' => 45, 'slug' => 'customer-service-rep', 'label' => 'Customer Service Representative'],
            ['id' => 46, 'slug' => 'data-analyst', 'label' => 'Data Analyst'],
            ['id' => 47, 'slug' => 'dentist', 'label' => 'Dentist'],
            ['id' => 48, 'slug' => 'developer', 'label' => 'Developer'],
            ['id' => 49, 'slug' => 'dietitian', 'label' => 'Dietitian'],
            ['id' => 50, 'slug' => 'doctor', 'label' => 'Doctor'],
            ['id' => 51, 'slug' => 'driver', 'label' => 'Driver'],
            ['id' => 52, 'slug' => 'electrician', 'label' => 'Electrician'],
            ['id' => 53, 'slug' => 'engineer', 'label' => 'Engineer'],
            ['id' => 54, 'slug' => 'entrepreneur', 'label' => 'Entrepreneur'],
            ['id' => 55, 'slug' => 'event-planner', 'label' => 'Event Planner'],
            ['id' => 56, 'slug' => 'farmer', 'label' => 'Farmer'],
            ['id' => 57, 'slug' => 'fashion-designer', 'label' => 'Fashion Designer'],
            ['id' => 58, 'slug' => 'firefighter', 'label' => 'Firefighter'],
            ['id' => 59, 'slug' => 'fisherman', 'label' => 'Fisherman'],
            ['id' => 60, 'slug' => 'flight-attendant', 'label' => 'Flight Attendant'],
            ['id' => 61, 'slug' => 'florist', 'label' => 'Florist'],
            ['id' => 62, 'slug' => 'geologist', 'label' => 'Geologist'],
            ['id' => 63, 'slug' => 'graphic-designer', 'label' => 'Graphic Designer'],
            ['id' => 64, 'slug' => 'hairdresser', 'label' => 'Hairdresser'],
            ['id' => 65, 'slug' => 'hotel-manager', 'label' => 'Hotel Manager'],
            ['id' => 66, 'slug' => 'human-resources', 'label' => 'Human Resources Manager'],
            ['id' => 67, 'slug' => 'illustrator', 'label' => 'Illustrator'],
            ['id' => 68, 'slug' => 'interior-designer', 'label' => 'Interior Designer'],
            ['id' => 69, 'slug' => 'it-support-specialist', 'label' => 'IT Support Specialist'],
            ['id' => 70, 'slug' => 'janitor', 'label' => 'Janitor'],
            ['id' => 71, 'slug' => 'journalist', 'label' => 'Journalist'],
            ['id' => 72, 'slug' => 'judge', 'label' => 'Judge'],
            ['id' => 73, 'slug' => 'lawyer', 'label' => 'Lawyer'],
            ['id' => 74, 'slug' => 'librarian', 'label' => 'Librarian'],
            ['id' => 75, 'slug' => 'mechanic', 'label' => 'Mechanic'],
            ['id' => 76, 'slug' => 'nurse', 'label' => 'Nurse'],
            ['id' => 77, 'slug' => 'pharmacist', 'label' => 'Pharmacist'],
            ['id' => 78, 'slug' => 'pilot', 'label' => 'Pilot'],
            ['id' => 79, 'slug' => 'plumber', 'label' => 'Plumber'],
            ['id' => 80, 'slug' => 'teacher', 'label' => 'Teacher'],
            ['id' => 81, 'slug' => 'zookeeper', 'label' => 'Zookeeper'],
            ['id' => 82, 'slug' => 'other', 'label' => 'Other'],
        ];

        foreach ($seeds as $seed) {
            \App\Models\Occupation::create($seed);
        }
    }
}
