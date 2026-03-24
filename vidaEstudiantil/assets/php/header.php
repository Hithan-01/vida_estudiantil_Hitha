<?php
// ── Usar configuración global si no está definida ──
if (!defined('PORTAL_URL')) {
    require_once(__DIR__ . '/../../../config.php');
}
if (!isset($siteURL)) {
    $siteURL = SITE_URL;
}
if (!isset($portalURL)) {
    $portalURL = PORTAL_URL;
}
if (!isset($cpanelURL)) {
    $cpanelURL = CPANEL_URL;
}

// Google Sign-In Client ID — regístralo en Google Cloud Console
define('GOOGLE_CLIENT_ID', '875058597883-dkfj1de8anmrhq44pup5mimv0lg7ag5n.apps.googleusercontent.com');

$titulo = isset($titulo) ? $titulo . ' — Vida Estudiantil UM' : 'Vida Estudiantil UM';
$paginaActiva = isset($paginaActiva) ? $paginaActiva : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo htmlspecialchars($titulo); ?></title>
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
    <link rel="stylesheet" href="<?php echo $portalURL; ?>assets/css/portal.css?v=<?php echo time(); ?>">
    <style>
    /* Aumentar z-index del navbar para que esté sobre todo */
    .navbar.position-sticky {
        z-index: 9999 !important;
    }

    /* Dropdown con fondo sólido blanco y z-index alto */
    .navbar .dropdown-menu {
        background: #fff !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 8px 24px rgba(0,0,0,.12) !important;
        border-radius: .75rem !important;
        backdrop-filter: none !important;
        z-index: 10000 !important;
    }
    .navbar .dropdown-item { color: #1e293b !important; font-size: .875rem; }
    .navbar .dropdown-item:hover,
    .navbar .dropdown-item:focus { background: #f1f5f9 !important; color: #6366f1 !important; }
    .navbar .dropdown-item.active { background: #f1f5f9 !important; color: #6366f1 !important; font-weight: 600; }
    </style>
    <!-- Google Identity Services -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>
<body class="index-page">

<!-- Google Sign-In invisible trigger -->
<div id="g_id_onload"
     data-client_id="<?php echo GOOGLE_CLIENT_ID; ?>"
     data-callback="handleGoogleSignIn"
     data-auto_prompt="false"
     data-ux_mode="popup">
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-sticky py-2 start-0 end-0 my-0" id="navbarBlur" navbar-scroll="true">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $portalURL; ?>">
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle ps-2 <?php echo in_array($paginaActiva, ['clubes', 'ministerios']) ? 'active font-weight-bold' : ''; ?>"
                       href="#" id="navComunidad" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-users opacity-6 me-1"></i> Comunidad
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navComunidad">
                        <li>
                            <a class="dropdown-item <?php echo $paginaActiva === 'clubes' ? 'active' : ''; ?>"
                               href="<?php echo $portalURL; ?>clubes">
                                <i class="fas fa-users me-2"></i> Clubes
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?php echo $paginaActiva === 'ministerios' ? 'active' : ''; ?>"
                               href="<?php echo $portalURL; ?>ministerios">
                                <i class="fas fa-hands-praying me-2"></i> Ministerios
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link ps-2 <?php echo $paginaActiva === 'instalaciones' ? 'active font-weight-bold' : ''; ?>"
                       href="<?php echo $portalURL; ?>instalaciones">
                        <i class="fas fa-building opacity-6 me-1"></i> Instalaciones
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link ps-2 <?php echo $paginaActiva === 'deportes' ? 'active font-weight-bold' : ''; ?>"
                       href="<?php echo $portalURL; ?>deportes">
                        <i class="fas fa-running opacity-6 me-1"></i> Deportes
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle ps-2 <?php echo in_array($paginaActiva, ['anuarios', 'entrega-anuarios']) ? 'active font-weight-bold' : ''; ?>"
                       href="#" id="navAnuarios" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-book opacity-6 me-1"></i> Anuarios
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navAnuarios"
                        style="background:#fff;border:1px solid #e2e8f0;box-shadow:0 8px 24px rgba(0,0,0,.12);border-radius:.75rem;min-width:200px;">
                        <li>
                            <a class="dropdown-item <?php echo $paginaActiva === 'anuarios' ? 'active' : ''; ?>"
                               href="<?php echo $portalURL; ?>anuarios"
                               style="color:#1e293b;font-size:.875rem;padding:.55rem 1rem;">
                                <i class="fas fa-book-open me-2" style="color:#6366f1;"></i> Ver los anuarios
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?php echo $paginaActiva === 'entrega-anuarios' ? 'active' : ''; ?>"
                               href="<?php echo $portalURL; ?>entrega-anuarios"
                               style="color:#1e293b;font-size:.875rem;padding:.55rem 1rem;">
                                <i class="fas fa-gift me-2" style="color:#6366f1;"></i> Entrega del anuario
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
// ── Google Sign-In: callback global ──
function handleGoogleSignIn(response) {
    try {
        const payload = JSON.parse(atob(response.credential.split('.')[1]));
        const email = payload.email || '';
        const allowed = email.endsWith('@alumno.um.edu.mx') || email.endsWith('@empleado.um.edu.mx');
        if (!allowed) {
            alert('Acceso denegado. Solo se permiten correos @alumno.um.edu.mx o @empleado.um.edu.mx.\n\nCorreo ingresado: ' + email);
            if (typeof google !== 'undefined' && google.accounts) google.accounts.id.disableAutoSelect();
            return;
        }
        sessionStorage.setItem('google_credential', response.credential);
        sessionStorage.setItem('google_name',  payload.name  || email);
        sessionStorage.setItem('google_email', email);
    } catch(e) {
        return;
    }
    if (window._pendingLike) {
        const fn = window._pendingLike;
        window._pendingLike = null;
        fn();
    }
}

// ── Dar like con autenticación Google ──
window.likeConGoogle = function(id, btnEl, counterEl) {
    function doSubmit() {
        const cred = sessionStorage.getItem('google_credential');
        if (!cred) return;
        if (btnEl) { btnEl.disabled = true; btnEl.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>…'; }
        fetch('<?php echo $siteURL; ?>assets/API/anuarios/like-publico.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id=' + id + '&credential=' + encodeURIComponent(cred)
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                if (counterEl) counterEl.textContent = data.likes;
                if (btnEl) {
                    btnEl.classList.remove('btn-outline-danger');
                    btnEl.classList.add('btn-danger');
                    btnEl.innerHTML = '<i class="fas fa-heart me-1"></i>' + data.likes;
                    btnEl.disabled = true;
                    btnEl.title = '¡Gracias, ' + (sessionStorage.getItem('google_name') || '') + '!';
                }
            } else if (data.ya_dio_like) {
                if (btnEl) {
                    btnEl.classList.remove('btn-outline-danger');
                    btnEl.classList.add('btn-danger');
                    btnEl.innerHTML = '<i class="fas fa-heart me-1"></i>' + (data.likes ?? '');
                    btnEl.disabled = true;
                    btnEl.title = 'Ya diste like';
                }
            } else if (data.token_invalido) {
                sessionStorage.removeItem('google_credential');
                window._pendingLike = doSubmit;
                if (typeof google !== 'undefined') google.accounts.id.prompt();
                if (btnEl) btnEl.disabled = false;
            } else {
                if (btnEl) { btnEl.disabled = false; btnEl.innerHTML = '<i class="fas fa-heart me-1"></i>Like'; }
            }
        })
        .catch(() => { if (btnEl) { btnEl.disabled = false; btnEl.innerHTML = '<i class="fas fa-heart me-1"></i>Like'; } });
    }

    const cred = sessionStorage.getItem('google_credential');
    if (!cred) {
        window._pendingLike = doSubmit;
        if (typeof google !== 'undefined' && google.accounts) {
            google.accounts.id.prompt();
        } else {
            const msg = document.getElementById('google-signin-msg');
            if (msg) { msg.style.display = ''; setTimeout(() => msg.style.display = 'none', 3000); }
        }
    } else {
        doSubmit();
    }
};
</script>