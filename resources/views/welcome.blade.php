<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investment Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">

    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand text-white p-3 fw-bold">
            INVESTMENT
        </div>
    </div>

    <ul class="sidebar-nav mt-3">

        <li class="nav-item">
            <a class="nav-link active" href="#">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-building me-2"></i>
                Properties
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-cash-stack me-2"></i>
                Investments
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-people me-2"></i>
                Investors
            </a>
        </li>

    </ul>

</div>

<div class="wrapper d-flex flex-column min-vh-100 bg-light">

    <header class="header header-sticky p-3 border-bottom bg-white">

        <div class="container-fluid d-flex justify-content-between">

            <h4 class="mb-0">
                Admin Dashboard
            </h4>

            <div>
                <button class="btn btn-primary">
                    Add Property
                </button>
            </div>

        </div>

    </header>

    <div class="body flex-grow-1 px-4 py-4">

        <div class="container-fluid">

            <div class="row g-4">

                <div class="col-md-3">
                    <div class="card text-white bg-primary shadow border-0 rounded-4">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>
                                    <h3>$250K</h3>
                                    <p>Total Investments</p>
                                </div>

                                <i class="bi bi-cash-stack fs-1"></i>

                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white bg-success shadow border-0 rounded-4">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>
                                    <h3>45</h3>
                                    <p>Properties</p>
                                </div>

                                <i class="bi bi-building fs-1"></i>

                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white bg-warning shadow border-0 rounded-4">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>
                                    <h3>120</h3>
                                    <p>Investors</p>
                                </div>

                                <i class="bi bi-people fs-1"></i>

                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white bg-danger shadow border-0 rounded-4">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>
                                    <h3>$35K</h3>
                                    <p>Monthly Profit</p>
                                </div>

                                <i class="bi bi-graph-up-arrow fs-1"></i>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>