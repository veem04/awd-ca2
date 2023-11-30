@extends('layouts.myApp')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('My games') }}
</h2>
@endsection

@section('content')
<div class='mx-auto' style='width: 1000px'>
    <h1 class='text-2xl font-bold my-3'>Add game entry</h3>

    <form action='{{ route('game_list.store') }}' method='post'>
        @csrf

        {{-- Game --}}
        <div class='mt-3'>
            <label for='game'>Game</label>
            <select name='game' class='form-control w-50'>
                <option>---</option>
                @foreach ($games as $game)
                <option
                value='{{ $game->id }}'
                {{old('game') == $game->id ? 'selected' : ''}}
                {{in_array($game->id, $entries) ? 'disabled' : ''}}
                >
                {{ $game->title }} {{in_array($game->id, $entries) ? '- already on list' : ''}}
                </option>
                @endforeach
            </select>

            {{-- Game error area --}}
            @if ($errors->has('game'))
                <span class='d-block text-red-600'>{{ $errors->first('game') }}</span>
            @endif
        </div>

        {{-- Status --}}
        <div class='mt-3'>
            <label for='status'>Status</label>
            <select name='status' class='form-control w-25'>
                <option>---</option>
                @foreach ($statusEnum as $status)
                    <option
                    value='{{$status}}'
                    {{old('status') == $status ? 'selected' : ''}}
                    >
                        {{ $status }}
                    </option>
                @endforeach
            </select>

            {{-- Status error area --}}
            @if ($errors->has('status'))
                <span class='d-block text-red-600'>{{ $errors->first('status') }}</span>
            @endif
        </div>

        {{-- Start date --}}
        <div class='mt-3'>
            <label for='start_date'>Start date</label>
            <input type='date' name='start_date' value='{{ old('start_date') }}' class='form-control w-25'>

            {{-- Start date error area --}}
            @if ($errors->has('start_date'))
                <span class='d-block text-red-600'>{{ $errors->first('start_date') }}</span>
            @endif
        </div>

        {{-- End date --}}
        <div class='mt-3'>
            <label for='end_date'>End date</label>
            <input type='date' name='end_date' value='{{ old('end_date') }}' class='form-control w-25'>

            {{-- End date error area --}}
            @if ($errors->has('end_date'))
                <span class='d-block text-red-600'>{{ $errors->first('end_date') }}</span>
            @endif
        </div>

        {{-- Score --}}
        <div class='mt-3'>
            <label for='score'>Score</label>
            <input type='number'  min='0' max='10' value='{{ old('score') }}'
            name='score' placeholder='Score' class='form-control w-25'>

            {{-- Score error area --}}
            @if ($errors->has('score'))
                <span class='d-block text-red-600'>{{ $errors->first('score') }}</span>
            @endif
        </div>

        {{-- Review --}}
        <div class='mt-3'>
            <label for='review'>Review</label>
            <textarea name='review' class='form-control d-block w-50'>{{ old('review') }}</textarea>

            {{-- Review error area --}}
            @if ($errors->has('review'))
                <span class='d-block text-red-600'>{{ $errors->first('review') }}</span>
            @endif
        </div>

        <button type='submit' class='py-3 my-3 btn btn-primary bg-blue-500'>Add game</button>
    </form>
</div>
@endsection