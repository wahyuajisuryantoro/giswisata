<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index() {
        $accessToken = env('PUBLIC_MAPBOX_ACCESS_TOKEN');
        $wisatas = Wisata::all();
        return view('frontend.home', compact('accessToken', 'wisatas'));
    }
}