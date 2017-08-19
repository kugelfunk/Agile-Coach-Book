<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

class Task extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'task_tag');
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class);
    }

    protected $dates = ['duedate'];
}
