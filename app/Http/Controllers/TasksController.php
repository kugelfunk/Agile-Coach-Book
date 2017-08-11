<?php

namespace App\Http\Controllers;

use App\Member;
use App\Tag;
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

    public function index()
    {
        $tasks = Task::with(['user' => function($query){
            $query->pluck('name');
        }])->where('done', false)->orderBy('duedate', 'ASC')->get();
        $completedTasks = Task::with(['user' => function($query){
            $query->pluck('name');
        }])->where('done', true)->orderBy('duedate', 'ASC')->get();
        return view('tasks.index', compact('tasks', 'completedTasks'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $tags = Tag::all();
        return view('tasks.create', compact('users', 'tags'));
    }

    public function store()
    {
        $this->validate(\request(), [
           'title' => 'required|min:2',
           'user_id' => 'required'
        ]);

        $task = new Task();
        $task->title = \request('title');
        $task->duedate = empty(\request('duedate')) ? null : Carbon::parse(\request('duedate'));
        $task->user_id = \request('user_id');
        $task->notes = \request('notes');

        $task->save();

        $tags = [];
        if (\request()->has('tags')) {
            foreach (\request('tags') as $newTag) {
                $tag = Tag::find($newTag);
                if ($tag == null) {
                    $tag = new Tag();
                    $tag->name = $newTag;
                    $tag->save();
                }
                $tags[] = $tag->id;
            }
            $task->tags()->attach($tags);
        }


        return redirect('/tasks');
    }

    public function edit(Task $task)
    {
        $users = User::orderBy('name')->get();
        $tags = Tag::all();
        return view('tasks.edit', compact('task', 'users', 'tags'));
    }

    public function update(Task $task)
    {
        $this->validate(\request(), [
            'title' => 'required|min:2',
            'user_id' => 'required'
        ]);

        $tags = [];
        if (\request()->has('tags')) {
            foreach (\request('tags') as $newTag) {
                $tag = Tag::find($newTag);
                if ($tag == null) {
                    $tag = new Tag();
                    $tag->name = $newTag;
                    $tag->save();
                }
                $tags[] = $tag->id;
            }
        }
        $task->tags()->sync($tags);

        $task->title = \request('title');
        $task->duedate = empty(\request('duedate')) ? null : Carbon::parse(\request('duedate'));
        $task->user_id = \request('user_id');
        $task->notes = \request('notes');
        $task->done = \request()->has('done') ? true : false;
        $task->update();

        return redirect('/tasks');
    }


    /**
     * API
     */

    public function postTask(Request $request)
    {
        Log::info("Das Request Objekt: " . $request->get('title'));

        if ($request->has('title') && $request->has('user_id')) {
//            $user = User::find($request->get('user_id'));
            $task = new Task();
            $task->title = $request->get('title');
            $task->user_id = $request->get('user_id');

            if ($request->has('meeting_id')) {
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
