<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
}
