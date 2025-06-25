<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;

class CountryStateCitySeeder extends Seeder
{
    public function run()
    {
        // Create sample countries
        $countries = [
            [
                'name' => 'India',
                'iso2' => 'IN',
                'iso3' => 'IND',
                'phone_code' => '91',
                'currency' => 'INR',
                'currency_symbol' => '₹',
                'region' => 'Asia',
                'subregion' => 'Southern Asia',
                'is_active' => true,
            ],
            // Add more countries as needed
        ];

        foreach ($countries as $countryData) {
            $country = Country::create($countryData);

            // Create sample states for India
            if ($country->iso2 === 'IN') {
                $states = [
                    ['name' => 'Maharashtra', 'code' => 'MH'],
                    ['name' => 'Delhi', 'code' => 'DL'],
                    ['name' => 'Karnataka', 'code' => 'KA'],
                    ['name' => 'Tamil Nadu', 'code' => 'TN'],
                    ['name' => 'Uttar Pradesh', 'code' => 'UP'],
                ];

                foreach ($states as $stateData) {
                    $state = $country->states()->create([
                        'state_name' => $stateData['name'],
                        'state_short' => $stateData['code'],
                        'is_active' => true,
                    ]);

                    // Create sample cities for each state
                    $this->createSampleCities($state);
                }
            }
        }
    }


    private function createSampleCities(State $state)
    {
        $cities = [
            ['name' => 'Mumbai', 'latitude' => '19.0760', 'longitude' => '72.8777'],
            ['name' => 'Pune', 'latitude' => '18.5204', 'longitude' => '73.8567'],
            ['name' => 'Nagpur', 'latitude' => '21.1458', 'longitude' => '79.0882'],
        ];

        if ($state->state_short === 'DL') {
            $cities = [
                ['name' => 'New Delhi', 'latitude' => '28.6139', 'longitude' => '77.2090'],
                ['name' => 'North Delhi', 'latitude' => '28.7186', 'longitude' => '77.2159'],
                ['name' => 'South Delhi', 'latitude' => '28.5402', 'longitude' => '77.2114'],
            ];
        } elseif ($state->state_short === 'KA') {
            $cities = [
                ['name' => 'Bangalore', 'latitude' => '12.9716', 'longitude' => '77.5946'],
                ['name' => 'Mysore', 'latitude' => '12.2958', 'longitude' => '76.6394'],
                ['name' => 'Mangalore', 'latitude' => '12.9141', 'longitude' => '74.8560'],
            ];
        } elseif ($state->state_short === 'TN') {
            $cities = [
                ['name' => 'Chennai', 'latitude' => '13.0827', 'longitude' => '80.2707'],
                ['name' => 'Coimbatore', 'latitude' => '11.0168', 'longitude' => '76.9558'],
                ['name' => 'Madurai', 'latitude' => '9.9252', 'longitude' => '78.1198'],
            ];
        } elseif ($state->state_short === 'UP') {
            $cities = [
                ['name' => 'Lucknow', 'latitude' => '26.8467', 'longitude' => '80.9462'],
                ['name' => 'Kanpur', 'latitude' => '26.4499', 'longitude' => '80.3319'],
                ['name' => 'Varanasi', 'latitude' => '25.3176', 'longitude' => '82.9739'],
            ];
        }

        foreach ($cities as $cityData) {
            $state->cities()->create([
                'name' => $cityData['name'],
                'latitude' => $cityData['latitude'],
                'longitude' => $cityData['longitude'],
                'is_active' => true,
            ]);
        }
    }
}
