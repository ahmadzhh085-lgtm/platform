<nav id="sidebar" class="sidebar bg-white shadow-sm border-end">
    <div class="sidebar-header p-3 mb-2 border-bottom">
        <span class="fs-4 fw-bold">RealEstate Admin</span>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link d-flex align-items-center" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link d-flex align-items-center" href="{{ route('admin.projects.index') }}"><i class="bi bi-building me-2"></i> Projects</a></li>
        <li class="nav-item"><a class="nav-link d-flex align-items-center" href="{{ route('admin.properties.index') }}"><i class="bi bi-house-door me-2"></i> Properties</a></li>
        <li class="nav-item"><a class="nav-link d-flex align-items-center" href="{{ route('admin.investors.index') }}"><i class="bi bi-people me-2"></i> Investors</a></li>
        <li class="nav-item"><a class="nav-link d-flex align-items-center" href="{{ route('admin.investments.index') }}"><i class="bi bi-cash-stack me-2"></i> Investments</a></li>
        <li class="nav-item"><a class="nav-link d-flex align-items-center" href="{{ route('admin.payments.index') }}"><i class="bi bi-credit-card me-2"></i> Payments</a></li>
        <li class="nav-item"><a class="nav-link d-flex align-items-center" href="{{ route('admin.employees.index') }}"><i class="bi bi-person-badge me-2"></i> Employees</a></li>
        <li class="nav-item"><a class="nav-link d-flex align-items-center" href="{{ route('admin.reports.index') }}"><i class="bi bi-bar-chart-line me-2"></i> Reports</a></li>
        <li class="nav-item"><a class="nav-link d-flex align-items-center" href="{{ route('admin.settings') }}"><i class="bi bi-gear me-2"></i> Settings</a></li>
    </ul>
</nav>