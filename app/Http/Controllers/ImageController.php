<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function loadImage(Request $request)
    {
        $url = $request->input('url');
        $html = "<p><img src=\"{$url}\" style=\"max-width:100%;\"></p>";
        return response()->json(['html' => $html]);
    }
}
