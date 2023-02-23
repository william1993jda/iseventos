<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoryboardController extends Controller
{
    public function list()
    {
        return view('storyboard.list');
    }

    public function form()
    {
        return view('storyboard.form');
    }
}
