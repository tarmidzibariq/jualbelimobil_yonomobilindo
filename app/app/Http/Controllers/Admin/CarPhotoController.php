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

        if (Storage::disk('public')->exists('car_photos/' . $photo->photo_url)) {
            Storage::disk('public')->delete('car_photos/' . $photo->photo_url);
        }

        $photo->delete();

        return response()->json(['message' => 'Photo deleted']);
    }
}
