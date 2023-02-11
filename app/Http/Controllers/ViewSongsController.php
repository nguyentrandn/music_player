<?php

namespace App\Http\Controllers;

use App\Models\Songs;
use Illuminate\Http\Request;

class ViewSongsController extends Controller
{
    public function index(){
        
        return view('welcome');
    }
    // get list of songs
    public function getList() {
        $songs = Songs::all();
        return response()->json($songs);
    }


}
