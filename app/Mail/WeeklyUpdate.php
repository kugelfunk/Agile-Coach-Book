<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class WeeklyUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $tasks;
    public $meetings;

    public function __construct($id)
    {
        //all open tasks

//        $tasks = Task::where('user_id', Auth::id())->where('done', false)->where('duedate')->orderBy('duedate')->get();
        $tasks = DB::select(DB::raw('SELECT id, title, duedate FROM tasks
            WHERE user_id = ' . $id . '
            AND duedate BETWEEN NOW() AND NOW() + INTERVAL 7 DAY
            ORDER BY duedate'));
        $this->tasks = $tasks;

        $this->meetings = DB::select(DB::raw('SELECT members.firstname, members.lastname, users.name, meetings.id, meetings.date
            FROM members
            INNER JOIN meetings
            ON members.id = member_id
            INNER JOIN users
            ON user_id = users.id
            WHERE meetings.date BETWEEN NOW() AND NOW() + INTERVAL 7 DAY
            AND users.id = ' . $id .'
            ORDER BY meetings.date'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.weekly_update')
            ->subject("Your dates this week");
    }
}
