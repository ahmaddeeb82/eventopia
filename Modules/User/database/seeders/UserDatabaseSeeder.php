<?php

namespace Modules\User\database\seeders;

use Modules\User\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'sarah',
            'last_name' => 'nabhan',
            'username' => 'SarahNabhan',
            'email' => 'sarahnabhan@gmail.com',
            'password' => Hash::make('123456'),
            'address' => 'damascus',
            'phone_number' => '0959876049',
        ]);

        $role = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);
        Role::create(['name' => 'Organizer']);
        Role::create(['name' => 'HallOwner']);

        $user -> assignRole($role);
    }
}
