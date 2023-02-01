<?php

namespace App\Http\Controllers;

use App\Models\Songs;
use Illuminate\Http\Request;

class ViewSongsController extends Controller
{
    public function index(){
        return view('welcome');
    }

    // get song
    public function getSong(){
        $song = Songs::orderBy('id', 'asc')->paginate(1);
        return response()->json($song);
    }
}
