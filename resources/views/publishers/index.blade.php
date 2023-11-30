@extends('layouts.myApp')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Publishers') }}
</h2>
@endsection

@section('content')
    <div class='mx-3 my-4'>
        <a href='{{ route('publishers.create') }}' class='px-3 py-3 font-medium text-white bg-blue-600 rounded-md duration-300 hover:bg-blue-800'>Create</a>
    </div>

    <table class='table'>
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($publishers as $publisher)
            <tr>
                <th scope='row'>{{$publisher->name}}</th>
                <td>
                    <div class='my-2.5'>
                    <a href='{{ route('publishers.show', $publisher->id) }}' 
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
        {{ $publishers->links() }}
    </div>
@endsection