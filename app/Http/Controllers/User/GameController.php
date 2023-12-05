<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
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

        return view('user.games.index', [
            'games' => $games
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $game = Game::FindOrFail($id);
        return view('user.games.show', [
            'game' => $game
        ]);
    }
}
