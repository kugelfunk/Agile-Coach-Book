<?php

namespace App\Http\Controllers;

use App\Meeting;
use App\Member;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class MeetingsController extends Controller
{
    public function index()
    {
        $meetings = Meeting::all();
        return view('meetings.index', compact('meetings'));
    }

    public function create()
    {
        $members = Member::all();
        $users = User::all();

        return view('meetings.create', compact('members', 'users'));
    }

    public function store()
    {
        return request()->all();
    }
}
