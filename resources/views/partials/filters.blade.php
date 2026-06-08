<form method="GET" class="row g-2 mb-3">
    {{-- Search by name --}}
    <div class="col-md-3">
        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name..." value="{{ request('search') }}">
    </div>
    
    {{-- Filter by status (for projects) --}}
    @if(isset($statuses))
    <div class="col-md-3">
        <select name="status" class="form-select form-select-sm">
            <option value="">All Statuses</option>
            @foreach($statuses as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>
    @endif
    
    {{-- Filter by location (for projects) --}}
    @if(Route::currentRouteName() == 'admin.projects.index')
    <div class="col-md-3">
        <input type="text" name="location" class="form-control form-control-sm" placeholder="Search by location..." value="{{ request('location') }}">
    </div>
    @endif
    
    <div class="col-auto">
        <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search"></i> Filter</button>
    </div>
    <div class="col-auto">
        <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
    </div>
</form>