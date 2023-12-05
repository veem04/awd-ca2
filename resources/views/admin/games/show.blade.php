@extends('layouts.admin')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Games Database') }}
</h2>
@endsection

@section('content')
    <h1 class="font-bold text-2xl">Game details</h1>

    <div class='d-inline-block w-25 align-top'>
        <h2 class='font-semibold text-lg my-2'>Game: {{ $game->title }}</h2>
        <p class='my-2'>
            <span class='font-semibold'>Publisher:</span>
            @if ($game->publisher)
            {{ $game->publisher->name }}
            @else
            <span class='text-red-600 font-semibold'>No publisher - please update.</span>
            @endif
        </p>
        <p class='my-2'>
            <span class='font-semibold'>Genres:</span>
            @if ($game->genres->isNotEmpty())
            {{ $game->genres->pluck('name')->implode(', ') }}    
            @else
            <span class='text-red-600 font-semibold'>No genres - please update.</span>
            @endif
        </p>

        <div class='pt-3'>
            <a href='{{ route('admin.games.edit', $game->id) }}'
            class='px-3 py-3 font-medium text-white bg-blue-600 rounded-md duration-300 hover:bg-blue-800'>
                Edit
            </a>
    
            <form method='POST' action='{{ route('admin.games.destroy', $game->id)}}' class='mt-6'>
                @csrf
                @method('DELETE')
                <button type='submit' 
                class='px-3 py-3 font-medium text-white bg-red-600 rounded-md duration-300 hover:bg-red-800'>
                    Delete
                </button>
            </form>
        </div>
    </div>
    

    
    @if ($game->image)
    <div class='d-inline-block w-25'>
        <img src='{{asset('storage/images/'.$game->image)}}'>
    </div>
    @endif
@endsection