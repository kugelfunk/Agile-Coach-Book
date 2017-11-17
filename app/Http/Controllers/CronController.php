<?php

namespace App\Http\Controllers;

use App\Meeting;
use App\Member;
use App\Tag;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class CronController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daily()
    {
    }

    public function weekly()
    {
    }

}
