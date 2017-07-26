<?php

namespace App\Http\Controllers;

use App\Coach;
use App\User;
use Barryvdh\Debugbar\Middleware\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CoachesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.basic');
    }

    public function dashboard()
    {
        // prepare overdue meetings
        $overdueMeetings = [
            [
                'member' => "Bernd",
                'days' => 12
            ],
            [
                'member' => "Matthias",
                'days' => 17
            ]
        ];

        $membersWithoutMeeting = DB::select(DB::raw('SELECT members.id, members.firstname FROM members WHERE members.id NOT IN (SELECT member_id FROM meetings)'));

        // Check https://github.com/laravel/framework/issues/14997
        $membersWithOverdueMeetings = DB::select(DB::raw('SELECT members.id, members.firstname, (DATEDIFF(NOW(), dates.date)-members.meeting_interval) as overdue
          FROM members, (SELECT max(date) as date, member_id FROM meetings GROUP BY member_id) dates
          WHERE members.id = dates.member_id
          AND ((DATEDIFF(NOW(), dates.date)-members.meeting_interval)) > 0
          ORDER BY overdue DESC'));

        // prepare upcoming dates
        $dates = DB::select(DB::raw('SELECT meetings.id, meetings.date, members.firstname from meetings, members
            where meetings.member_id = members.id
            and meetings.date > NOW()
            ORDER BY meetings.date ASC'));

        // prepare tasks

        return view('dashboard', compact('membersWithoutMeeting', 'membersWithOverdueMeetings', 'dates'));
    }

    public function index()
    {
        $coaches = User::all();

        return view('coaches.index', compact('coaches'));
    }

    public function create()
    {
        return view('coaches.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'firstname' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);
        $coach = new User();
        $coach->name = request('firstname') . " " . \request('lastname');
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
        $user->name = $request->name;
        $user->email = $request->email;

        if (isset($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->update();

        return redirect('/coaches');
    }
}
