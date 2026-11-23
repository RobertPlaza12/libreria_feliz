
<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Titulo.php';

$database = new Database();
$db = $database->getConnection();

$tituloModel = new Titulo($db);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: index.php');
    exit;
}

$titulo = $tituloModel->getById($id);

if (!$titulo) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        $tituloModel->delete($id);

        header('Location: index.php');
        exit;

    } catch (PDOException $e) {
        $error = 'No se pudo eliminar el título. Comprueba si existen restricciones relacionadas.';
    }
}

require_once __DIR__ . '/../../includes/header.php';

?>

<div class="container-fluid">

    <div class="mb-4">
        <h1 class="h3 mb-1">Eliminar título</h1>
        <p class="text-muted mb-0">
            Confirma la eliminación del libro.
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
                Vas a eliminar el siguiente título del inventario:
            </p>

            <h5>
                <?= htmlspecialchars($titulo['titulo'], ENT_QUOTES, 'UTF-8') ?>
            </h5>

            <p class="text-muted">
                Autor:
                <?= htmlspecialchars($titulo['autor'], ENT_QUOTES, 'UTF-8') ?>
            </p>

            <form method="POST" class="mt-4">

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
