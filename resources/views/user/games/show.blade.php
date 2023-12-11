@extends('layouts.myApp')

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
    </div>
    

    
    @if ($game->image)
    <div class='d-inline-block w-25'>
        <img src='{{asset('storage/images/'.$game->image)}}'>
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h4 class="h4 font-bold">Reviews of {{ $game->title }}</h4>
            @forelse ($entries as $entry)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-3">
                <div class="p-6 text-gray-900">
                    <div class="d-flex justify-content-between">
                        <div class="h5 text-bold">
                            {{ $entry->name }}
                        </div>
                        @php
                            switch (true) {
                                case $entry->score < 6:
                                    $colour = 'red';
                                    break;
                                default:
                                    $colour = 'green';
                                    break;
                                // i tried to have a yellow case but none of yellow, orange or amber bg would work
                            }
                        @endphp
                        <div class="d-flex h5 text-bold text-white sm:rounded-lg bg-{{$colour}}-600" style='width:40px; height:40px;'>
                            <p class='m-auto'>{{ $entry->score }}</p>
                        </div>
                    </div>
                    <div>
                        {{ $entry->review }}
                    </div>
                </div>
            </div>
            {{ $entries->links() }}
            @empty
            No reviews were found.
            @endforelse
        </div>
    </div>
@endsection