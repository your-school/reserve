<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InquiriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('inquiries')->insert([
            [
                'first_name' => '名前',
                'last_name' => '太郎',
                'email' => 'test@test.com',
                'inquiry_category' => 'プランについて',
                'content' => 'テストテストテストテストテストテストテストテストテストテストテストテストテストテスト',
                'status' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'てすと',
                'last_name' => 'そのに',
                'email' => 'test2@test.com',
                'inquiry_category' => '宿泊について',
                'content' => 'テストテストテストテストテストテストテストテストテストテストテストテストテストテスト',
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'test',
                'last_name' => 'その3',
                'email' => 'test3@test.com',
                'inquiry_category' => '部屋について',
                'content' => 'テストテストテストテストテストテストテストテストテストテストテストテストテストテスト',
                'status' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
