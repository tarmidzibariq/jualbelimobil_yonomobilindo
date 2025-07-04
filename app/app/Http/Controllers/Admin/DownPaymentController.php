<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DownPayment;
use App\Models\Refund;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = DownPayment::query();

        
         // Filter by keyword (brand atau model mobil)
        if ($request->filled('keyword')) {
            $query->whereHas('car', function ($q) use ($request) {
                $q->where('brand', 'like', '%' . $request->keyword . '%')
                ->orWhere('model', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('status')) {
            [$type, $value] = explode(':', $request->status);

            
            if ($type === 'payment') {
                $query->where('payment_status', $value);
            }
            if ($type === 'payment' && $value === 'confirmed') {
                $query->whereNotIn('payment_status', ['pending', 'cancelled', 'expired'])
                    ->whereNull('refund_id');
            }

            // Jika statusnya refund, kita cek relasi refund
            if ($type === 'refund') {
                $query->whereHas('refund', function ($q) use ($value) {
                    $q->where('refund_status', $value);
                });
            }
        }

        // Filter by date range
        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range);
            $startDate = trim($dates[0]);
            $endDate = trim($dates[1] ?? $dates[0]);

            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();

            $query->whereBetween('created_at', [$start, $end]);
        }
        
        // Ambil data down payment dengan relasi user dan car
        $downPayments = $query->with(['user', 'car'])->latest()->paginate(10);

        $statuses = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'cancelled' => 'Cancelled',
            'expired' => 'Expired',
            'refund' => 'Refunded',
        ];
        // $downPayments = DownPayment::with(['user','car'])->orderBy('id', 'desc')->paginate(10);
        return view('admin.downPayment.index', compact('downPayments', 'statuses'));
    }

    public function show($id)
    {
        $downPayment = DownPayment::with(['user', 'car'])->findOrFail($id);
        return view('admin.downPayment.partials.modal_content', compact('downPayment'));
    }

    public function addRefund($id)
    {
        $downPayment = DownPayment::findOrFail($id);
        return view('admin.downPayment.refund', compact('downPayment'));
    }

    public function storeRefund(Request $request, $id)
    {
        $request->validate([
            'no_rekening_refund' => 'required|string|max:255',
            'refund_payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        
        ]);

        $refund_payment_proof = $request->file('refund_payment_proof');         // Ambil file
        $filename = $refund_payment_proof->hashName();                         // Generate nama unik (berbasis hash)
        $refund_payment_proof->storeAs('refund', $filename, 'public');         // Simpan file ke storage/app/public/refund


        $refund = Refund::create([
            'no_rekening_refund' => $request->no_rekening_refund,
            'refund_payment_proof' => $filename,
            'status' => 'refund',
        ]);
        $downPayment = DownPayment::findOrFail($id);
        $downPayment->update([
            'refund_id' => $refund->id,
        ]);
        if ($refund->refund_status = 'refund') {
            // Update status mobil menjadi sold
            $downPayment->car->update(['status' => 'available']);
        }

        return redirect()->route('admin.downPayment.index')->with('success', 'Down payment refunded successfully.');
    }

    public function editRefund($id)
    {
        $downPayment = DownPayment::with('refund')->findOrFail($id);
        return view('admin.downPayment.editRefund', compact('downPayment'));
    }
    public function updateRefund(Request $request, $id)
    {
        $request->validate([
            'no_rekening_refund' => 'required|string|max:255',
            'refund_payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $downPayment = DownPayment::with('refund')->findOrFail($id);

        // Jika belum ada refund, buat baru
        if (!$downPayment->refund) {
            $refund = new Refund();
        } else {
            $refund = $downPayment->refund;
        }

        // Update no rekening
        $refund->no_rekening_refund = $request->no_rekening_refund;

        // Jika ada file baru
        if ($request->hasFile('refund_payment_proof')) {
            // Hapus file lama jika ada
            if ($refund->refund_payment_proof && Storage::disk('public')->exists('refund/' . $refund->refund_payment_proof)) {
                Storage::disk('public')->delete('refund/' . $refund->refund_payment_proof);
            }

            $filename = $request->file('refund_payment_proof')->hashName();
            $request->file('refund_payment_proof')->storeAs('refund', $filename, 'public');
            $refund->refund_payment_proof = $filename;
        }

        $refund->refund_status = 'refund'; // update atau tetap sama
        $refund->save();

        if ($refund->refund_status = 'refund') {
            // Update status mobil menjadi sold
            $downPayment->car->update(['status' => 'available']);
        }

        // Pastikan DownPayment terhubung ke refund
        $downPayment->refund_id = $refund->id;
        $downPayment->save();

        return redirect()->route('admin.downPayment.index')->with('success', 'Refund berhasil diperbarui.');
    }


}
