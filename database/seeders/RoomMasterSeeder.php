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
                'room_type' => 'シングルルーム',
                'capacity' => 1,
                'image' => '',
                'explain' => 'シングルルームです',
                'facility' => '6畳のお部屋です',
                'stock' =>  10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_type' => 'ツインルーム',
                'capacity' => 2,
                'image' => '',
                'explain' => 'ツインルームです',
                'facility' => '8畳のお部屋です',
                'stock' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_type' => 'デラックスルーム',
                'capacity' => 4,
                'image' => '',
                'explain' => 'デラックスルームです',
                'facility' => '2部屋続きのお部屋です',
                'stock' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_type' => 'ロイヤルルーム',
                'capacity' => 4,
                'image' => '',
                'explain' => 'ロイヤルルームです',
                'facility' => '4部屋続きのお部屋です。個室サウナ付きです',
                'stock' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
