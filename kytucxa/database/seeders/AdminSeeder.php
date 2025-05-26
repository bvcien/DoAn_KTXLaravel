<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder {
    public function run() {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'msv' => 'ADMIN001',
                'name' => 'Admin',
                'password' => Hash::make('123456'),
                'role' => 0,
                'status' => 0,
                'address' => 'Hà Nội', // Thêm giá trị cho address
                'tel' => '0123456789', // Nếu các trường khác cũng không có giá trị mặc định, hãy bổ sung
                'date' => now(), 
            ]
        );        
    }
}
