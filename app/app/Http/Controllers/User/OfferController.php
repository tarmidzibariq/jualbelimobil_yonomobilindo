<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $offers = Offer::with('user')->where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        // Logic to display a list of offers
        return view('user.offer.index',compact('offers'));
    }
    public function show($id)
    {
        $offer = Offer::with('user')->where('user_id', Auth::id())->findOrFail($id);
        // Logic to display a specific offer
        return view('user.offer.show', compact('offer'));
    }
}
