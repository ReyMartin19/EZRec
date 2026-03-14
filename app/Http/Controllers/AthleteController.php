<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Athlete;
use App\Models\Event;
use App\Models\Team;
use App\Models\Coach;
use Inertia\Inertia;

class AthleteController extends Controller
{

    public function index()
    {
        return Inertia::render('Athletes', [
            'athletes' => Athlete::with(['team', 'coach', 'events'])->latest()->get(),
            'eventList' => Event::all(),
            'teamList'  => Team::all(),
            'coachList' => Coach::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|min:3|max:255',
            'age'       => 'required|integer|min:5|max:100',
            'coach_id'  => 'nullable|exists:coaches,id',
            'team_id'   => 'nullable|exists:teams,id',
            'event_ids' => 'nullable|array',
            'event_ids.*' => 'exists:events,id',
        ]);

        $athlete = Athlete::create($validated);

        if (!empty($validated['event_ids'])) {
            $athlete->events()->attach($validated['event_ids']);
        }

        return redirect()->back()->with('message', 'Athlete added!');
    }

    public function update(Request $request, Athlete $athlete)
    {
        $validated = $request->validate([
            'name'      => 'required|string|min:3|max:255',
            'age'       => 'required|integer|min:5|max:100',
            'coach_id'  => 'nullable|exists:coaches,id',
            'team_id'   => 'nullable|exists:teams,id',
            'event_ids' => 'nullable|array',
            'event_ids.*' => 'exists:events,id',
        ]);

        $athlete->update($validated);

        return redirect()->back();
    }
}
