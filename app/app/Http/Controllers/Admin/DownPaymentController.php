<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DownPayment;
use Illuminate\Http\Request;

class DownPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $downPayments = DownPayment::with(['user','car'])->orderBy('id', 'desc')->paginate(10);
        return view('admin.downPayment.index', compact('downPayments'));
    }
    public function show($id)
    {
        $downPayment = DownPayment::with(['user', 'car'])->findOrFail($id);
        return view('admin.downPayment.partials.modal_content', compact('downPayment'));
    }
}
