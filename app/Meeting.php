<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}
