<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index(Tag $tag)
    {
//        $tag = Tag::with('tasks')->where('id', $tag->id)->get();
        $tasks = $tag->tasks->where('done', false);
        $completedTasks = $tag->tasks->where('done', true);

        //refactor this:
//        $tags = Tag::has('tasks')->pluck('name');
        $tags = Tag::has('tasks')->pluck('name');

        $currentTag = $tag->name;

        return view('tasks.index', compact('tasks', 'completedTasks', 'tags', 'currentTag'));
    }

    public function getTags()
    {
        $tags = Tag::all();
        return $tags;
    }
}
