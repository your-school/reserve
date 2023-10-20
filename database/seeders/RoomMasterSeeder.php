<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('room_masters')->insert([
            [
                'name' => 'シングルルーム',
                'capacity' => 1,
                'image_url' => '',
                'explain' => 'シングルルームです',
                'facility' => '6畳のお部屋です',
                'stock' =>  10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ツインルーム',
                'capacity' => 2,
                'image_url' => '',
                'explain' => 'ツインルームです',
                'facility' => '8畳のお部屋です',
                'stock' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'デラックスルーム',
                'capacity' => 4,
                'image_url' => '',
                'explain' => 'デラックスルームです',
                'facility' => '2部屋続きのお部屋です',
                'stock' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ロイヤルルーム',
                'capacity' => 4,
                'image_url' => '',
                'explain' => 'ロイヤルルームです',
                'facility' => '4部屋続きのお部屋です。個室サウナ付きです',
                'stock' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
