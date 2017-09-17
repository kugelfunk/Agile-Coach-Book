<?php

namespace App\Http\Controllers;

use App\Tag;
use App\User;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index(Tag $tag)
    {
//        $tag = Tag::with('tasks')->where('id', $tag->id)->get();
        $tasks = $tag->tasks()->where('done', false)->orderBy('duedate', 'asc')->get();
        $completedTasks = $tag->tasks()->where('done', true)->orderBy('duedate', 'asc')->get();

        $tags = Tag::has('tasks')->pluck('name');
        $coaches = User::all();

        $currentFilter = $tag->name;

        return view('tasks.index', compact('tasks', 'completedTasks', 'tags', 'coaches', 'currentFilter'));
    }

    public function getTags()
    {
        $tags = Tag::all();
        return $tags;
    }
}
