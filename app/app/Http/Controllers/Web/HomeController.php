<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $cars = Car::with('mainPhoto')->where('status','available')->get();
        return view('web.home', compact('cars'));
    }
}
