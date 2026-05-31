<form method="GET" class="row g-2 mb-3">
    {{-- Example filter fields, customize per page --}}
    <div class="col-auto">
        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="{{ request('search') }}">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
    </div>
    <div class="col-auto">
        <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-secondary">Reset</a>
    </div>
</form>