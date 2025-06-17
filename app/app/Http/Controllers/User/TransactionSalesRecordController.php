<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
        $salesRecords = SalesRecord::with(['car', 'buyer', 'saler'])->where('buyer_id', Auth::id()) ->orderBy('created_at', 'desc')->paginate(10);;
    
        return view('user.transactionSalesRecord.index', compact('salesRecords'));
    }
}
