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
                'inquiry_category' => '2',
                'content' => 'テストテストテストテストテストテストテストテストテストテストテストテストテストテスト',
                'status' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'てすと',
                'last_name' => 'そのに',
                'email' => 'test2@test.com',
                'inquiry_category' => '1',
                'content' => 'テストテストテストテストテストテストテストテストテストテストテストテストテストテスト',
                'status' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'test',
                'last_name' => 'その3',
                'email' => 'test3@test.com',
                'inquiry_category' => '5',
                'content' => 'テストテストテストテストテストテストテストテストテストテストテストテストテストテスト',
                'status' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
