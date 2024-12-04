<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
 use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // 既存の管理者データ
       Admin::firstOrCreate(
        ['email' => 'admin@example.com'], // 条件
        ['password' => Hash::make('nagoyameshi')] // 挿入データ
    );

        // 新しい管理者データ
        Admin::firstOrCreate(
        ['email' => 'admin2@example.com'], // 条件
        ['password' => Hash::make('nagoyameshi2')] // 挿入データ
    );
    }
}
