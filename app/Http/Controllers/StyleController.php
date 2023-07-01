<?php

namespace App\Http\Controllers;

use App\Models\style;
use Illuminate\Http\Request;

class StyleController extends Controller
{
    //
    public function index(Request $request)
    {
        $styles = style::all();

        return view('admin.style.index',compact('styles'));
    }

    public function create()
    {
        return view('admin.style.create');
    }

    public function store(Request $request)
    {
        $total = style::count();
        $angka = $total + 1;
        $request->validate([
            'image_style' => 'required|image',
        ]);

        $path = $request->file('image_style')->store("public/images/style {$angka}");
        $imageUrl = asset('storage/' . $path);


        // style::create([
        //     'color' => $request->color,
        //     'gender' => $request->gender,
        //     'gambar_path' => $path,
        //     'gambar_url' => $imageUrl,
        // ]);

        $styles = new style();
        $styles->color = $request->input('color');
        $styles->gender= $request->input('gender');
        $styles->gambar_path = $path;
        $styles->gambar_url = $imageUrl;
        $styles->save();
        $id = $styles->id;

        return redirect()->route('count.component', ['id' => $id])->with('success', 'Post created successfully.');
    }
}
