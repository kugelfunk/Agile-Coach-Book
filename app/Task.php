<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

class Task extends Model
{
    private $stuff = 12;
    public $dude = 28;
    public static const MY_CONSTANT = "ThisIsMyConstant";

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}
