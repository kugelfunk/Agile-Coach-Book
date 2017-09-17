<?php

namespace App\Http\Controllers;

use App\Meeting;
use App\Member;
use App\Team;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $teams = Team::orderBy('name')->get();

        $currentTeam = Team::find(request('team_id'));

        $team_id = request('team_id');
        if (isset($team_id)) {
            $members = Member::where('team_id', $team_id)->orderBy('firstname', 'ASC')->get();
        } else {
            $members = Member::orderBy('firstname', 'ASC')->get();
        }
        return view('members.index', compact('members', 'teams', 'currentTeam'));
    }

    public function create()
    {
        $teams = Team::all();
        return view('members.create', compact('teams'));
    }

    public function store()
    {
        $this->validate(request(), [
            'firstname' => 'required|min:2',
            'email' => 'required|email|unique:members'
        ]);

        $member = new Member();
        $member->firstname = \request('firstname');
        $member->lastname = \request('lastname');
        $member->email = \request('email');
        $member->team_id = \request('team_id');
        $member->meeting_interval = \request('meeting_interval');
        $member->save();
        return redirect('/members');
    }

    public function edit(Member $member)
    {
        $teams = Team::all();
        $meetings = Meeting::where('member_id', $member->id)->orderBy('date', 'desc')->get();

        return view('members.edit', compact('member', 'teams', 'meetings'));
    }

    public function update(Member $member)
    {

        $this->validate(request(), [
            'firstname' => 'required|min:2',
            'email' => 'required|email|unique:members,email,' . $member->id
        ]);

        $member->firstname = \request('firstname');
        $member->lastname = \request('lastname');
        $member->email = \request('email');
        $member->team_id = \request('team_id');
        $member->meeting_interval = \request('meeting_interval');
        $member->update();
        return redirect('/members');
    }
}
