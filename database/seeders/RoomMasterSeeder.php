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
                'room_type' => 1,
                'capacity' => '1',
                'image' => '',
                'explain' => 'シングルルームです',
                'facility' => '6畳のお部屋です',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_type' => 2,
                'capacity' => '2',
                'image' => '',
                'explain' => 'ツインルームです',
                'facility' => '8畳のお部屋です',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_type' => 3,
                'capacity' => '4',
                'image' => '',
                'explain' => 'デラックスルームです',
                'facility' => '2部屋続きのお部屋です',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_type' => 4,
                'capacity' => '4',
                'image' => '',
                'explain' => 'ロイヤルルームです',
                'facility' => '4部屋続きのお部屋です。個室サウナ付きです',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
