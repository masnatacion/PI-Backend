<?php

use Illuminate\Database\Seeder;

use App\Entities\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = factory(User::class)->create([
            'username' => 'admin',
            'password' => 'admin',
            'role'     => 'admin',
        ]);

        $employee = factory(User::class)->create([
            'username' => 'ee',
            'password' => 'ee',
            'role'     => 'employee',
        ]);
    }
}
