<?php

namespace App\Http\Controllers;

use App\Meeting;
use App\Member;
use App\Team;
use App\Tag;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class MeetingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $meetings = Meeting::whereDate('date', '>=', date('Y-m-d'))->orderBy('date', 'asc')->get();
        $oldMeetings = Meeting::whereDate('date', '<', date('Y-m-d'))->orderBy('date', 'desc')->get();
        return view('meetings.index', compact('meetings', 'oldMeetings'));
    }

    public function create()
    {
        session(['url.intended' => URL::previous()]);
        $members = Member::orderBy('firstname')->get();
        $users = User::all();
        $tags = Tag::all();

        return view('meetings.create', compact('members', 'users', 'tags'));
    }

    public function store()
    {
        $this->validate(\request(), [
            'user_id' => 'required',
            'member_id' => 'required',
            'date' => 'required|date'
        ]);

        $meeting = new Meeting();
        $meeting->date = Carbon::parse(\request('date'));

//        return $meeting->date . " -> " . $meeting->date->addMinutes(30);
        $meeting->user_id = \request('user_id');
        $meeting->member_id = \request('member_id');
        $meeting->notes = \request('notes');
        $meeting->save();

        return redirect()->intended('MeetingsController@index');
    }

    public function edit(Meeting $meeting)
    {
        session(['url.intended' => URL::previous()]);
        $users = \App\User::all();
        $members = Member::orderBy('firstname')->get();
        $tags = Tag::all();
        return view('meetings.edit', compact('meeting', 'users', 'members', 'tags'));
    }

    public function update(Meeting $meeting)
    {
        $this->validate(\request(), [
            'user_id' => 'required',
            'member_id' => 'required',
            'date' => 'required|date'
        ]);

        $meeting->date = Carbon::parse(\request('date'));
        $meeting->user_id = \request('user_id');
        $meeting->member_id = \request('member_id');
        $meeting->notes = \request('notes');
        $meeting->update();

//        return redirect('/meetings');
        return redirect()->intended('MeetingsController@index');
    }
}
