<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Tienda.php';

$database = new Database();
$db = $database->getConnection();

$tiendaModel = new Tienda($db);

$tiendas = $tiendaModel->getAll();

require_once __DIR__ . '/../../includes/header.php';

?>

<div class="container-fluid">

    <div class="d-flex justify-content-between
                align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">Gestión de tiendas</h1>

            <p class="text-muted mb-0">
                Administra las tiendas de distribución.
            </p>
        </div>

        <a href="crear.php" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nueva tienda
        </a>
    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Listado de tiendas</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($tiendas)): ?>

                            <?php foreach ($tiendas as $tienda): ?>

                                <tr>
                                    <td>
                                        <?= (int) $tienda['id_tienda'] ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $tienda['nombre_tienda'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $tienda['direccion'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $tienda['telefono'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $tienda['correo'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </td>

                                    <td class="text-center">

                                        <a
                                            href="editar.php?id=<?= (int) $tienda['id_tienda'] ?>"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Editar
                                        </a>

                                        <a
                                            href="eliminar.php?id=<?= (int) $tienda['id_tienda'] ?>"
                                            class="btn btn-sm btn-danger"
                                        >
                                            Eliminar
                                        </a>

                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="6"
                                    class="text-center text-muted py-4">

                                    No hay tiendas registradas.

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