<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Helpers\Settings;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * These are used for humanDate() and
     * humanDateTime() blade directives.
     *
     * @var array<string, mixed>
     */
    private static array $settings = [
        [
            'type'     => Settings::STRING,
            'key'      => 'date_format',
            'value'    => 'D, j M Y',
            'comment'  => 'The date format dates should be displayed in.',
            'editable' => true,
        ],
        [
            'type'     => Settings::STRING,
            'key'      => 'datetime_format',
            'value'    => 'D, j M Y, H:i',
            'comment'  => 'The datetime format dates should be displayed in.',
            'editable' => true,
        ],
        [
            'type'      => Settings::STRING,
            'key'       => 'registered_name',
            'value'     => 'Zeebundelwa Funeral Home.',
            'comment'   => 'The registered name of the business.',
            'editable'  => true,
        ],
        [
            'type'      => Settings::STRING,
            'key'       => 'registration_number',
            'value'     => '2023/123456/07',
            'comment'   => 'The registration number of the business.',
            'editable'  => true,
        ],
        [
            'type'      => Settings::STRING,
            'key'       => 'trading_name',
            'value'     => 'Zeebundelwa Funeral Home.',
            'comment'   => 'The trading name of the business.',
            'editable'  => true,
        ],
        [
            'type'      => Settings::STRING,
            'key'       => 'main_address',
            'value'     => 'Lot A1351 Amajuba Road, Sundumbili Township, Mandiini',
            'comment'   => 'The main address of the business.',
            'editable'  => true,
        ],
        [
            'type'      => Settings::STRING,
            'key'       => 'main_email',
            'value'     => 'info@zeebundelwa.co.za',
            'comment'   => 'The main email of the business.',
            'editable'  => true,
        ],
        [
            'type'      => Settings::STRING,
            'key'       => 'other_email',
            'value'     => 'help@zeebundelwa.co.za',
            'comment'   => 'The other email of the business.',
            'editable'  => true,
        ],
        [
            'type'      => Settings::STRING,
            'key'       => 'main_phone',
            'value'     => '0320610097',
            'comment'   => 'The main phone of the business.',
            'editable'  => true,
        ],
        [
            'type'      => Settings::STRING,
            'key'       => 'phone2',
            'value'     => '0836532025',
            'comment'   => 'The second phone of the business.',
            'editable'  => true,
        ],
        [
            'type'      => Settings::STRING,
            'key'       => 'other_phone',
            'value'     => '0838677800',
            'comment'   => 'The other phone of the business.',
            'editable'  => true,
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = array_merge(self::$settings, [
            //[
            //    'type'     => \Settings::,
            //    'key'      => '',
            //    'value'    => '',
            //    'comment'  => '',
            //    'editable' => true,
            //],
        ]);

        foreach ($seeds as $seed) {
            \App\Models\Setting::create($seed);
        }
    }
}