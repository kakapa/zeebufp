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
                'firstname' => 'Zee',
                'lastname' => 'Chiliza',
                'mobile_number' => '0838677800',
                'email' => 'zee@zeebundelwa.co.za',
                'password' => \Hash::make('90901'),
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
            [
                // 'id'    => 1,
                'role_id' => 5,
                'firstname' => 'Office',
                'lastname' => 'Admin',
                'mobile_number' => '0836532025',
                'email' => 'admin@zeebundelwa.co.za',
                'password' => \Hash::make('50501'),
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