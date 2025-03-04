<?php

namespace App\Http\Controllers;

use App\Models\Coffee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CoffeeController extends Controller
{
    public function showDashboard()
    {
        $coffees = Coffee::all();
        return Inertia::render('Dashboard', [
            'coffees' => $coffees,
        ]);
    }

    public function createCoffee()
    {
        return Inertia::render('coffee/Create');
    }

    public function storeCoffee(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'coffee_name' => 'required|string',
            'quantity' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('coffees/images', 'public');
            $imageName = basename($imagePath);
            $validatedData['image'] = $imageName;
        }

        $coffee = Coffee::create($validatedData);

        // return Inertia::render('Dashboard', [
        //     'success' => 'Coffee created successfully',
        //     'coffee' => $coffee,
        // ]);
        return redirect()->route('dashboard')->with('success', 'Coffee created successfully');

    }
}
