<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\User;

class AhmadUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Ahmad',
            'last_name' => 'Deeb',
            'username' => 'ahmaddeeb',
            'email' => 'ahmad@gmail.com',
            'password' => '123456',
            'address' => 'smlkdfjslkdf',
            'phone_number' => '0962562729',
            'photo' => 'photo',
            'money' => 100,
        ]);
    }
}
