
<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Titulo.php';

$database = new Database();
$db = $database->getConnection();

$tituloModel = new Titulo($db);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (
        !empty(trim($_POST['titulo'] ?? '')) &&
        !empty(trim($_POST['autor'] ?? '')) &&
        isset($_POST['precio']) &&
        is_numeric($_POST['precio']) &&
        (float) $_POST['precio'] >= 0
    ) {
        try {
            $tituloModel->create($_POST);

            header('Location: index.php');
            exit;

        } catch (PDOException $e) {
            $error = 'No se pudo registrar el título. Verifica que el ISBN no esté repetido.';
        }

    } else {
        $error = 'Completa el título, autor y un precio válido.';
    }
}

require_once __DIR__ . '/../../includes/header.php';

?>

<div class="container-fluid">

    <div class="mb-4">
        <h1 class="h3 mb-1">Nuevo título</h1>
        <p class="text-muted mb-0">
            Registra un nuevo libro en el inventario.
        </p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Información del libro</h5>
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Título *</label>
                        <input
                            type="text"
                            name="titulo"
                            class="form-control"
                            maxlength="200"
                            value="<?= htmlspecialchars($_POST['titulo'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Autor *</label>
                        <input
                            type="text"
                            name="autor"
                            class="form-control"
                            maxlength="150"
                            value="<?= htmlspecialchars($_POST['autor'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">ISBN</label>
                        <input
                            type="text"
                            name="isbn"
                            class="form-control"
                            maxlength="20"
                            value="<?= htmlspecialchars($_POST['isbn'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Editorial</label>
                        <input
                            type="text"
                            name="editorial"
                            class="form-control"
                            maxlength="150"
                            value="<?= htmlspecialchars($_POST['editorial'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Año de publicación</label>
                        <input
                            type="number"
                            name="anio_publicacion"
                            class="form-control"
                            min="1"
                            max="9999"
                            value="<?= htmlspecialchars($_POST['anio_publicacion'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Precio (RD$) *</label>
                        <input
                            type="number"
                            name="precio"
                            class="form-control"
                            min="0"
                            step="0.01"
                            value="<?= htmlspecialchars($_POST['precio'] ?? '0.00', ENT_QUOTES, 'UTF-8') ?>"
                            required
                        >
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea
                            name="descripcion"
                            class="form-control"
                            rows="4"
                        ><?= htmlspecialchars($_POST['descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2">

                    <a href="index.php" class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar título
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
