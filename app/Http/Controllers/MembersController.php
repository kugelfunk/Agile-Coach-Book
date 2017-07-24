<?php

namespace App\Http\Controllers;

use App\Member;
use App\Team;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function index()
    {
        $members = Member::orderBy('firstname', 'ASC')->get();
        return view('members.index', compact('members'));
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
        return view('members.edit', compact('member', 'teams'));
    }

    public function update(Member $member)
    {

        $this->validate(request(), [
            'firstname' => 'required|min:2',
            'email' => 'required|email|unique:members,email,'.$member->id
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
