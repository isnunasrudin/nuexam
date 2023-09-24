<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $role = Role::create([
            'name' => 'Super Admin'
        ]);

        Role::create(['name' => 'Sekolah']);

        \App\Models\User::create([
            'name' => 'Isnu Nasrudin',
            'email' => 'isnunas@gmail.com', 
            'password' => bcrypt('password')
        ])->syncRoles([$role]);
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
