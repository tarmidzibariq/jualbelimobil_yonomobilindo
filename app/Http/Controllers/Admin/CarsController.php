<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarPhoto;
use App\Models\CarType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $cars = $query->orderBy('id', 'desc')->paginate(10);

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
        return view('admin.cars.create', compact('user', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
            'color' => 'required|string|max:50',
            'tax' => 'required|date',
            'engine' => 'required|integer|max:10000',
            'seat' => 'required|integer|max:20',
            'bpkb' => 'nullable|boolean',
            'spare_key' => 'nullable|boolean',
            'manual_book' => 'nullable|boolean',
            'service_book' => 'nullable|boolean',
            'sale_type' => 'required|in:user,showroom',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $request->merge([
                'bpkb' => $request->has('bpkb'),
                'spare_key' => $request->has('spare_key'),
                'manual_book' => $request->has('manual_book'),
                'service_book' => $request->has('service_book'),
            ]);
            DB::transaction(function () use ($request) {
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
                    'color' => $request->color,
                    'tax' => $request->tax,
                    'engine' => $request->engine,
                    'seat' => $request->seat,

                    'sale_type' => $request->sale_type,
                    'status' => "pending_check",

                    // kelengkapan tambahan
                    'bpkb' => $request->bpkb,
                    'spare_key' => $request->spare_key,
                    'manual_book' => $request->manual_book,
                    'service_book' => $request->service_book,
                ]);

                $photos = $request->file('photos', []);
                $orders = $request->input('photo_order', []);

                foreach ($photos as $i => $photo) {
                    $filename = $photo->hashName();
                    $photo->storeAs('car_photos', $filename, 'public');

                    CarPhoto::create([
                        'car_id' => $car->id,
                        'photo_url' => $filename,
                        'number' => $orders[$i] ?? ($i + 1),
                    ]);
                }
            });

            return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil ditambahkan.');

        } catch (\Exception $e) {
            // Jika error, kembali ke form dengan pesan error
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $car = Car::with('user', 'carPhoto')->findOrFail($id);
        return view('admin.cars.partials.modal_content', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $car = Car::with('carPhoto')->findOrFail($id);
        $user = User::all();
        $brands = CarType::distinct()->pluck('brand');
        return view('admin.cars.edit', compact('car','user', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $car = Car::findOrFail($id);

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
            'color' => 'required|string|max:50',
            'tax' => 'required|date',
            'engine' => 'required|integer|max:10000',
            'seat' => 'required|integer|max:20',
            'bpkb' => 'nullable|boolean',
            'spare_key' => 'nullable|boolean',
            'manual_book' => 'nullable|boolean',
            'service_book' => 'nullable|boolean',
            'sale_type' => 'required|in:user,showroom',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 🔁 Atur nilai default boolean
        $request->merge([
            'bpkb' => $request->has('bpkb'),
            'spare_key' => $request->has('spare_key'),
            'manual_book' => $request->has('manual_book'),
            'service_book' => $request->has('service_book'),
        ]);

        // update data
        $car->update($request->all());

        // 🔁 Update urutan foto lama
        $existingPhotoIds = $request->input('existing_photo_ids', []);
        $existingOrders = $request->input('existing_photo_order', []);

        foreach ($existingPhotoIds as $i => $photoId) {
            CarPhoto::where('id', $photoId)->update([
                'number' => $existingOrders[$i] ?? ($i + 1),
            ]);
        }

        // 🔁 Upload foto baru
        $newPhotos = $request->file('photos', []);
        $newOrders = $request->input('new_photo_order', []);

        foreach ($newPhotos as $i => $photo) {
            $filename = $photo->hashName();
            $photo->storeAs('car_photos', $filename, 'public');

            CarPhoto::create([
                'car_id' => $car->id,
                'photo_url' => $filename,
                'number' => $newOrders[$i] ?? ($i + 1),
            ]);
        }

        return redirect()->route('admin.cars.index')->with('success', 'ID #' . $car->id . ' Car updated successfully.');
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

    /**
     * Update the status of the car via AJAX.
     */
    public function editStatus($id)
    {
        $car = Car::findOrFail($id);
        return view('admin.cars.partials.update_status_modal', compact('car'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validasi bahwa status adalah salah satu dari 4 nilai yang diperbolehkan
        $request->validate([
            'status' => 'required|in:available,pending_check,sold,under_review'
        ]);

        // Ambil data mobil berdasarkan ID
        $car = Car::findOrFail($id);
        // Update statusnya
        $car->status = $request->status;
        $car->save();

        // Kembalikan response JSON (bisa dipakai untuk notifikasi success di frontend)
        return response()->json(['message' => 'Status updated']);
    }
}
