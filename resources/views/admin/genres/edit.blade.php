@extends('layouts.admin')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Genres') }}
</h2>
@endsection

@section('content')
<div class='mx-auto' style='width: 1000px'>
    <h1 class='text-2xl font-bold my-3'>Edit genre</h3>

    <form action='{{ route('admin.genres.update', $genre->id) }}' method='post'>
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div>
            <label>Name</label><br />
            <input 
            type='text' 
            name='name' 
            id='name' 
            value='{{ old('name', $genre->name) }}' 
            class = "rounded-md"/>

            {{-- Name error area --}}
            @if ($errors->has('name'))
                <span class='d-block text-red-600'>{{ $errors->first('name') }}</span>
            @endif
        </div>

        <button type='submit' class='py-3 my-3 btn btn-primary bg-blue-500'>Finish editing</button>
    </form>
</div>
@endsection