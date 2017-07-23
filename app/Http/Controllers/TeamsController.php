<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    public function index()
    {
        $teams = Team::all();

        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        $coaches = User::all();
        return view('teams.create', compact('coaches'));
    }

    public function store()
    {
        $this->validate(\request(), [
            'name' => 'required|min:2',
            'meeting_interval' => 'required|integer'
        ]);

        $team = new Team();
        $team->name = \request('name');
        $team->user_id = \request('user_id');
        $team->meeting_interval = \request('meeting_interval');
        $team->save();

        return redirect('/teams');
    }

    public function edit(Team $team)
    {
        $coaches = User::all();
        return view('teams.edit', compact('coaches', 'team'));
    }

    public function update(Team $team, Request $request)
    {
        $team->name = $request->name;
        $team->user_id = $request->user_id;
        $team->meeting_interval = $request->meeting_interval;
        $team->update();
        return redirect('/teams');
    }
}
