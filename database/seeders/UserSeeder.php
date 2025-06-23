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
                // 'id'    => 1,
                'role_id' => 4,
                'firstname' => 'Molotsi',
                'lastname' => 'Pilane',
                'mobile_number' => '0817825940',
                'password' => \Hash::make('11111'),
                'profiled_at' => now(),
                'mobile_verified_at' => now(),
                'settings' => json_encode([
                    'notifications' => [
                        'email_me' => true,
                        'sms_me' => true,
                        'whatsapp_me' => false,
                        'call_me' => false,
                    ]
                ])
            ],
        ];

        foreach ($seeds as $seed) {
            \App\Models\User::create($seed);
        }
    }
}