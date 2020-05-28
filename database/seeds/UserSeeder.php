<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	[
                'name' => 'Admin Demo', 
                'email' => 'admindemo@test.com',
                'role_id' => 1,
                'password' => app('hash')->make('password1234'),
                'api_token' => Str::random(80),
                'employer_id' => null,
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
        	],
            [
                'name' => 'Employer Demo', 
                'email' => 'employerdemo@test.com',
                'role_id' => 2,
                'password' => app('hash')->make('password1234'),
                'api_token' => Str::random(80),
                'employer_id' => null,
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'name' => 'Recruiter Demo', 
                'email' => 'recruiterdemo@test.com',
                'role_id' => 3,
                'password' => app('hash')->make('password1234'),
                'api_token' => Str::random(80),
                'employer_id' => 2,
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
            ]
        ]);
    }
}
