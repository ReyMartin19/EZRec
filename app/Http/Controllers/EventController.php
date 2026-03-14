<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return Inertia::render('Events', [
            'events' => $events,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'type'  => 'required|string|min:4|max:100',
            'category' => 'required|string|max:100',
            'max_members' => 'required_if:type,team|nullable|integer|min:2',
        ]);

        if ($validated['type'] === 'solo') {
            $validated['max_members'] = null;
        }
        
        Event::create($validated);

        return redirect()->back()->with('message', 'Event added!');
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'type'  => 'required|string|min:4|max:100',
            'category' => 'required|string|max:100',
        ]);

        $event->update($validated);

        return redirect()->back()->with('message', 'Event updated!');
    }
}
