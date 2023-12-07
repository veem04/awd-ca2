@extends('layouts.myApp')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Genres') }}
</h2>
@endsection

@section('content')

    @forelse($genres as $genre)
    <div class="d-inline-flex flex-row">
        <div class="card py-1 px-3 m-2">
            <div class="card-body">
                <h5 class="h5 card-title mb-3">{{ $genre->name }}</h5>
                <a href="{{ route('admin.genres.show', $genre->id) }}"
                class='p-2 font-medium text-white bg-blue-600 rounded-md duration-300 hover:bg-blue-800'>
                    See more
                </a>
            </div>
        </div>
    </div>
    @empty
    No genres found.
    @endforelse

    {{-- <table class='table'>
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($genres as $genre)
            <tr>
                <th scope='row'>{{$genre->name}}</th>
                <td>
                    <div class='my-2.5'>
                    <a href='{{ route('user.genres.show', $genre->id) }}' 
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
    </table> --}}

    {{-- Pagination --}}
    <div class='py-3'>
        {{ $genres->links() }}
    </div>
@endsection