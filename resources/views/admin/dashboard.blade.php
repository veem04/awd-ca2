<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

@extends('layouts.admin')
@section('header')    
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in as an admin!") }}
                </div>
            </div>
        </div>
    </div>

    {{-- @if(session('unauthorised'))
    <div id='alert' class='mx-20 mb-5 alert alert-danger' role='alert'>
        {{ session('unauthorised') }}
    </div>
    @endif --}}
@endsection

{{-- <script>
    let alert = document.getElementById('alert');
    setTimeout(() => {
        alert.remove();
    }, 5000);
</script> --}}