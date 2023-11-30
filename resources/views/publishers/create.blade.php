@extends('layouts.myApp')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Publishers') }}
</h2>
@endsection

@section('content')
<div class='mx-auto' style='width: 1000px'>
    <h1 class='text-2xl font-bold my-3'>Create publisher</h3>

    <form action='{{ route('publishers.store') }}' method='post'>
        @csrf

        {{-- Name --}}
        <div>
            <label>Name</label><br />
            <input 
            type='text' 
            name='name' 
            id='name' 
            value='{{ old('name') }}' 
            class = "rounded-md"/>

            {{-- Name error area --}}
            @if ($errors->has('name'))
                <span class='d-block text-red-600'>{{ $errors->first('name') }}</span>
            @endif
        </div>

        <button type='submit' class='py-3 my-3 btn btn-primary bg-blue-500'>Create publisher</button>
    </form>
</div>
@endsection