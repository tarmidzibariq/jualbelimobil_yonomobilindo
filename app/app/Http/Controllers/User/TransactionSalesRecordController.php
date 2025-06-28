<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Review;
use App\Models\SalesRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionSalesRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $salesRecords = SalesRecord::with(['car', 'buyer', 'saler'])->where('buyer_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);;
    
        return view('user.transactionSalesRecord.index', compact('salesRecords'));
    }

    public function createTesti($id) {
        $salesRecord = SalesRecord::findOrFail($id);
        // $car = Car::findOrFail($id);

        return view('user.transactionSalesRecord.testimoni', compact('salesRecord'));
    }

    public function storeTesti(Request $request, $id)
    {
        // dd($request);
        $user_id = Auth::id();
        $salesRecord = SalesRecord::findOrFail($id);
        $car = Car::findOrFail($salesRecord->car_id);

        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'photo_review' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // 'status' => 'required|in:pending,approved,rejected',
        ]);

        // Cek apakah sudah ada review dengan kombinasi sales_record_id dan car_id
        $existingReview = Review::where('sales_record_id', $salesRecord->id)
            ->where('car_id', $car->id)
            ->first();

        if ($existingReview) {
            return redirect()->route('user.transactionSalesRecord.index')->with('error', 'Testimoni untuk transaksi ini sudah pernah dibuat.');
        }

        // Upload foto review
        $photo_review_proof = $request->file('photo_review');         // Ambil file
        $filename = $photo_review_proof->hashName();                         // Generate nama unik (berbasis hash)
        $photo_review_proof->storeAs('photo_review', $filename, 'public'); 
        // $photoPath = $request->file('photo_review')->store('photo_reviews', 'public');

        // Simpan review ke database
        Review::create([
            'user_id' => $user_id,
            'sales_record_id' => $salesRecord->id,
            'car_id' => $car->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'photo_review' => $filename,
            // 'status' => 'pending', // Status awal adalah pending
        ]);

        return redirect()->route('user.transactionSalesRecord.index')->with('success', 'Testimoni berhasil disimpan.');
    }

}
