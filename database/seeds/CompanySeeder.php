<?php

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
        	[
                'employer_id' => 2,
                'name' => 'Company Demo',
                'description' => 'Company Description Testing',
                'address' => 'Metro Manila',
                'city' => 'Pasay City',
                'province' => 'Metro Manila',
                'region' => 'NCR',
                'phone_number' => null,
                'mobile_number' => null,
                'company_size' => '50-100',
                'created_at' => null,
                'updated_at' => null,
        	]
        ]);
    }
}
