<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(){
        $reviews = Review::
            with(['car', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('web.testimonial', compact('reviews'));
    }
}
