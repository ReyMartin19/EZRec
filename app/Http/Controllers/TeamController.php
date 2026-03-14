<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeamController extends Controller
{
    public function index()
    {
        return Inertia::render('Teams', [
            'teams' => Team::withCount('athletes')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
        ]);

        Team::create($validated);
        return  redirect()->back()->with('message', 'Team added!');
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
        ]);

        $team->update($validated);

        return redirect()->back()->with('message', 'Team updated!');
    }
}
