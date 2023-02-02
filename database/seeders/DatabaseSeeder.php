<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table("Users")->insert([
        [
            "email"=>"haluk@gmail.com",
            "password"=>Hash::make('password'),
            "fullname"=>"Haluk",
            "company"=>"Bay Todo"
        ],
        [
            "email"=>"sait@gmail.com",
            "password"=>Hash::make('password'),
            "fullname"=>"Sait Ergün",
            "company"=>"Ron Digital"
        ]
        ]);
        DB::table("Staffs")->insert([
        [
            "fullname"=>"Oğuz",
            "age"=>27,
            "email"=>"oğuz@gmail.com",
            "password"=>Hash::make('password'),
            "creator_user_id"=>1
        ],
        [
            "fullname"=>"Numan",
            "age"=>23,
            "email"=>"numan@gmail.com",
            "password"=>Hash::make('password'),
            "creator_user_id"=>2
        ]
        ]);
        DB::table("Customers")->insert([
        [
            "fullname"=>"Berat Can",
            "age"=>26,
            "email"=>"berat@gmail.com",
            "password"=>Hash::make('password'),
            "creator_user_id"=>1
        ],
        [
            "fullname"=>"Eren Kara",
            "age"=>21,
            "email"=>"eren@gmail.com",
            "password"=>Hash::make('password'),
            "creator_user_id"=>2
        ]
        ]);
        DB::table("Services")->insert([
        [
            "job"=>"Berber",
            "describe"=>"Subay Traşı",
            "price"=>90,
            "duration"=>30,
            "creator_user_id"=>1
        ],
        [
            "job"=>"Berber",
            "describe"=>"Damat Traşı",
            "price"=>90,
            "duration"=>30,
            "creator_user_id"=>2
        ],
        [
            "job"=>"Hair Kuafor",
            "describe"=>"Saç Boyama",
            "price"=>250,
            "duration"=>120,
            "creator_user_id"=>2
        ]
        ]);
        DB::table("Meetings")->insert([
        [
            "customer_id"=>1,
            "staff_id"=>1,
            "service_id"=>1,
            "creator_user_id"=>1,
            "meeting_at"=>"2022-10-10 14:00:00",
            "duration"=> 30
        ],
        [
            "customer_id"=>2,
            "staff_id"=>2,
            "service_id"=>2,
            "creator_user_id"=>2,
            "meeting_at"=>"2022-10-10 16:00:00",
            "duration"=>30
        ]
        ]);
        DB::table("staff_to_service")->insert([
        [
            "staff_id"=> 1,
            "service_id"=> 1
        ],
        [
            "staff_id" => 2,
            "service_id" => 2
        ]
        ]);
        DB::table("user_to_meeting")->insert([
        [
            "user_id"=> 1,
            "meeting_id"=> 1
        ],
        [
            "user_id"=> 2,
            "meeting_id"=> 2
        ]
        ]);
    }
}
