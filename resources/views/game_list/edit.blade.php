@extends('layouts.userOrAdmin')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('My games') }}
</h2>
@endsection

@section('content')
<div class='mx-auto' style='width: 1000px'>
    <h1 class='text-2xl font-bold my-3'>Edit entry</h3>

    <form action='{{ route('game_list.update', $entry->id) }}' method='post'>
        @csrf
        @method('PUT')

        <div class='mt-3'>
            <h2 class='font-semibold text-lg my-2'>Game: {{ $entry->game->title }}</h2>
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
                    {{!old('status') && $status === $entry->status ? "selected" : ''}}
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
            <input type='date' name='start_date' value='{{ old('start_date', $entry->start_date) }}' class='form-control w-25'>

            {{-- Start date error area --}}
            @if ($errors->has('start_date'))
                <span class='d-block text-red-600'>{{ $errors->first('start_date') }}</span>
            @endif
        </div>

        {{-- End date --}}
        <div class='mt-3'>
            <label for='end_date'>End date</label>
            <input type='date' name='end_date' value='{{ old('end_date', $entry->end_date) }}' class='form-control w-25'>

            {{-- End date error area --}}
            @if ($errors->has('end_date'))
                <span class='d-block text-red-600'>{{ $errors->first('end_date') }}</span>
            @endif
        </div>

        {{-- Score --}}
        <div class='mt-3'>
            <label for='score'>Score</label>
            <input type='number'  min='0' max='10' value='{{ old('score', $entry->score) }}'
            name='score' placeholder='Score' class='form-control w-25'>

            {{-- Score error area --}}
            @if ($errors->has('score'))
                <span class='d-block text-red-600'>{{ $errors->first('score') }}</span>
            @endif
        </div>

        {{-- Review --}}
        <div class='mt-3'>
            <label for='review'>Review</label>
            <textarea name='review' class='form-control d-block w-100'>{{ old('review', $entry->review) }}</textarea>

            {{-- Review error area --}}
            @if ($errors->has('review'))
                <span class='d-block text-red-600'>{{ $errors->first('review') }}</span>
            @endif
        </div>

        <button type='submit' class='py-3 my-3 btn btn-primary bg-blue-500'>Edit game</button>
    </form>
</div>
@endsection