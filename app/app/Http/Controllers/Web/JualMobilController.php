<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use App\Models\Offer;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JualMobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = CarType::distinct()->pluck('brand');
        $reviews = Review::
            with(['car', 'user'])
            ->inRandomOrder()
            ->take(3)
            ->get();
        return view('web.jualMobil', compact('brands', 'reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        if (!$user || $user->role !== 'user') {
            return redirect()->back()->with('error', 'Admin tidak diperbolehkan melakukan pembayaran DP.');
        }

        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'mileage' => 'required|string',
            'offered_price' => 'required|numeric|min:1000000',
            'location_inspection' => 'required|string',
            'inspection_date' => 'required|date|after_or_equal:today',
        ]);

        $offer = Offer::create([
            'user_id' => Auth::id(),
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'mileage' => $request->mileage,
            'offered_price' => $request->offered_price,
            'location_inspection' => $request->location_inspection,
            'inspection_date' => $request->inspection_date,
            'status' => 'pending',
        ]);

        return redirect()->route('user.offer.show', $offer->id)->with('success', 'Data Penjualan mobil berhasil disubmit! Silahkan Tunggu Konfirmasi dari Admin Kontak: 081220745317');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
