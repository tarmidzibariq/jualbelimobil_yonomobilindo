<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarType;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){

        // Ambil 3 review terbaru yang sudah disetujui
        $reviews = Review::where('status', 'approved')
            ->with(['car', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        $query = Car::query();

        // Filter pencarian bebas
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('brand', 'like', '%' . $request->q . '%')
                ->orWhere('model', 'like', '%' . $request->q . '%')
                ->orWhere('year', 'like', '%' . $request->q . '%');
            });
        }

        // Filter berdasarkan brand
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Filter berdasarkan jarak tempuh
        if ($request->filled('mileage')) {
            [$min, $max] = explode('-', $request->mileage);
            $query->whereBetween('mileage', [(int) $min, (int) $max]);
        }

        // Filter berdasarkan tahun
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $cars = $query->with('mainPhoto')->where('status','available')->orderBy('created_at', 'desc')->paginate(12);

        $brands = CarType::distinct()->pluck('brand');
        // $cars = Car::with('mainPhoto')->where('status','available')->get();
        return view('web.home', compact('cars', 'brands', 'reviews'));
    }
}
