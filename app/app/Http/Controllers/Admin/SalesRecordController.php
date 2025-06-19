<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Offer;
use App\Models\SalesRecord;
use App\Models\User;
use Illuminate\Http\Request;

class SalesRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole:admin');
    }
    
    public function index()
    {
        $salesRecords = SalesRecord::with(['car', 'buyer', 'saler'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.salesRecord.index', compact('salesRecords'));
    }
    
    public function create()
    {
        
        $cars = Car::where('status', 'under_review')->orderBy('created_at', 'desc')->get();
        // $offers = Offer::where('status', 'accepted')->orderBy('created_at', 'desc')->get();
        $users = User::all();

        return view('admin.salesRecord.create', compact('cars', 'users'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'buyer_id' => 'required|exists:users,id',
            'seller_id' => 'required|exists:users,id',
            'sale_price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
        ]);

        $salesRecord = SalesRecord::create([
            'car_id' => $request->car_id,
            'buyer_id' => $request->buyer_id,
            'seller_id' => $request->seller_id,
            'sale_price' => $request->sale_price,
            'sale_date' => $request->sale_date,
            // 'status' => 'completed', // Assuming the status is set to completed
        ]);
        // Update the car status to 'sold'
        
        $car = Car::findOrFail($request->car_id);
        if ($car->status !== 'sold') {
            $car->update(['status' => 'sold']);
        }

        return redirect()->route('admin.salesRecord.index')->with('success', 'Sales record created successfully.');
    }

    public function destroy($id)
    {
        $salesRecord = SalesRecord::findOrFail($id);
        $salesRecord->delete();

        return redirect()->route('admin.salesRecord.index')->with('success', 'Sales record deleted successfully.');
    }
}
