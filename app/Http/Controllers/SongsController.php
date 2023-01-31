<?php

namespace App\Http\Controllers;

use App\Models\Songs;
use App\Http\Requests\StoreSongsRequest;
use App\Http\Requests\UpdateSongsRequest;
use App\Models\Categories;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SongsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $songs = Songs::orderBy('created_at', 'desc');
        $categorys = Categories::all();
        return DataTables::eloquent($songs)
        ->editColumn('name', function ($item){
            return '<a href="javascript:void(0)" id="show_review" data-id="'.$item->id.'" data-bs-toggle="modal" data-bs-target="#modalReview">
            '.$item->name.'</a>';
        })
        ->editColumn('category_id', function ($item) use ($categorys){
            foreach ($categorys as $category){
                if ($item->category_id == $category->id) {
                    return $category->name;
                }
            }
        })
        ->addColumn('action', function ($item){
            return '<a href="javascript:void(0)" data-id="'.$item->id.'" id="delete_song">delete</a> | 
            <a href="javascript:void(0)" data-id="'.$item->id.'" id="show_update_song" data-bs-toggle="modal" data-bs-target="#modal_update">update</a>'
            ;
        })
        ->rawColumns(['name','action'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_songs = Songs::all();
        $categorys = Categories::all();
        return view('admin.songs.index', compact('all_songs', 'categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSongsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSongsRequest $request)
    {
        try {
            // get Image File 
            $file_name_song  = 'song_'. time(). '.' . $request->song->extension();
            $file_name_image  = 'image_'. time(). '.' . $request->image->extension();
            // move to public store folder
            $request->file('song')->storeAs('/public/songs', $file_name_song);
            $request->file('image')->storeAs('/public/images', $file_name_image);

            // save to database
            $song_upload = new Songs();
            $song_upload->name = $request->name;
            $song_upload->song_name = $file_name_song;
            $song_upload->author = $request->author;
            $song_upload->category_id = $request->category;
            $song_upload->image = $file_name_image;
            $song_upload->save();

            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Songs  $songs
     * @return \Illuminate\Http\Response
     */
    public function show(Songs $songs)
    {
        //
    }

    public function show_song(Request $request){
        $song = Songs::find($request->id);
        $category = Categories::find($song->category_id);
        $viewRender = view('partirial.modals._update_item', compact('song', 'category'))->render();
        return response()->json(['html' => $viewRender]);
    }

    public function getSong(Request $request){
        $song = Songs::find($request);
        return response()->json($song);
    }

    public function edit_song(Request $request){
        try {
            // save to database
            $song_upload = Songs::find($request->id);
            $song_upload->name = $request->name;

             // get Image File 
             if (isset($request->song)) {
                $file_name_song  = 'song_'. time(). '.' . $request->song->extension();
                // move to public store folder
                $request->file('song')->storeAs('/public/songs', $file_name_song);
                $song_upload->song_name = $file_name_song;
            }
            if (isset($request->image)) {
                $file_name_image  = 'image_'. time(). '.' . $request->image->extension();
                $request->file('image')->storeAs('/public/images', $file_name_image);
                $song_upload->image = $file_name_image;
            }

            $song_upload->author = $request->author;
            $song_upload->save();

            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSongsRequest  $request
     * @param  \App\Models\Songs  $songs
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSongsRequest $request, Songs $songs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Songs  $songs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Songs $songs)
    {
        //
    }

    public function delete(Request $request){
        Songs::find($request->id)->delete();
        return redirect()->back();
    }
}
