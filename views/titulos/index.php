
<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Titulo.php';

$database = new Database();
$db = $database->getConnection();

$tituloModel = new Titulo($db);

$titulos = $tituloModel->getAll();

require_once __DIR__ . '/../../includes/header.php';

?>

<div class="container-fluid">

    <div class="d-flex justify-content-between
                align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">Gestión de títulos</h1>

            <p class="text-muted mb-0">
                Administra los libros del inventario.
            </p>
        </div>

        <a href="crear.php" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nuevo título
        </a>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Listado de títulos</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>ISBN</th>
                            <th>Editorial</th>
                            <th>Precio</th>
                            <th>Tiendas</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($titulos)): ?>

                            <?php foreach ($titulos as $titulo): ?>

                                <tr>

                                    <td>
                                        <?= (int) $titulo['id_titulo'] ?>
                                    </td>

                                    <td>
                                        <strong>
                                            <?= htmlspecialchars(
                                                $titulo['titulo'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $titulo['autor'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $titulo['isbn'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $titulo['editorial'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td>
                                        RD$ <?= number_format(
                                            (float) $titulo['precio'],
                                            2
                                        ) ?>
                                    </td>

                                    <td>
                                        <span class="badge bg-info text-dark">
                                            <?= (int) $titulo['total_tiendas'] ?>
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <a
                                            href="editar.php?id=<?= (int) $titulo['id_titulo'] ?>"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Editar
                                        </a>

                                        <a
                                            href="eliminar.php?id=<?= (int) $titulo['id_titulo'] ?>"
                                            class="btn btn-sm btn-danger"
                                        >
                                            Eliminar
                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="8"
                                    class="text-center text-muted py-4">

                                    No hay títulos registrados.

                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
