@extends('layouts.base')

@section('body')
<div class="app-shell">
    @include('partials.sidebar')

    <div class="app-content">
        @include('partials.header')

        <main class="main-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
    </div>
</div>
@endsection