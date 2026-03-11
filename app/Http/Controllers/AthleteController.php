<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Athlete;
use App\Models\Event;
use Inertia\Inertia;

class AthleteController extends Controller
{

    public function index()
    {
        return Inertia::render('Athletes', [
            'athletes' => Athlete::latest()->get(),
            'eventList' => Event::select('id', 'name')->get(), 
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'age'  => 'required|integer|min:5|max:100',
            'sport' => 'required|string|max:100',
        ]);

        Athlete::create($validated);

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
