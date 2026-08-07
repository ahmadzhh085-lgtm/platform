@extends('layouts.base')

@section('body')
<div class="d-flex min-vh-100 bg-light">
    @include('partials.sidebar')

    <div class="flex-grow-1 d-flex flex-column min-vh-100">
        @include('partials.header')

        <main class="flex-grow-1 p-4 p-lg-5">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
    </div>
</div>
@endsection