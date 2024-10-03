<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        SiteSetting::truncate();
        $data = [
            [
                'key' => 'header_logo',
                'value' => null,
                'title' => 'Header Logo',
                'description' => null,
                'status' => 1,
                'order' => 1,
                'created_at' => Carbon::now('Asia/Kolkata'),
            ],
            [
                'key' => 'footer_logo',
                'value' => null,
                'title' => 'Footer Logo',
                'description' => null,
                'status' => 1,
                'order' => 2,
                'created_at' => Carbon::now('Asia/Kolkata'),
            ],
            [
                'key' => 'favicon',
                'value' => null,
                'title' => 'Favicon',
                'description' => null,
                'status' => 1,
                'order' => 3,
                'created_at' => Carbon::now('Asia/Kolkata'),
            ],
            [
                'key' => 'loader',
                'value' => null,
                'title' => 'Loader',
                'description' => null,
                'status' => 1,
                'order' => 4,
                'created_at' => Carbon::now('Asia/Kolkata'),
            ],
            [
                'key' => 'services_membership_plans_price',
                'value' => '$100/M',
                'title' => 'Membership Plans Price',
                'description' => null,
                'status' => 1,
                'order' => 5,
                'created_at' => Carbon::now('Asia/Kolkata')
            ],
            [
                'key' => 'services_personal_training_price',
                'value' => '$15/M',
                'title' => 'Personal Training Price',
                'description' => null,
                'status' => 1,
                'order' => 6,
                'created_at' => Carbon::now('Asia/Kolkata')
            ],
            [
                'key' => 'services_zumba_classes_price',
                'value' => '$10/M',
                'title' => 'Zumba Classes Price',
                'description' => null,
                'status' => 1,
                'order' => 7,
                'created_at' => Carbon::now('Asia/Kolkata')
            ],
            [
                'key' => 'social_facebook_url',
                'value' => 'https://facebook.com',
                'title' => 'Facebook URL',
                'description' => null,
                'status' => 1,
                'order' => 10,
                'created_at' => Carbon::now('Asia/Kolkata')
            ],
            [
                'key' => 'social_instagram_url',
                'value' => 'https://www.instagram.com',
                'title' => 'Instagram URL',
                'description' => null,
                'status' => 1,
                'order' => 12,
                'created_at' => Carbon::now('Asia/Kolkata')
            ],
            [
                'key' => 'social_youtube_url',
                'value' => 'https://youtube.com',
                'title' => 'Youtube URL',
                'description' => null,
                'status' => 1,
                'order' => 13,
                'created_at' => Carbon::now('Asia/Kolkata')
            ],
            [
                'key' => 'social_twitter_url',
                'value' => 'https://twitter.com',
                'title' => 'Twitter URL',
                'description' => null,
                'status' => 1,
                'order' => 13,
                'created_at' => Carbon::now('Asia/Kolkata')
            ]

        ];
        SiteSetting::insert($data);
    }
}
