<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CoachesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        // prepare overdue meetings

        $membersWithoutMeeting = DB::select(DB::raw('SELECT members.id, members.firstname
          FROM members 
          INNER JOIN teams 
          ON members.team_id = teams.id 
          INNER JOIN users ON teams.user_id = users.id 
          WHERE members.id 
          NOT IN (SELECT member_id FROM meetings) 
          AND users.id = ' . Auth::id() .' 
          AND members.meeting_interval > 0 
          ORDER BY members.firstname'));
//        $membersWithoutMeeting = DB::select(DB::raw('SELECT members.id, members.firstname FROM members, teams, users WHERE members.id NOT IN (SELECT member_id FROM meetings) AND members.team_id = teams.id AND teams.user_id = ' . Auth::user()->id . ' AND members.meeting_interval > 0 ORDER BY members.firstname'));

        // Check https://github.com/laravel/framework/issues/14997
        $membersWithOverdueMeetings = DB::select(DB::raw('SELECT members.id, members.firstname, (DATEDIFF(NOW(), dates.date)-members.meeting_interval) as overdue
          FROM (SELECT members.id, members.firstname, members.meeting_interval FROM members INNER JOIN teams ON members.team_id = teams.id
          INNER JOIN users ON teams.user_id = users.id WHERE users.id = ' . Auth::id() . ') members, 
          (SELECT max(date) as date, member_id FROM meetings GROUP BY member_id) dates
          WHERE members.id = dates.member_id
          AND ((DATEDIFF(NOW(), dates.date)-members.meeting_interval)) > 0
          ORDER BY overdue DESC'));

        // prepare upcoming dates
        $dates = DB::select(DB::raw('SELECT members.firstname, users.name, meetings.id, meetings.date
            FROM members
            INNER JOIN meetings
            ON members.id = member_id
            INNER JOIN users
            ON user_id = users.id
            WHERE meetings.date > NOW()
            AND users.id = ' . Auth::id()));

        // prepare tasks

        return view('dashboard', compact('membersWithoutMeeting', 'membersWithOverdueMeetings', 'dates'));
    }

    public function index()
    {
        $coaches = User::orderBy('name')->get();

        return view('coaches.index', compact('coaches'));
    }

    public function create()
    {
        return view('coaches.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'firstname' => 'required|min:2',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $coach = new User();
        $coach->name = request('firstname');
        $coach->lastname = request('lastname');
        $coach->email = request('email');
        $coach->password = bcrypt(request('password'));
        $coach->save();

        return redirect('/');
    }

    public function edit(User $user)
    {
        return view('coaches.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate(request(), [
            'name' => 'required|min:2',
            'email' => 'required|email'
        ]);
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;

        if (isset($request->password)) {
            $this->validate(request(), [
                'password' => 'min:6'
            ]);
            $user->password = bcrypt($request->password);
        }
        $user->update();

        return redirect('/coaches');
    }
}
