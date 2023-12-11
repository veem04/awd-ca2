@extends('layouts.userOrAdmin')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('My games') }}
</h2>
@endsection

@section('content')
    <div class='mx-3 my-4'>
        <a href='{{ route('game_list.create') }}' 
            class='px-3 py-3 font-medium text-white bg-blue-600 rounded-md duration-300 hover:bg-blue-800'>
            Add game
        </a>
    </div>

    <table class='table'>
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Score</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($entries as $entry)
            @php
                $game = $entry->game;
            @endphp
            <tr>
                <th scope='row'>{{$game->title}}</th>
                <td>
                    {{ $entry->status }}
                </td>
                <td>
                    {{ $entry->score ? $entry->score : '-' }}
                </td>
                <td>
                    <div class='my-2.5'>
                    <a href='{{ route('game_list.show', $entry->id) }}' 
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
        {{ $entries->links() }}
    </div>
@endsection