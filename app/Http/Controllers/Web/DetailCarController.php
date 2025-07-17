<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class DetailCarController extends Controller
{
    public function index($id)  {

        $car = Car::with('carPhoto', 'mainPhoto')->findOrFail($id);
        
        if ($car->status == "available") {
            return view('web.detailMobil', compact('car'));
        }else{
            return  view('errors.404');
        }
    }
}
