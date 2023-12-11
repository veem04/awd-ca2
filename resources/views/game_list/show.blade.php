@extends('layouts.userOrAdmin')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('My games') }}
</h2>
@endsection

@section('content')
    @php
        $game = $entry->game
    @endphp
    <h1 class="font-bold text-2xl">Game details</h1>

    <div class='d-inline-block w-25 align-top'>
        <h2 class='font-semibold text-lg my-2'>Game: 
            <a 
            class='text-blue-500 hover:underline'
            href="{{route(Auth::user()->hasRole('admin') ? 'admin.games.show' : 'user.games.show', $game->id)}} ">
                {{ $game->title }}
            </a>
        </h2>

        <p class='my-2'>
            <span class='font-semibold'>Publisher:</span>
            @if ($game->publisher)
            {{ $game->publisher->name }}
            @else
            <span class='text-red-600 font-semibold'>No publisher. Please contact an administrator.</span>
            @endif
        </p>

        <p class='my-2'>
            <span class='font-semibold'>Genres:</span>
            @if ($game->genres->isNotEmpty())
            {{ $game->genres->pluck('name')->implode(', ') }}    
            @else
            <span class='text-red-600 font-semibold'>No genres. Please contact an administrator.</span>
            @endif
        </p>

        <p class='my-2'>
            <span class='font-semibold'>Status:</span>
            {{ $entry->status }}
        </p>

        <p class='my-2'>
            <span class='font-semibold'>Score:</span>
            @if ($entry->score)
                {{$entry->score}}
            @else
                <span class='fst-italic'>No score.</span>
            @endif
        </p>

        <p class='my-2'>
            <span class='font-semibold'>Start date:</span>
            @if ($entry->start_date)
                {{$entry->start_date}}
            @else
                <span class='fst-italic'>Not started.</span>
            @endif
        </p>

        <p class='my-2'>
            <span class='font-semibold'>End date:</span>
            @if ($entry->end_date)
                {{$entry->end_date}}
            @else
                <span class='fst-italic'>Not finished.</span>
            @endif
        </p>

        
    </div>
    
    @if ($game->image)
    <div class='d-inline-block w-25'>
        <img src='{{asset('storage/images/'.$game->image)}}'>
    </div>
    @endif

    <div>
        <p class='my-2'>
            <span class='font-semibold d-block'>Review:</span>
            @if ($entry->review)
                {{$entry->review}}
            @else
                <span class='fst-italic'>No review.</span>
            @endif
        </p>
    </div>

    <div class='pt-3'>
        <a href='{{ route('game_list.edit', $entry->id) }}'
        class='px-3 py-3 font-medium text-white bg-blue-600 rounded-md duration-300 hover:bg-blue-800'>
            Edit
        </a>

        <form method='POST' action='{{ route('game_list.destroy', $game->id)}}' class='mt-6'>
            @csrf
            @method('DELETE')
            <button type='submit' 
            class='px-3 py-3 font-medium text-white bg-red-600 rounded-md duration-300 hover:bg-red-800'>
                Delete
            </button>
        </form>
    </div>
@endsection