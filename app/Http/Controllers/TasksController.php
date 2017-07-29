<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function postTask(Request $request)
    {
        Log::info("Das Request Objekt: " . $request->get('title'));

        if ($request->has('title') && $request->has('user_id')) {
//            $user = User::find($request->get('user_id'));
            $task = new Task();
            $task->title = $request->get('title');
            $task->user_id = $request->get('user_id');

            if($request->has('meeting_id')){
                $task->meeting_id = $request->get('meeting_id');
            }

            if ($request->has('duedate')) {
                $task->duedate = Carbon::parse($request->get('duedate'));
            }

            $task->save();

            return \response()->json(['response' => 'SUCCESS', 'msg' => 'Task was created.'], 200);
        } else {
            return \response()->json(['error' => 'Title and Coach must be given', 'message' => 'Ick sach doch da fehlt watt'], 400);
        }


    }
}
