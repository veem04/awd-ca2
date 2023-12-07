<?php

namespace App\Http\Controllers\User;

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

        return view('user.publishers.index', [
            'publishers' => $publishers
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $publisher = Publisher::FindOrFail($id);
        return view('user.publishers.show', [
            'publisher' => $publisher
        ]);
    }
}
