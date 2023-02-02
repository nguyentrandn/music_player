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

    // get song
    public function getSong(Request $request){
        if ($request->id) {
            $song = Songs::find($request->id);
        }else{
            $song = Songs::orderBy('id', 'asc')->paginate(1);
        }
        return response()->json($song);
    }
}
