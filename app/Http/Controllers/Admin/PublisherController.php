<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publisher;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // returns 8 publishers at a time, paginated
        $publishers = Publisher::orderBy('created_at', 'desc')->paginate(8);

        return view('admin.publishers.index', [
            'publishers' => $publishers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.publishers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation rules
        $rules = [
            'name' => "required|string|unique:publishers,name|min:2|max:100",
            'description' => "required|string|min:2|max:250",
            'address' => "required|string|min:2|max:250",
        ];

        // unique validation messages
        $messages = [
            // 
        ];

        $request->validate($rules, $messages);

        // save the new publisher
        $publisher = new Publisher;
        $publisher->name = $request->name;
        $publisher->description = $request->description;
        $publisher->address = $request->address;
        $publisher->save();

        // returns you to the table page
        return redirect()
            ->route('admin.publishers.index')
            ->with('status', 'Created a publisher successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $publisher = Publisher::FindOrFail($id);
        return view('admin.publishers.show', [
            'publisher' => $publisher
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $publisher = Publisher::FindOrFail($id);

        return view('admin.publishers.edit', [
            'publisher' => $publisher
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validation rules
        $rules = [
            'name' => "required|string|unique:publishers,name,{$id}|min:2|max:100",
            'description' => "required|string|min:2|max:250",
            'address' => "required|string|min:2|max:250",
        ];

        // unique validation messages
        $messages = [
            // 
        ];

        $request->validate($rules, $messages);

        // update the publisher
        $publisher = Publisher::findOrFail($id);
        $publisher->name = $request->name;
        $publisher->description = $request->description;
        $publisher->address = $request->address;
        $publisher->save();

        // redirects you to the main table
        return redirect()
            ->route('admin.publishers.index')
            ->with('status', 'Edited a publisher successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $publisher = Publisher::findOrFail($id);
        $publisher->delete();

        return redirect()
            ->route('admin.publishers.index')
            ->with('status', 'Deleted a publisher successfully!');
    }
}
