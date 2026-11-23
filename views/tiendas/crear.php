
<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Tienda.php';

$database = new Database();
$db = $database->getConnection();

$tiendaModel = new Tienda($db);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre_tienda'] ?? '');

    if ($nombre === '') {

        $error = 'El nombre de la tienda es obligatorio.';

    } else {

        try {
            $tiendaModel->create($_POST);

            header("Location: index.php");
            exit;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            $error = 'No fue posible registrar la tienda.';
        }
    }
}

require_once __DIR__ . '/../../includes/header.php';

?>

<div class="container-fluid">

    <div class="mb-4">
        <h1 class="h3">Registrar tienda</h1>
        <p class="text-muted">
            Introduce los datos de la nueva tienda.
        </p>
    </div>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form method="POST" action="crear.php">

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
                            $_POST['nombre_tienda'] ?? '',
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
                            $_POST['direccion'] ?? '',
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
                            $_POST['telefono'] ?? '',
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
                            $_POST['correo'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >
                </div>

                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">
                        Guardar tienda
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
