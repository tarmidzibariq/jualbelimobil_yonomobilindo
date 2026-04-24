<?php

namespace App\Http\Controllers\User;

use App\Helpers\MidtransHelper;
use App\Http\Controllers\Controller;
use App\Models\DownPayment;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Transaction;

class DownPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->syncUnavailableCarDownPayments(Auth::id());

        $downPayments = DownPayment::with('car')->where('user_id', Auth::id())->orderBy('id', 'desc')->paginate(10);

        return view('user.downPayment.index', compact('downPayments'));   
    }
    

    public function checkout($id){
        $this->syncUnavailableCarDownPayments(Auth::id());
        $snapToken = 'xxx';
        $downPayments = DownPayment::with('car')->where('user_id', Auth::id())->findOrFail($id);
        return view('user.downPayment.checkout', compact('downPayments', 'snapToken'));
    }

    private function syncUnavailableCarDownPayments(int $userId): void
    {
        DownPayment::where('user_id', $userId)
            ->where('payment_status', 'pending')
            ->whereHas('car', function ($query) {
                $query->whereIn('status', ['under_review', 'sold', 'pending_check']);
            })
            ->update([
                'payment_status' => 'cancelled',
                'snap_token' => null,
                'payment_method' => null,
            ]);
    }
}
