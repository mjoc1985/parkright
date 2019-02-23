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
            ]
    ]);
    }
}
