<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
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
        $entries = DB::table('game_user')
            ->where('game_id', $id)
            ->join('users', 'users.id', '=', 'game_user.user_id')
            ->paginate(10);
            $avgScore = DB::table('game_user')->where('game_id', $id)->avg('score');

        return view('user.games.show', [
            'game' => $game,
            'entries' => $entries,
            'avgScore' => $avgScore,
        ]);
    }
}
