@extends('layouts.myApp')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Games Database') }}
</h2>
@endsection

@section('content')
<div class='mx-auto' style='width: 1000px'>
    <h1 class='text-2xl font-bold my-3'>Create game</h3>

    <form action='{{ route('games.store') }}' method='post' enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div>
            <label>Title</label><br />
            <input 
            type='text' 
            name='title' 
            id='title' 
            value='{{ old('title') }}' 
            class = "rounded-md"/>

            {{-- Title error area --}}
            @if ($errors->has('title'))
                <span class='d-block text-red-600'>{{ $errors->first('title') }}</span>
            @endif
        </div>

        {{-- Publisher --}}
        <div class='mt-3'>
            <label>Publisher</label>
            <select class='form-select w-50 rounded-md' name='publisher'>
                <option>---</option>
                @forelse($publishers as $publisher)
                <option 
                value="{{ $publisher->id }}"
                {{old('publisher') == $publisher->id ? 'selected' : ''}}
                >
                    {{ $publisher->name }}
                </option>
                @empty
                ---
                @endforelse
            </select>

            {{-- Publisher error area --}}
            @if ($errors->has('publisher'))
                <span class='d-block text-red-600'>{{ $errors->first('publisher') }}</span>
            @endif
        </div>

        {{-- Genre --}}
        <div class='mt-3'>
            <label>Genres</label>
            @php
            // I made it 5 columns long but this might be better if it wasn't hardcoded
            $rowlength = 5;
            $rows = ceil(count($genres) / $rowlength);
            @endphp

            @if ($rows > 0)
            <ul class='list-group'>

                {{-- Per row --}}
                @for ($i = 0; $i < $rows; $i++)
                <ul class="list-group list-group-horizontal">

                    {{-- Per item --}}
                    @for ($j = 0; $j < $rowlength && ($i*$rowlength)+$j < count($genres); $j++)
                    @php
                    $genre = $genres[($i*$rowlength) + $j];
                    @endphp
                    <li class="list-group-item w-100 py-3">
                        <input 
                        class="form-check-input me-1" 
                        type="checkbox" 
                        id="genre_{{ $genre->id }}" 
                        value="{{ $genre->id }}"
                        name='genres[]'
                        aria-label="..." 

                        {{-- Only if there are genres stored in memory --}}
                        @if (old('genres'))
                        {{in_array($genre->id, old('genres')) ? 'checked' : ''}}
                        @endif
                        >
                        <label for='{{ $genre->id }}'>{{ $genre->name }}</label>
                    </li>
                    @endfor
                </ul>
                @endfor
            </ul>
            
            @else
            No genres found.
            @endif

            {{-- Genre error (missing genre) --}}
            @if ($errors->has('genres'))
            <span class='d-block text-red-600'>{{ $errors->first('genres') }}</span>
            @endif

            {{-- Genre error (invalid genre) --}}
            @if ($errors->has('genres.*'))    
            <span class='d-block text-red-600'>{{ $errors->first('genres.*') }}</span>
            @endif

        </div>

        {{-- Image --}}
        <div class='mt-3'>
            <label for='image' class='d-block'>Image</label>
            <input type='file' id='image' name='image' accept='image/*'>

            {{-- Image error --}}
            @if ($errors->has('image'))
            <span class='d-block text-red-600'>{{ $errors->first('image') }}</span>
            @endif
        </div>

        <button type='submit' class='py-3 my-3 btn btn-primary bg-blue-500'>Create game</button>
    </form>
</div>
@endsection