<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Offer::query();

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter keyword brand/model
        if ($request->filled('keyword')) {
            $query->where(function($q) use ($request) {
                $q->where('brand', 'like', '%' . $request->keyword . '%')
                ->orWhere('model', 'like', '%' . $request->keyword . '%');
            });
        }

        // created_at filter
        if ($request->filled('date_range')) {
            [$start, $end] = explode(' to ', $request->date_range);
            $query->whereBetween('created_at', [$start, $end]);
        }
        // $offers = Offer::orderB/y('id', 'desc')->paginate(10);

        $offers = $query->latest()->paginate(10);

        $statuses = [
            'accepted' => 'Accepted',
            'pending' => 'Pending',
            'rejected' => 'Rejected',
            'sold' => 'Sold',
        ];

        return view('admin.offer.index', compact('offers', 'statuses'));
    }

    public function show($id)
    {
        $offer = Offer::findOrFail($id);
        return view('admin.offer.show', compact('offer'));
    }

    public function updateNote(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'note' => 'required|string|max:255',
        ]);

        // Ambil data offer berdasarkan ID
        $offer = Offer::findOrFail($id);

        // Update catatan
        $offer->note = $request->note;
        $offer->save();

        // Kembalikan response JSON (bisa dipakai untuk notifikasi success di frontend)
         return back()->with('success', 'Catatan berhasil ditambahkan.');
    }
    public function editStatus($id)
    {
        $offer = Offer::findOrFail($id);
        return view('admin.offer.partials.update_status_modal', compact('offer'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validasi bahwa status adalah salah satu dari 4 nilai yang diperbolehkan
        $request->validate([
            'status' => 'required|in:accepted,pending,rejected',
        ]);

        // Ambil data mobil berdasarkan ID
        $offer = Offer::findOrFail($id);
        // Update statusnya
        $offer->status = $request->status;
        $offer->save();

        // Kembalikan response JSON (bisa dipakai untuk notifikasi success di frontend)
        return response()->json([
            'message' => 'ID #' . $offer->id . ' Update Status Offer successfully.',
            'status' => 'success'
        ]);    
    }
}
