@extends('layouts.myApp')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Publishers') }}
</h2>
@endsection

@section('content')

    <table class='table'>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($publishers as $publisher)
            <tr>
                <th class='whitespace-nowrap' scope='row'>{{$publisher->name}}</th>
                <td>{{$publisher->description}}</td>
                <td>{{$publisher->address}}</td>
                <td class='whitespace-nowrap'>
                    <div class='m-2.5'>
                    <a href='{{ route('user.publishers.show', $publisher->id) }}' 
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