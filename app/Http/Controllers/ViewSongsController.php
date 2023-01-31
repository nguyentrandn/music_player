<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewSongsController extends Controller
{
    public function index(){
        return view('user.index');
    }
}
