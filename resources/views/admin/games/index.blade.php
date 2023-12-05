@extends('layouts.myApp')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Games Database') }}
</h2>
@endsection

@section('content')
    <div class='mx-3 my-4'>
        <a href='{{ route('admin.games.create') }}' class='px-3 py-3 font-medium text-white bg-blue-600 rounded-md duration-300 hover:bg-blue-800'>Create</a>
    </div>

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
            @forelse($games as $game)
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

    {{-- Pagination --}}
    <div class='py-3'>
        {{ $games->links() }}
    </div>
@endsection