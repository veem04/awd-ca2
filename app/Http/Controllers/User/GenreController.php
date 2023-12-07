<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // returns 8 genres at a time, paginated
        $genres = Genre::orderBy('created_at', 'desc')->paginate(24);

        return view('user.genres.index', [
            'genres' => $genres
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $genre = Genre::FindOrFail($id);
        return view('user.genres.show', [
            'genre' => $genre
        ]);
    }
}
