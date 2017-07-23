<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }
}
