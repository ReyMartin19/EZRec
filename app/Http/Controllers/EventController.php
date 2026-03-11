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
        // 1. Validate exactly like you did in Blade
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'type'  => 'required|string|min:4|max:100',
            'category' => 'required|string|max:100',
        ]);

        // 2. Save to database
        Event::create($validated);

        // 3. Redirect back (Inertia handles this without a full page reload)
        return redirect()->back()->with('message', 'Event added!');
    }
}
