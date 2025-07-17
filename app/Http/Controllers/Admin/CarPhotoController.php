<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarPhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function destroy($id)
    {
        $photo = CarPhoto::findOrFail($id);
        $carId = $photo->car_id;
        
        if (Storage::disk('public')->exists('car_photos/' . $photo->photo_url)) {
            Storage::disk('public')->delete('car_photos/' . $photo->photo_url);
        }

        $photo->delete();

        // SUSUN ULANG NOMOR FOTO YANG TERSISA
        $remainingPhotos = CarPhoto::where('car_id', $carId)->orderBy('number')->get();

        foreach ($remainingPhotos as $index => $p) {
            $p->update(['number' => $index + 1]);
        }
        return response()->json(['message' => 'Photo deleted']);
    }
}
