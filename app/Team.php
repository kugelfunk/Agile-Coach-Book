<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function attachments()
    {
        return $this->belongsToMany(Attachment::class);
    }

    protected $fillable = [
        'name', 'user', 'meeting_interval',
    ];
}
