<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\OfferRecord;
use App\Models\User;
use Illuminate\Http\Request;

class OfferRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole:admin');
    }

    function index()
    {
        $offerRecords = OfferRecord::with(['offer', 'buyerOfferRecord', 'salerOfferRecord'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.offerRecord.index', compact('offerRecords'));
    }

    function create()
    {
        $offers = Offer::where('status', 'accepted')->orderBy('created_at', 'desc')->get();
        // $offers = Offer::where('status', 'accepted')->orderBy('created_at', 'desc')->get();
        $users = User::all();

        // You can add logic here to fetch necessary data for creating an offer record
        return view('admin.offerRecord.create', compact('offers', 'users'));
    }

     function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'offer_id' => 'required|exists:cars,id',
            'buyer_id' => 'required|exists:users,id',
            'seller_id' => 'required|exists:users,id',
            'sale_price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
        ]);

        $offerRecord = OfferRecord::create([
            'offer_id' => $request->offer_id,
            'buyer_id' => $request->buyer_id,
            'seller_id' => $request->seller_id,
            'sale_price' => $request->sale_price,
            'sale_date' => $request->sale_date,
            'status' => 'completed', // Assuming the status is set to completed
        ]);
        // Update the car status to 'sold'
        
        $offer = Offer::findOrFail($request->offer_id);
        if ($offer->status !== 'sold') {
            $offer->update(['status' => 'sold']);
        }

        return redirect()->route('admin.offerRecord.index')->with('success', 'Sales record created successfully.');
    }
}
