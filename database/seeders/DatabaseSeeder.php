<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\InvoiceMgmt;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        InvoiceMgmt::factory(50)->create();
        // User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'kishan@hyvikk.com',
        //     'password' => Hash::make('password'),
        //     'user_type' => 0
        // ]);
    }
}
