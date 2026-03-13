<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CoachController extends Controller
{
    public function index()
    {
        $coaches = Coach::all();
        return Inertia::render('Coaches', [
            'coaches' => $coaches,
            'eventList' => Event::select('id', 'name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'event'  => 'required|string|min:4|max:100',
            'gender' => 'required|string|max:100',
        ]);

        Coach::create($validated);

        return redirect()->back()->with('message', 'Coach added!');
    }

    public function update(Request $request, Coach $coach)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'event'  => 'required|string|min:4|max:100',
            'gender' => 'required|string|max:100',
        ]);

        $coach->update($validated);

        return redirect()->back()->with('message', 'Coach updated!');
    }
}
