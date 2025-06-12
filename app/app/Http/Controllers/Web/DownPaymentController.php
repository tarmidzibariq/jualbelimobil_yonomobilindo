<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\DownPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DownPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'user') {
            return redirect()->back()->with('error', 'Admin tidak diperbolehkan melakukan pembayaran DP.');
        }
        // Validasi input
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'amount' => 'required|numeric|min:500000',
            'car_id' => 'required|exists:cars,id',
        ]);

        $car = Car::findOrFail($request->car_id);
        
        // Gabungkan tanggal dan waktu
        $appointmentDateTime = $request->appointment_date . ' ' . $request->appointment_time;

        // Jika kolom di database `appointment_date` bertipe DATETIME
        // Maka konversi ke format datetime valid (pakai Carbon)
        $appointmentDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $appointmentDateTime);

        // Simpan data ke tabel (misal DownPayment)
        DownPayment::create([
            'car_id' => $car->id,
            'user_id' => Auth::guard('web')->id(),
            'appointment_date' => $appointmentDateTime,
            'amount' => $request->amount,
        ]);

        return redirect()->route('home-cms')->with('success', 'DP berhasil dikirim.');
    }

    public function show($id){

        $car = Car::with('mainPhoto')->findOrFail($id);
        
        if ($car->status == "available") {
            return view('web.downPayment', compact('car'));
        }else{
            return  view('errors.404');
        }
    }
}
