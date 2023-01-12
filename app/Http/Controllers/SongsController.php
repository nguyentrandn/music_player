<?php

namespace App\Http\Controllers;

use App\Models\Songs;
use App\Http\Requests\StoreSongsRequest;
use App\Http\Requests\UpdateSongsRequest;
use App\Models\Categories;

class SongsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_songs = Songs::all();
        $categorys = Categories::all();
        return view('admin.songs.index', compact('all_songs', 'categorys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSongsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSongsRequest $request)
    {
        // dd($request->all());
        // try {
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
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Songs  $songs
     * @return \Illuminate\Http\Response
     */
    public function edit(Songs $songs)
    {
        //
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
}
