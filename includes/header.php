
<?php
$pageTitle = $pageTitle ?? 'Libreria Feliz';

$currentPage = $currentPage ?? 'dashboard';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle) ?> | Libreria Feliz</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body>

<div class="dashboard">

    <aside class="sidebar">

        <a href="/index.php" class="sidebar-brand">
            <i class="bi bi-book-half"></i>
            <span>Libreria Feliz</span>
        </a>

        <div class="sidebar-section">
            <small>MENÚ PRINCIPAL</small>
        </div>

        <nav class="sidebar-nav">

            <a
                href="/index.php"
                class="sidebar-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>"
            >
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>

            <a
                href="/views/titulos/index.php"
                class="sidebar-link <?= $currentPage === 'titulos' ? 'active' : '' ?>"
            >
                <i class="bi bi-book"></i>
                <span>Títulos</span>
            </a>

            <a
                href="/views/tiendas/index.php"
                class="sidebar-link <?= $currentPage === 'tiendas' ? 'active' : '' ?>"
            >
                <i class="bi bi-shop"></i>
                <span>Tiendas</span>
            </a>

        </nav>

        <div class="sidebar-footer">
            <small>Libreria Feliz v1.5</small>
        </div>

    </aside>

    <div class="main-wrapper">

        <header class="topbar">

            <div>
                <h6 class="mb-0">Sistema de gestión</h6>
                <small class="text-muted">
                    Inventario y distribución de libros
                </small>
            </div>

            <div class="topbar-icon">
                <i class="bi bi-person-circle"></i>
            </div>

        </header>

        <main class="main-content">
