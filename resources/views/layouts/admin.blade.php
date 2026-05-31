@extends('layouts.base')

@section('body')
<div class="d-flex" id="wrapper">
    @include('partials.sidebar')
    <div id="page-content-wrapper" class="flex-grow-1 d-flex flex-column min-vh-100 bg-light">
        @include('partials.header')
        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>
    </div>
</div>
@endsection