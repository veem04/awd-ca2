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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="d-flex justify-content-between">
                <h4 class="h4 font-bold">Reviews of {{ $game->title }}</h4>
                <h4 class="h4 font-bold">Average score: {{ $avgScore }}</h4>
            </div>

            @forelse ($entries as $entry)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-3">
                <div class="p-6 text-gray-900">
                    <div class="d-flex justify-content-between">
                        <div class="h5 text-bold">
                            {{ $entry->name }}
                        </div>
                        @php
                            switch (true) {
                                case $entry->score < 4:
                                    $colour = 'red';
                                    break;
                                case $entry->score < 7:
                                    $colour = 'yellow';
                                    break;
                                default:
                                    $colour = 'green';
                                    break;
                            }
                        @endphp
                        
                        <div class='d-flex align-items-center'>
                            @if ($entry->status !== 'Played')
                                <p class='text-orange-500'>Has not completed game</p>
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                width="24" height="24" 
                                fill="orange" 
                                class="bi bi-exclamation-diamond-fill mx-2"
                                viewBox="0 0 16 16"
                                data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Tooltip on left">
                                    <path d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098L9.05.435zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                </svg>
                                {{-- there's some code here to display a tooltip that doesn't work --}}
                            @endif
                            
                            {{-- the bg class here is extremely finicky with when it wants to work and i don't know why --}}
                            <div class="d-flex h5 mb-0 text-bold text-white sm:rounded-lg bg-{{ $colour }}-600" style='width:40px; height:40px;'>
                                <p class='m-auto'>{{ $entry->score }}</p>
                            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
@endsection
