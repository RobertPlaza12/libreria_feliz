
<?php

$pageTitle = 'Dashboard';
$currentPage = 'dashboard';

require_once __DIR__ . '/includes/header.php';

?>

<div class="mb-4">

    <h1 class="h3 fw-bold mb-2">
        Dashboard
    </h1>

    <p class="text-muted mb-0">
        Bienvenido a Libreria Feliz.
        Administra tus títulos y tiendas desde un solo lugar.
    </p>

</div>

<div class="row g-4 mb-4">

    <div class="col-12 col-md-6 col-xl-4">

        <div class="dashboard-card">

            <div class="dashboard-card-icon icon-blue">
                <i class="bi bi-book"></i>
            </div>

            <h5 class="fw-bold">
                Inventario de títulos
            </h5>

            <p class="text-muted">
                Consulta, registra y administra
                los libros disponibles en el sistema.
            </p>

            <a href="/views/titulos/index.php"
               class="btn btn-primary">

                Administrar títulos
                <i class="bi bi-arrow-right ms-1"></i>

            </a>

        </div>

    </div>

    <div class="col-12 col-md-6 col-xl-4">

        <div class="dashboard-card">

            <div class="dashboard-card-icon icon-green">
                <i class="bi bi-shop"></i>
            </div>

            <h5 class="fw-bold">
                Red de distribución
            </h5>

            <p class="text-muted">
                Gestiona las tiendas que forman
                parte de la red de distribución.
            </p>

            <a href="/views/tiendas/index.php"
               class="btn btn-success">

                Administrar tiendas
                <i class="bi bi-arrow-right ms-1"></i>

            </a>

        </div>

    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <h5 class="fw-bold mb-3">
            Acerca de Libreria Feliz
        </h5>

        <p class="text-muted mb-0">
            Libreria Feliz es un sistema diseñado para
            gestionar el inventario de libros y la red
            de distribución de tiendas. Desde este
            dashboard podrás acceder a las diferentes
            funciones del sistema.
        </p>

    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
