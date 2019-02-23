<?php

use Illuminate\Database\Seeder;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Agents::insert([
           [
               'name' => 'Sky Parking Services',
               'slug' => 'SPS',
               'email' => 'bookings@skyparkingservices.co.uk'
           ] 
        ]);
    }
}
