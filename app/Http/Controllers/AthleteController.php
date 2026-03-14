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
        $athletes = Athlete::with(['team', 'coach', 'events'])->latest()->get();
        $teams    = Team::all();
        $coaches  = Coach::all();

        $events = Event::withCount('athletes')->get()->map(function ($event) {
            return [
                'id'          => $event->id,
                'name'        => $event->name,
                'type'        => $event->type,
                'category'    => $event->category,
                'max_members' => $event->max_members,
                'team_counts' => $event->type === 'team'
                    ? $event->athletes()
                        ->selectRaw('athletes.team_id, count(*) as count')
                        ->groupBy('athletes.team_id')
                        ->pluck('count', 'athletes.team_id')
                    : (object)[],
            ];
        });

        return Inertia::render('Athletes', [
            'athletes' => Athlete::with(['team', 'coach', 'events'])->latest()->get(),
            'eventList' => $events,
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

        if (!empty($validated['event_ids'])) {
            foreach ($validated['event_ids'] as $eventId) {
                $event = Event::find($eventId);

                if ($event->type === 'team' && $event->max_members) {
                    $currentCount = $event->athletes()
                        ->where('team_id', $validated['team_id'])
                        ->count();

                    if ($currentCount >= $event->max_members) {
                        return back()->withErrors([
                            'event_ids' => "The team is already full for event: {$event->name} (max {$event->max_members} athletes)."
                        ]);
                    }
                }
            }
        }

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

        if (!empty($validated['event_ids'])) {
            $athlete->events()->sync($validated['event_ids']);
        }

        return redirect()->back();
    }
}
