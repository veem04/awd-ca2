@extends('layouts.admin')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Publishers') }}
</h2>
@endsection

@section('content')
    <h1 class="font-bold text-2xl">Publisher details</h1>
    <h2 class='text-lg my-2'>Publisher: {{ $publisher->name }}</h2>
    
    <p class='my-2'>
        <span class='font-semibold'>Description:</span>
        {{ $publisher->description }}
    </p>

    <p class='my-2'>
        <span class='font-semibold'>Address:</span>
        {{ $publisher->address }}
    </p>
    
    <div class='pt-3'>
        <a href='{{ route('admin.publishers.edit', $publisher->id) }}'
        class='px-3 py-3 font-medium text-white bg-blue-600 rounded-md duration-300 hover:bg-blue-800'>
            Edit
        </a>

        <form method='POST' action='{{ route('admin.publishers.destroy', $publisher->id)}}' class='mt-6'>
            @csrf
            @method('DELETE')
            <button type='submit' 
            class='px-3 py-3 font-medium text-white bg-red-600 rounded-md duration-300 hover:bg-red-800'>
                Delete
            </button>
        </form>
    </div>

    <div class='my-5'>
        <h2 class='font-bold text-xl mb-3'>{{ $publisher->name }}'s games</h2>
        <table class='table'>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Publisher</th>
                    <th>Genres</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($publisher->games as $game)
                <tr>
                    <th scope='row'>{{$game->title}}</th>
                    <td>
                        @if ($game->publisher)
                        {{ $game->publisher->name }}
                        @else
                        <span class='text-red-600 font-semibold'>No publisher.</span>
                        @endif
                    </td>
                    <td>
                        @if ($game->genres->isNotEmpty())
                        {{ $game->genres->pluck('name')->implode(', ') }}    
                        @else
                        <span class='text-red-600 font-semibold'>No genres.</span>
                        @endif
                    </td>
                    <td>
                        <div class='my-2.5'>
                        <a href='{{ route('admin.games.show', $game->id) }}' 
                            class='px-3 py-3 font-medium text-white bg-blue-600 rounded-md duration-300 hover:bg-blue-800'>
                            See more
                        </a>
                    </div>
                </td>
            </tr>
                @empty
                No rows found.
                @endforelse
            </tbody>
        </table>
    </div>
@endsection