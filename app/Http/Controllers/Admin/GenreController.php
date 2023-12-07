<?php

namespace App\Http\Controllers\Admin;

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

        return view('admin.genres.index', [
            'genres' => $genres
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.genres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation rules
        $rules = [
            'name' => "required|string|unique:genres,name|min:2|max:32"
        ];

        // unique validation messages
        $messages = [
            // 
        ];

        $request->validate($rules, $messages);

        // save the new genre
        $genre = new Genre;
        $genre->name = $request->name;
        $genre->save();

        // returns you to the table page
        return redirect()
            ->route('admin.genres.index')
            ->with('status', 'Created a genre successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $genre = Genre::FindOrFail($id);
        return view('admin.genres.show', [
            'genre' => $genre
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $genre = Genre::FindOrFail($id);

        return view('admin.genres.edit', [
            'genre' => $genre
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validation rules
        $rules = [
            'name' => "required|string|unique:genres,name,{$id}|min:2|max:32",
        ];

        // unique validation messages
        $messages = [
            // 
        ];

        $request->validate($rules, $messages);

        // update the genre
        $genre = Genre::findOrFail($id);
        $genre->name = $request->name;
        $genre->save();

        // redirects you to the main table
        return redirect()
            ->route('admin.genres.index')
            ->with('status', 'Edited a genre successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return redirect()
            ->route('admin.genres.index')
            ->with('status', 'Deleted a genre successfully!');
    }
}
