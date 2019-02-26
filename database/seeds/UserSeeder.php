<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            [
            'email' => 'mike@skyparkingservices.co.uk',
            'name'  => 'Mike',
            'password' => bcrypt('secret')
            ],
            [
                'email' => 'will@skyparkingservices.co.uk',
                'name'  => 'Will',
                'password' => bcrypt('Skyhigh12345')
            ],
            [
                'email' => 'info@mcrgopark.co.uk',
                'name'  => 'Admin',
                'password' => bcrypt('secret')
            ]
    ]);
    }
}
