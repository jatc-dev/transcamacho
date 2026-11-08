<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Transcamacho FUEC', ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background: #1a237e; margin-bottom: 20px; border-radius: 0; }
        .navbar-brand { font-weight: bold; font-size: 1.25rem; }
        .navbar-nav > li > a { color: #e8eaf6 !important; }
        .navbar-nav > li > a:hover { background: rgba(255,255,255,0.1); }
        .panel { border: none; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .panel-heading { background: #1a237e; color: #fff; border-radius: 6px 6px 0 0; }
        .btn-primary { background: #1a237e; border-color: #1a237e; }
        .btn-primary:hover { background: #283593; }
        .btn-success { background: #2e7d32; border-color: #2e7d32; }
        .btn-danger { background: #c62828; border-color: #c62828; }
        .alert-danger { background: #ffebee; border-color: #ef9a9a; color: #b71c1c; }
        .alert-success { background: #e8f5e9; border-color: #a5d6a7; color: #1b5e20; }
        table.table-bordered th { background: #1a237e; color: #fff; }
    </style>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><i class="fa fa-truck"></i> Transcamacho FUEC</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right">
                <?php if (!empty($_SESSION['id_usuario'])): ?>
                    <li><a href="/panel"><i class="fa fa-home"></i> Panel</a></li>
                    <li><a href="/contratos"><i class="fa fa-file-text"></i> Contratos</a></li>
                    <li><a href="/fuec"><i class="fa fa-file-pdf-o"></i> FUEC</a></li>
                    <li><a href="/logout"><i class="fa fa-sign-out"></i> Cerrar sesión</a></li>
                <?php else: ?>
                    <li><a href="/login"><i class="fa fa-sign-in"></i> Iniciar sesión</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?php if (!empty($flash)): ?>
        <div class="alert alert-<?= htmlspecialchars($flash['type'] ?? 'info', ENT_QUOTES, 'UTF-8') ?>">
            <?= htmlspecialchars($flash['message'] ?? '', ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?= $content ?>
</div>

<footer class="text-center text-muted mt-5 mb-3">
    <small>&copy; 2026 Transcamacho S.A.S. - Sistema de gestión de extractos de contrato</small>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
