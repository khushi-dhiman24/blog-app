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

Route::get('/{city}/{category}/lmid-{id}', [App\Http\Controllers\Controller::class, 'index']);

