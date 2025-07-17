<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OfferRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionOfferRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $offerRecords = OfferRecord::with(['offer', 'buyerOfferRecord', 'salerOfferRecord'])->where('seller_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);;
    
        return view('user.transactionOfferRecord.index', compact('offerRecords'));
    }
}
