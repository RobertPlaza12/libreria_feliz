
<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Tienda.php';

$database = new Database();
$db = $database->getConnection();

$tiendaModel = new Tienda($db);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header("Location: index.php");
    exit;
}

$tienda = $tiendaModel->getById($id);

if (!$tienda) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre_tienda'] ?? '');

    if ($nombre === '') {

        $error = 'El nombre de la tienda es obligatorio.';

    } else {

        try {
            $tiendaModel->update($id, $_POST);

            header("Location: index.php");
            exit;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            $error = 'No fue posible actualizar la tienda.';
        }
    }

    $tienda = array_merge($tienda, $_POST);
}

require_once __DIR__ . '/../../includes/header.php';

?>

<div class="container-fluid">

    <div class="mb-4">
        <h1 class="h3">Editar tienda</h1>
        <p class="text-muted">
            Modifica los datos de la tienda seleccionada.
        </p>
    </div>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form method="POST"
                  action="editar.php?id=<?= (int) $id ?>">

                <div class="mb-3">
                    <label for="nombre_tienda"
                           class="form-label">
                        Nombre de la tienda
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="nombre_tienda"
                        name="nombre_tienda"
                        maxlength="150"
                        required
                        value="<?= htmlspecialchars(
                            $tienda['nombre_tienda'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >
                </div>

                <div class="mb-3">
                    <label for="direccion"
                           class="form-label">
                        Dirección
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="direccion"
                        name="direccion"
                        maxlength="255"
                        value="<?= htmlspecialchars(
                            $tienda['direccion'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >
                </div>

                <div class="mb-3">
                    <label for="telefono"
                           class="form-label">
                        Teléfono
                    </label>

                    <input
                        type="tel"
                        class="form-control"
                        id="telefono"
                        name="telefono"
                        maxlength="20"
                        value="<?= htmlspecialchars(
                            $tienda['telefono'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >
                </div>

                <div class="mb-3">
                    <label for="correo"
                           class="form-label">
                        Correo electrónico
                    </label>

                    <input
                        type="email"
                        class="form-control"
                        id="correo"
                        name="correo"
                        maxlength="150"
                        value="<?= htmlspecialchars(
                            $tienda['correo'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >
                </div>

                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">
                        Guardar cambios
                    </button>

                    <a href="index.php"
                       class="btn btn-secondary">
                        Cancelar
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
