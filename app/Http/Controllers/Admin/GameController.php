<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Publisher;
use App\Models\Genre;
use Storage;
use DB;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // returns 8 games at a time, paginated
        $games = Game::orderBy('created_at', 'desc')->paginate(8);

        return view('admin.games.index', [
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
        return view('admin.games.create', [
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
            ->route('admin.games.index')
            ->with('status', 'Created a game successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $game = Game::FindOrFail($id);

        // gets all entries about this specific game
        $entries = DB::table('game_user')
            ->where('game_id', $id)
            ->join('users', 'users.id', '=', 'game_user.user_id')
            ->paginate(10);

        // gets the average score of the specific game id
        $avgScore = DB::table('game_user')->where('game_id', $id)->avg('score');

        return view('admin.games.show', [
            'game' => $game,
            'entries' => $entries,
            'avgScore' => $avgScore,
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
        return view('admin.games.edit', [
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
            // deletes the existing image
            if(Storage::exists('public/images/'.$game->image)){
                Storage::delete('public/images/'.$game->image);
            }
            // image name is the timestamp + the provided file extension
            $imageName = time().'.'.$request->image->extension();
            // stores the file in public/images as the image name
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
            ->route('admin.games.index')
            ->with('status', 'Edited a game successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $game = Game::findOrFail($id);
        // detaches all the genres from the game
        $game->genres()->detach();
        $game->delete();

        return redirect()
            ->route('admin.games.index')
            ->with('status', 'Deleted a game successfully!');
    }
}
