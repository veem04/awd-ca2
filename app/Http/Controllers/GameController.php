<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Publisher;
use App\Models\Genre;
use Storage;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // returns 8 games at a time, paginated
        $games = Game::orderBy('created_at', 'desc')->paginate(8);

        return view('games.index', [
            'games' => $games
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get the publishers and genres
        $publishers = Publisher::orderBy('name', 'asc')->get();
        $genres = Genre::orderBy('name', 'asc')->get();

        // returns the view with the publishers and genres
        return view('games.create', [
            'publishers' => $publishers,
            'genres' => $genres
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation rules
        $rules = [
            'title' => "required|string|unique:games,title|min:2|max:250",
            'publisher' => "required|int|exists:publishers,id",
            'genres' => "required|array",
            'genres.*' => "exists:genres,id",
            'image' => "image|mimes:jpeg,png,jpg,gif|max:2048"
        ];

        // unique validation messages
        $messages = [
            'publisher' => 'The chosen publisher is invalid.',
            'genres.required' => 'You must choose at least one genre.',
            'genres.*.exists' => 'A selected genre does not exist.'
        ];

        $request->validate($rules, $messages);

        // save the new game
        $game = new Game;
        $game->title = $request->title;
        $game->publisher_id = $request->publisher;
        // code for image upload
        if ($request->image) {
            $imageName = time().'.'.$request->image->extension();
            Storage::putFileAs('public/images', $request->image,  $imageName);
            $game->image = $imageName;
        }
        $game->save();

        // creates entries in the pivot table for each genre
        foreach($request->genres as $genre){
            $game->genres()->attach($genre);
        }

        // returns you to the table page
        return redirect()
            ->route('games.index')
            ->with('status', 'Created a game successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $game = Game::FindOrFail($id);
        return view('games.show', [
            'game' => $game
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $game = Game::FindOrFail($id);

        // get the publishers and genres
        $publishers = Publisher::orderBy('name', 'asc')->get();
        $genres = Genre::orderBy('name', 'asc')->get();

        // returns the view with the publishers and genres
        return view('games.edit', [
            'game' => $game,
            'publishers' => $publishers,
            'genres' => $genres
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validation rules
        $rules = [
            'title' => "required|string|unique:games,title,{$id}|min:2|max:250",
            'publisher' => "required|int|exists:publishers,id",
            'genres' => "required|array",
            'genres.*' => "exists:genres,id",
            'image' => "image|mimes:jpeg,png,jpg,gif|max:2048"
        ];

        // unique validation messages
        $messages = [
            'publisher' => 'The chosen publisher is invalid.',
            'genres.required' => 'You must choose at least one genre.',
            'genres.*.exists' => 'A selected genre does not exist.'
        ];

        $request->validate($rules, $messages);

        // update the game
        $game = Game::findOrFail($id);
        $game->title = $request->title;
        $game->publisher_id = $request->publisher;
        // code for image upload
        if ($request->image) {
            if(Storage::exists('public/images/'.$game->image)){
                Storage::delete('public/images/'.$game->image);
            }
            $imageName = time().'.'.$request->image->extension();
            Storage::putFileAs('public/images', $request->image,  $imageName);
            $game->image = $imageName;
        }
        $game->save();

        // removes all the existing genres
        $game->genres()->detach();
        // creates entries in the pivot table for every genre
        foreach($request->genres as $genre){
            $game->genres()->attach($genre);
        }

        // redirects you to the main table
        return redirect()
            ->route('games.index')
            ->with('status', 'Edited a game successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $game = Game::findOrFail($id);
        $game->genres()->detach();
        $game->delete();

        return redirect()
            ->route('games.index')
            ->with('status', 'Deleted a game successfully!');
    }
}
