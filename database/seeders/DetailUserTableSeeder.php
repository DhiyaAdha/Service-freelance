<?php

namespace Database\Seeders;

use App\Models\DetailUser;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DetailUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $detail_user = [
            [
                'user_id' => 1,
                'photo' => '',
                'role' => 'Web Developer',
                'contact_number' => '',
                'biography' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],[
                'user_id' => 2,
                'photo' => '',
                'role' => 'UI Designer',
                'contact_number' => '',
                'biography' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
            ];
            DetailUser::insert($detail_user);

    }
}
