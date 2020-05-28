<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
        	[
        		'code' => 'ADMIN',
                'name' => 'Administrator', 
                'description' => 'Administrator',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
        	],
        	[
        		'code' => 'EMPLOYER',
                'name' => 'Employer', 
                'description' => 'Employer Account',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
        	],
            [
                'code' => 'Recruiter',
                'name' => 'Recruiter', 
                'description' => 'Recruiter Account',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
