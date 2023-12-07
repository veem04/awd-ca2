@extends('layouts.admin')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Publishers') }}
</h2>
@endsection

@section('content')
<div class='mx-auto' style='width: 1000px'>
    <h1 class='text-2xl font-bold my-3'>Edit publisher</h3>

    <form action='{{ route('admin.publishers.update', $publisher->id) }}' method='post'>
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div>
            <label>Name</label><br />
            <input 
            type='text' 
            name='name' 
            id='name' 
            value='{{ old('name', $publisher->name) }}' 
            class = "rounded-md"/>

            {{-- Name error area --}}
            @if ($errors->has('name'))
                <span class='d-block text-red-600'>{{ $errors->first('name') }}</span>
            @endif
        </div>

        {{-- Description --}}
        <div>
            <label>Description</label><br />
            <textarea
            name='description' 
            id='description'
            class = "rounded-md w-50"
            >{{ old('description', $publisher->description) }}</textarea>

            {{-- Description error area --}}
            @if ($errors->has('description'))
                <span class='d-block text-red-600'>{{ $errors->first('description') }}</span>
            @endif
        </div>

        {{-- Address --}}
        <div>
            <label>Address</label><br />
            <input
            type='text'
            name='address'
            id='address'
            value='{{ old('address', $publisher->address) }}'
            class = "rounded-md w-50"/>

            {{-- Address error area --}}
            @if ($errors->has('address'))
                <span class='d-block text-red-600'>{{ $errors->first('address') }}</span>
            @endif
        </div>


        <button type='submit' class='py-3 my-3 btn btn-primary bg-blue-500'>Finish editing</button>
    </form>
</div>
@endsection