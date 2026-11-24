<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Tienda.php';

$database = new Database();
$db = $database->getConnection();

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tiendaModel = new Tienda($db);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $accion = $_POST['accion'] ?? '';
    $id_tienda = filter_input(INPUT_POST, 'id_tienda', FILTER_VALIDATE_INT);

    if (!$id_tienda) {
        $error = 'La tienda indicada no es válida.';
    } else {
        try {

            if ($accion === 'guardar_titulo') {

                $id_titulo = filter_input(
                    INPUT_POST,
                    'id_titulo',
                    FILTER_VALIDATE_INT
                );

                $cantidad = filter_input(
                    INPUT_POST,
                    'cantidad',
                    FILTER_VALIDATE_INT
                );

                if (!$id_titulo || $cantidad === false || $cantidad === null || $cantidad < 0) {
                    $error = 'Selecciona un título y escribe una cantidad igual o mayor que cero.';
                } else {
                    $tiendaModel->guardarTitulo(
                        $id_tienda,
                        $id_titulo,
                        $cantidad
                    );

                    header('Location: index.php?estado=guardado');
                    exit;
                }

            } elseif ($accion === 'quitar_titulo') {

                $id_titulo = filter_input(
                    INPUT_POST,
                    'id_titulo',
                    FILTER_VALIDATE_INT
                );

                if (!$id_titulo) {
                    $error = 'El título indicado no es válido.';
                } else {
                    $tiendaModel->quitarTitulo($id_tienda, $id_titulo);

                    header('Location: index.php?estado=quitado');
                    exit;
                }
            }

        } catch (PDOException $e) {
            error_log('Error en inventario de tienda: ' . $e->getMessage());
            $error = 'No se pudo completar la operación. Verifica la tienda, el título y la relación entre ambas tablas.';
        }
    }
}

$tiendas = $tiendaModel->getAll();
$titulosDisponibles = $tiendaModel->getTitulosDisponibles();

require_once __DIR__ . '/../../includes/header.php';

?>

<div class="container-fluid">

    <div class="d-flex justify-content-between
                align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">Gestión de tiendas</h1>

            <p class="text-muted mb-0">
                Administra las tiendas y los libros disponibles en cada una.
            </p>
        </div>

        <a href="crear.php" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nueva tienda
        </a>

    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if (($_GET['estado'] ?? '') === 'guardado'): ?>
        <div class="alert alert-success">
            El inventario de la tienda se actualizó correctamente.
        </div>
    <?php elseif (($_GET['estado'] ?? '') === 'quitado'): ?>
        <div class="alert alert-success">
            El título se quitó del inventario de la tienda.
        </div>
    <?php endif; ?>

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

                                <?php
                                $idActual = (int) $tienda['id_tienda'];
                                $titulosTienda = $tiendaModel->getTitulos($idActual);
                                $collapseId = 'inventario-tienda-' . $idActual;
                                ?>

                                <tr>

                                    <td><?= $idActual ?></td>

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

                                        <button
                                            class="btn btn-sm btn-outline-primary"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#<?= $collapseId ?>"
                                            aria-expanded="false"
                                            aria-controls="<?= $collapseId ?>"
                                        >
                                            <i class="bi bi-book me-1"></i>
                                            Ver libros
                                        </button>

                                        <a
                                            href="editar.php?id=<?= $idActual ?>"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Editar
                                        </a>

                                        <a
                                            href="eliminar.php?id=<?= $idActual ?>"
                                            class="btn btn-sm btn-danger"
                                        >
                                            Eliminar
                                        </a>

                                    </td>

                                </tr>

                                <tr>
                                    <td colspan="6" class="p-0 border-0">

                                        <div
                                            class="collapse"
                                            id="<?= $collapseId ?>"
                                        >

                                            <div class="bg-light p-3">

                                                <div class="d-flex justify-content-between
                                                            align-items-center mb-3">

                                                    <h6 class="mb-0">
                                                        Libros de
                                                        <?= htmlspecialchars(
                                                            $tienda['nombre_tienda'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ) ?>
                                                    </h6>

                                                    <span class="badge bg-secondary">
                                                        <?= count($titulosTienda) ?> título(s)
                                                    </span>

                                                </div>

                                                <?php if (!empty($titulosTienda)): ?>

                                                    <div class="table-responsive mb-3">

                                                        <table class="table table-sm table-bordered
                                                                      bg-white align-middle mb-0">

                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Título</th>
                                                                    <th>Autor</th>
                                                                    <th style="width: 140px;">Cantidad</th>
                                                                    <th style="width: 120px;">Acción</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>

                                                                <?php foreach ($titulosTienda as $libro): ?>

                                                                    <tr>

                                                                        <td>
                                                                            <?= htmlspecialchars(
                                                                                $libro['titulo'],
                                                                                ENT_QUOTES,
                                                                                'UTF-8'
                                                                            ) ?>
                                                                        </td>

                                                                        <td>
                                                                            <?= htmlspecialchars(
                                                                                $libro['autor'],
                                                                                ENT_QUOTES,
                                                                                'UTF-8'
                                                                            ) ?>
                                                                        </td>

                                                                        <td>
                                                                            <form
                                                                                method="POST"
                                                                                class="d-flex gap-2"
                                                                            >

                                                                                <input
                                                                                    type="hidden"
                                                                                    name="accion"
                                                                                    value="guardar_titulo"
                                                                                >

                                                                                <input
                                                                                    type="hidden"
                                                                                    name="id_tienda"
                                                                                    value="<?= $idActual ?>"
                                                                                >

                                                                                <input
                                                                                    type="hidden"
                                                                                    name="id_titulo"
                                                                                    value="<?= (int) $libro['id_titulo'] ?>"
                                                                                >

                                                                                <input
                                                                                    type="number"
                                                                                    name="cantidad"
                                                                                    class="form-control form-control-sm"
                                                                                    min="0"
                                                                                    step="1"
                                                                                    value="<?= (int) $libro['cantidad'] ?>"
                                                                                    required
                                                                                >

                                                                                <button
                                                                                    type="submit"
                                                                                    class="btn btn-sm btn-primary"
                                                                                    title="Actualizar cantidad"
                                                                                >
                                                                                    <i class="bi bi-check-lg"></i>
                                                                                </button>

                                                                            </form>
                                                                        </td>

                                                                        <td>
                                                                            <form
                                                                                method="POST"
                                                                                onsubmit="return confirm('¿Quitar este título del inventario de la tienda?');"
                                                                            >

                                                                                <input
                                                                                    type="hidden"
                                                                                    name="accion"
                                                                                    value="quitar_titulo"
                                                                                >

                                                                                <input
                                                                                    type="hidden"
                                                                                    name="id_tienda"
                                                                                    value="<?= $idActual ?>"
                                                                                >

                                                                                <input
                                                                                    type="hidden"
                                                                                    name="id_titulo"
                                                                                    value="<?= (int) $libro['id_titulo'] ?>"
                                                                                >

                                                                                <button
                                                                                    type="submit"
                                                                                    class="btn btn-sm btn-outline-danger"
                                                                                >
                                                                                    Quitar
                                                                                </button>

                                                                            </form>
                                                                        </td>

                                                                    </tr>

                                                                <?php endforeach; ?>

                                                            </tbody>

                                                        </table>

                                                    </div>

                                                <?php else: ?>

                                                    <p class="text-muted mb-3">
                                                        Esta tienda todavía no tiene libros asociados.
                                                    </p>

                                                <?php endif; ?>

                                                <form method="POST" class="row g-2 align-items-end">

                                                    <input
                                                        type="hidden"
                                                        name="accion"
                                                        value="guardar_titulo"
                                                    >

                                                    <input
                                                        type="hidden"
                                                        name="id_tienda"
                                                        value="<?= $idActual ?>"
                                                    >

                                                    <div class="col-md-7">

                                                        <label class="form-label">
                                                            Agregar título
                                                        </label>

                                                        <select
                                                            name="id_titulo"
                                                            class="form-select"
                                                            required
                                                        >
                                                            <option value="">
                                                                Selecciona un título
                                                            </option>

                                                            <?php foreach ($titulosDisponibles as $opcion): ?>

                                                                <option value="<?= (int) $opcion['id_titulo'] ?>">
                                                                    <?= htmlspecialchars(
                                                                        $opcion['titulo'] . ' — ' . $opcion['autor'],
                                                                        ENT_QUOTES,
                                                                        'UTF-8'
                                                                    ) ?>
                                                                </option>

                                                            <?php endforeach; ?>

                                                        </select>

                                                    </div>

                                                    <div class="col-md-3">

                                                        <label class="form-label">
                                                            Cantidad
                                                        </label>

                                                        <input
                                                            type="number"
                                                            name="cantidad"
                                                            class="form-control"
                                                            min="0"
                                                            step="1"
                                                            value="0"
                                                            required
                                                        >

                                                    </div>

                                                    <div class="col-md-2">

                                                        <button
                                                            type="submit"
                                                            class="btn btn-success w-100"
                                                        >
                                                            <i class="bi bi-plus-lg me-1"></i>
                                                            Agregar
                                                        </button>

                                                    </div>

                                                </form>

                                                <small class="text-muted d-block mt-2">
                                                    Si seleccionas un título que ya está asociado a esta tienda,
                                                    se actualizará su cantidad.
                                                </small>

                                            </div>

                                        </div>

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
