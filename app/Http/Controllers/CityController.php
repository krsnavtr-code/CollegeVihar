<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CityController extends Controller
{
    public function fetchCities()
    {
        $username = 'sharma_ashish'; // Replace with your GeoNames username
        $url = "http://api.geonames.org/searchJSON?country=IN&featureClass=P&maxRows=1000&username=" . urlencode($username);

        $response = Http::get($url);

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'Error fetching cities'], 500);
        }
    }
}
