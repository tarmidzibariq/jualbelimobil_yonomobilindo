<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarType;
use App\Models\User;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Car::query();

        // Filter brand (brand dari tabel cartype)
        if ($request->brand) {
            $query->where('brand', $request->brand);
        }

        // Filter sale_type
        if ($request->sale_type) {
            $query->where('sale_type', $request->sale_type);
        }

        // Filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $cars = $query->paginate(10);

        // Ambil brand unik dari CarType
        $brands = CarType::distinct()->pluck('brand');

        // Daftar pilihan sale_type dan status (bisa juga dari config/db)
        $sale_types = ['showroom' => 'Showroom', 'admin' => 'Admin'];
        $statuses = [
            'available' => 'Available',
            'pending_check' => 'Pending Check',
            'sold' => 'Sold',
            'under_review' => 'Under Review',
        ];

        return view('admin.cars.index', compact('cars', 'brands', 'sale_types', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        $brands = CarType::distinct()->pluck('brand');
        return view('admin.cars.create', compact('user','brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:1886|max:' . date('Y'),
            'price' => 'required|integer|min:0',
            'transmission' => 'required|in:manual,automatic',
            'description' => 'nullable|string',
            'service_history' => 'nullable|date',
            'fuel_type' => 'required|string|max:50',
            'mileage' => 'required|string|max:50',
            'sale_type' => 'required|in:user,showroom',
        ]);

        $car = Car::create([
            'user_id' => $request->user_id,
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'price' => $request->price,
            'transmission' => $request->transmission,
            'description' => $request->description,
            'service_history' => $request->service_history,
            'fuel_type' => $request->fuel_type,
            'mileage' => $request->mileage,
            'sale_type' => $request->sale_type,
            'status' => "pending_check",
        ]);

        return redirect()->route('admin.cars.index')->with('success', 'ID #' . $car->id . 'Car created successfully.');   

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $car = Car::with('user')->findOrFail($id);
        return view('admin.cars.partials.modal_content', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'ID #' . $car->id . ' Car deleted successfully.');
    }
}
