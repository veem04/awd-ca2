@extends('layouts.myApp')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Publishers') }}
</h2>
@endsection

@section('content')
    <h1 class="font-bold text-2xl">Publisher details</h1>
    <h2 class='text-lg my-2'>Publisher: {{ $publisher->name }}</h2>
    
    <div class='pt-3'>
        <a href='{{ route('publishers.edit', $publisher->id) }}'
        class='px-3 py-3 font-medium text-white bg-blue-600 rounded-md duration-300 hover:bg-blue-800'>
            Edit
        </a>

        <form method='POST' action='{{ route('publishers.destroy', $publisher->id)}}' class='mt-6'>
            @csrf
            @method('DELETE')
            <button type='submit' 
            class='px-3 py-3 font-medium text-white bg-red-600 rounded-md duration-300 hover:bg-red-800'>
                Delete
            </button>
        </form>
    </div>
@endsection