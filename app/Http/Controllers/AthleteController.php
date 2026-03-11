<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Athlete;
use Inertia\Inertia;

class AthleteController extends Controller
{

    public function index()
    {
        $athletes = Athlete::all();
        return Inertia::render('Athletes', [
            'athletes' => $athletes,
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validate exactly like you did in Blade
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'age'  => 'required|integer|min:5|max:100',
            'sport' => 'required|string|max:100',
        ]);

        // 2. Save to database
        Athlete::create($validated);

        // 3. Redirect back (Inertia handles this without a full page reload)
        return redirect()->back()->with('message', 'Athlete added!');
    }

    public function update(Request $request, Athlete $athlete)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sport' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
        ]);

        $athlete->update($validated);
        return redirect()->back();
    }
}
