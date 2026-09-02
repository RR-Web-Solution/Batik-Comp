<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminTestimonialController extends Controller
{
    public function index()
    {
        $testimonial = Testimonial::orderBy('sort_order')->get();

        return view('admin.testimonial', compact('testimonial'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_title' => 'nullable|string|max:100',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Testimonial::create([
            'customer_name' => $request->input('customer_name'),
            'customer_title' => $request->input('customer_title'),
            'content' => $request->input('content'),
            'rating' => $request->input('rating'),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        return redirect()->route('testimonial')->with('success', 'Testimonial berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_title' => 'nullable|string|max:100',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $testimonial->update([
            'customer_name' => $request->input('customer_name'),
            'customer_title' => $request->input('customer_title'),
            'content' => $request->input('content'),
            'rating' => $request->input('rating'),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        return redirect()->route('testimonial')->with('success', 'Testimonial berhasil diupdate.');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return redirect()->route('testimonial')->with('success', 'Testimonial berhasil dihapus.');
    }
}
