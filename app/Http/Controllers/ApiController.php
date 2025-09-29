<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function fetchData(Request $request)
    {
        $apiUrl = $request->input('api_url');

        if (!$apiUrl) {
            return response()->json(['error' => 'API URL not provided'], 400);
        }

        try {
            // Fetch JSON data from the API
            $response = Http::get($apiUrl);

            // Return as JSON
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch API data',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
