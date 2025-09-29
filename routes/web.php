<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $urlData = [
        'full_url' => $request->fullUrl(),
        'path' => $request->path(),
        'query' => $request->query(),
    ];
    return view('home', compact('urlData'));
});

// Main route for business listings with lmid
Route::get('/{city}/{search_content}/lmid-{id}', [App\Http\Controllers\Controller::class, 'index'])
    ->name('business.listing');

// Additional routes that might be needed based on the Controller logic
Route::get('/{city}/{search}', [App\Http\Controllers\Controller::class, 'index'])
    ->where('search', '.*')
    ->name('business.search');

