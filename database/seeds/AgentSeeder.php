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
           ],
            [
                'name' => 'LCS Meet & Greet',
                'slug' => 'LCS',
                'email' => 'bookings@lcsmeetandgreet.co.uk'
            ],
            [
                'name' => 'Park and Go',
                'slug' => 'PAG',
                'email' => 'bookings@skyparkingservices.co.uk'
            ],
            [
                'name' => 'Simply Park & Fly',
                'slug' => 'SPF',
                'email' => 'bookings@simplyparkandfly.co.uk'
            ],
            [
                'name' => 'UK Park & Fly',
                'slug' => 'UKPF',
                'email' => 'bookings@ukparkandfly.co.uk'
            ]
        ]);
    }
}
