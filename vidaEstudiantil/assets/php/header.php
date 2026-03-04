<?php
$siteURL = '/cpanel/cpanel_Hithan-main/';
$portalURL = $siteURL . 'vidaEstudiantil/';
$titulo = isset($titulo) ? $titulo . ' — Vida Estudiantil UM' : 'Vida Estudiantil UM';
$paginaActiva = isset($paginaActiva) ? $paginaActiva : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo htmlspecialchars($titulo); ?></title>
    <link rel="icon" type="image/svg+xml" href="<?php echo $siteURL; ?>favicon.svg">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Nucleo Icons (local) -->
    <link rel="stylesheet" href="<?php echo $portalURL; ?>assets/css/nucleo-icons.css">
    <link rel="stylesheet" href="<?php echo $portalURL; ?>assets/css/nucleo-svg.css">
    <!-- Soft UI Design System PRO -->
    <link rel="stylesheet" href="<?php echo $portalURL; ?>assets/css/soft-design-system-pro.min.css">
    <!-- Portal custom overrides -->
    <link rel="stylesheet" href="<?php echo $portalURL; ?>assets/css/portal.css">
</head>
<body class="index-page">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-sticky py-2 start-0 end-0 my-0" id="navbarBlur" navbar-scroll="true">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $portalURL; ?>">
            <img src="<?php echo $siteURL; ?>favicon.svg" alt="UM" height="36" class="me-2">
            <span class="font-weight-bolder">Vida Estudiantil</span>
        </a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navPortal" aria-expanded="false">
            <span class="navbar-toggler-icon">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="navPortal">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link ps-2 <?php echo $paginaActiva === 'home' ? 'active font-weight-bold' : ''; ?>"
                       href="<?php echo $portalURL; ?>">
                        <i class="fas fa-home opacity-6 me-1"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ps-2 <?php echo $paginaActiva === 'clubes' ? 'active font-weight-bold' : ''; ?>"
                       href="<?php echo $portalURL; ?>clubes">
                        <i class="fas fa-users opacity-6 me-1"></i> Clubes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ps-2 <?php echo $paginaActiva === 'ministerios' ? 'active font-weight-bold' : ''; ?>"
                       href="<?php echo $portalURL; ?>ministerios">
                        <i class="fas fa-hands-praying opacity-6 me-1"></i> Ministerios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ps-2 <?php echo $paginaActiva === 'eventos' ? 'active font-weight-bold' : ''; ?>"
                       href="<?php echo $portalURL; ?>eventos">
                        <i class="fas fa-calendar-alt opacity-6 me-1"></i> Eventos
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
