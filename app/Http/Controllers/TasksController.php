<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Member;
use App\Tag;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Image;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tasks = Task::with(['user' => function ($query) {
            $query->pluck('name');
        }])->where('done', false)->orderBy('duedate', 'ASC')->get();

        $completedTasks = Task::with(['user' => function ($query) {
            $query->pluck('name');
        }])->where('done', true)->orderBy('duedate', 'ASC')->get();

        $tags = Tag::has('tasks')->pluck('name');

        return view('tasks.index', compact('tasks', 'completedTasks', 'tags'));
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
//        $this->validate(\request(), [
//            'title' => 'required|min:2',
//            'user_id' => 'required'
//        ]);

        if ($request->has('title') && $request->has('user_id')) {
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

            if ($request->has('tags')) {
                $tags = [];
                foreach ($request->get('tags') as $newTag) {
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

            if ($request->file('files')) {
                $files = request()->file('files');
                foreach ($files as $file) {
                    $fileId = $this->storeFile($file);
                    $task->attachments()->attach($fileId);
                }
            }

            return \response()->json(['response' => 'SUCCESS', 'msg' => 'Task was created.'], 200);
        } else {
            return \response()->json(['error' => 'Title and Coach must be given', 'message' => 'Ick sach doch da fehlt watt'], 400);
        }
    }

    public function updateTask(Task $task)
    {
//        $this->validate(\request(), [
//            'title' => 'required|min:2',
//            'user_id' => 'required'
//        ]);


        if (request()->has('title') && request()->has('user_id')) {

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

            if (null !== (\request('removedAttachments'))) {
                $removedAttachments = json_decode(\request('removedAttachments'));
                if (sizeof($removedAttachments) > 0) {
                    DB::table('attachment_task')->whereIn('attachment_id', $removedAttachments)->delete();
                }
            }

            if (request()->file('files')) {
                $files = request()->file('files');
                foreach ($files as $file) {
                    $fileId = $this->storeFile($file);
                    $task->attachments()->attach($fileId);
                }
            }

            return \response()->json(['response' => 'SUCCESS', 'msg' => 'Task was updated.'], 200);
        } else {
            return \response()->json(['error' => 'Title and Coach must be given', 'message' => 'Ick sach doch da fehlt watt'], 400);
        }
    }

    private function storeFile($file)
    {
        $handle = str_slug(basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension())) . "_" . str_random(8);
        $extension = $file->getClientOriginalExtension();
        $filetype = '';

        try{
            $mimetype = File::mimeType($file);
        } catch (\Exception $e) {

        }

        if (str_contains($mimetype, 'image')) {
            $img = Image::make($file->getRealPath());

            $path = storage_path('app/uploads/' . $handle . '.' . $extension);
            $img->save($path);

            $filetype = 'image';
            // Fit 296px x 150px for news index page
            $path = storage_path('app/uploads/' . $handle . '_thumbnail.' . $extension);
            $img->fit(250, 150, function ($constraint) {
                $constraint->upsize();
            })->save($path);
        } else {
            $filetype = 'document';
            $file->storeAs('uploads', $handle . '.' . $extension);
        }

        $attachment = new Attachment();
        $attachment->handle = $handle;
        $attachment->extension = $extension;
        $attachment->filetype = $filetype;
        $attachment->mimetype = $mimetype;
        $attachment->save();

        return $attachment->id;
    }
}
