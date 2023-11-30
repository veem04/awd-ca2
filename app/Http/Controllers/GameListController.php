<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameEntry;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class GameListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // returns 8 games at a time, paginated
        $entries = GameEntry::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->paginate(8);
        
        return view('game_list.index', [
            'entries' => $entries
        ]);
    }

    public function show(string $id)
    {
        $entry = GameEntry::FindOrFail($id);

        return view('game_list.show', [
            'entry' => $entry
        ]);
    }

    public function create()
    {
        $games = Game::orderBy('title', 'desc')->get();

        // create an array of all game entries matching the user's ID
        $entries = GameEntry::where('user_id', Auth::user()->id)
                    ->pluck('game_id')
                    ->toArray();

        // returns the view with the games, entries and the enum
        return view('game_list.create', [
            'games' => $games,
            'entries' => $entries,
            'statusEnum' => GameEntry::$statusEnum,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    // validation rules
    
    // checks the entry is unique for the given user
    $uniqueEntry = Rule::unique('game_user', 'game_id')->where('user_id', Auth::user()->id);

    $rules = [
        'game' => "required|int|exists:games,id|$uniqueEntry",
        'status' => ['required', Rule::in(GameEntry::$statusEnum)],
        'start_date' => 'nullable|date|before_or_equal:'.date('Y-m-d'),
        'end_date' => 'nullable|date|before_or_equal:'.date('Y-m-d').'|after_or_equal:start_date',
        'score' => 'nullable|int|min:0|max:10',
        'review' => 'nullable|string|max:20000',
    ];

    // unique validation messages
    $messages = [
        'game.unique' => 'That game is already on your list.',
        'start_date.before_or_equal' => 'Start date cannot be in the future.',
        'end_date.before_or_equal' => 'End date cannot be in the future.',
        'end_date.after_or_equal' => 'End date cannot be before start date.',
    ];


    $request->validate($rules, $messages);

    $entry = new GameEntry;
    $entry->game_id = $request->game;
    $entry->user_id = Auth::user()->id;
    $entry->status = $request->status;
    $entry->start_date = $request->start_date;
    $entry->end_date = $request->end_date;
    $entry->score = $request->score;
    $entry->review = $request->review;
    $entry->save();

    return redirect()
            ->route('game_list.index')
            ->with('status', 'Added an entry successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $entry = GameEntry::FindOrFail($id);

        // returns the view with the entry and enum
        return view('game_list.edit', [
            'entry' => $entry,
            'statusEnum' => GameEntry::$statusEnum
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'status' => ['required', Rule::in(GameEntry::$statusEnum)],
            'start_date' => 'nullable|date|before_or_equal:'.date('Y-m-d'),
            'end_date' => 'nullable|date|before_or_equal:'.date('Y-m-d').'|after_or_equal:start_date',
            'score' => 'nullable|int|min:0|max:10',
            'review' => 'nullable|string|max:20000',
        ];

        // unique validation messages
        $messages = [
            'start_date.before_or_equal' => 'Start date cannot be in the future.',
            'end_date.before_or_equal' => 'End date cannot be in the future.',
            'end_date.after_or_equal' => 'End date cannot be before start date.',
        ];

        $request->validate($rules, $messages);

        $entry = GameEntry::findOrFail($id);
        $entry->status = $request->status;
        $entry->start_date = $request->start_date;
        $entry->end_date = $request->end_date;
        $entry->score = $request->score;
        $entry->review = $request->review;
        $entry->save();

        // redirects you to the main table
        return redirect()
            ->route('game_list.index')
            ->with('status', 'Edited an entry successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entry = GameEntry::findOrFail($id);
        $entry->delete();

        return redirect()
            ->route('game_list.index')
            ->with('status', 'Deleted an entry successfully!');
    }
}
