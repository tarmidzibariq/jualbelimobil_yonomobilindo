<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $car = Car::orderBy('id')->paginate(5);
        return view('web.home',compact('car'));
    }
}
