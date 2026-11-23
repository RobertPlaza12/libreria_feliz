<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Tienda.php';

$database = new Database();
$db = $database->getConnection();

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tiendaModel = new Tienda($db);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: index.php');
    exit;
}

$tienda = $tiendaModel->getById($id);

if (!$tienda) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        $resultado = $tiendaModel->delete($id);

        if ($resultado) {
            header('Location: index.php');
            exit;
        } else {
            $error = 'La base de datos no pudo eliminar la tienda.';
        }

    } catch (PDOException $e) {

        error_log('Error al eliminar tienda: ' . $e->getMessage());

        $error = 'Ocurrió un error al eliminar la tienda. Verifica las relaciones de la base de datos.';
    }
}

require_once __DIR__ . '/../../includes/header.php';

?>

<div class="container-fluid">

    <div class="mb-4">
        <h1 class="h3 mb-1">Eliminar tienda</h1>

        <p class="text-muted mb-0">
            Confirma la eliminación de la tienda.
        </p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">

        <div class="card-body text-center py-5">

            <i class="bi bi-exclamation-triangle text-danger"
               style="font-size: 3rem;"></i>

            <h4 class="mt-3">¿Estás seguro?</h4>

            <p class="text-muted">
                Vas a eliminar la siguiente tienda:
            </p>

            <h5>
                <?= htmlspecialchars(
                    $tienda['nombre_tienda'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </h5>

            <p class="text-muted">
                Dirección:
                <?= htmlspecialchars(
                    $tienda['direccion'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </p>

            <form method="POST">

                <a href="index.php" class="btn btn-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash me-1"></i>
                    Sí, eliminar
                </button>

            </form>

        </div>

    </div>

</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

