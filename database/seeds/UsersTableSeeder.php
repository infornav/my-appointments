<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Abel Roque',
            'email' => 'ruffo_roque@hotmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'), // password
            'remember_token' => Str::random(10),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Paciente 1',
            'email' => 'patient@hotmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'), // password
            'remember_token' => Str::random(10),
            'role' => 'patient'
        ]);

        User::create([
            'name' => 'Médico 1',
            'email' => 'doctor@hotmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'), // password
            'remember_token' => Str::random(10),
            'role' => 'doctor'
        ]);

        factory(User::class, 50)->state('patient')->create();

    }
}
