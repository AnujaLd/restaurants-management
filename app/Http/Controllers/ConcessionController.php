<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concession;

class ConcessionController extends Controller
{
    public function index()
    {
        $concessions = Concession::all();
        return view('concession', compact('concessions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image',
            'price' => 'required|numeric',
        ]);

        $imagePath = $request->file('image')->move(public_path('concessions'), $request->file('image')->getClientOriginalName());

        Concession::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => 'concessions/' . $request->file('image')->getClientOriginalName(),
            'price' => $request->price,
        ]);

        return response()->json(['success' => 'Concession added successfully']);
    }

    public function update(Request $request, Concession $concession)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'sometimes|image',
            'price' => 'required|numeric',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->move(public_path('concessions'), $request->file('image')->getClientOriginalName());
            $concession->update(['image' => 'concessions/' . $request->file('image')->getClientOriginalName()]);
        }

        $concession->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return response()->json(['success' => 'Concession updated successfully']);
    }

    public function destroy(Concession $concession)
    {
        $concession->delete();
        return response()->json(['success' => 'Concession deleted successfully']);
    }
}