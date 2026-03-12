<?php
session_start();

$titulo = 'Anuario';
$paginaActiva = 'anuarios';
$siteURL = '/cpanel/cpanel_Hithan-main/';
$portalURL = $siteURL . 'vidaEstudiantil/';

include('../cpanel/assets/API/db.php');
$db = new Conexion();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) { header('Location: ' . $portalURL . 'anuarios'); exit(); }

$result = $db->query("SELECT * FROM VRE_ANUARIOS WHERE ID = $id AND ACTIVO = 'S'");
$anuario = $db->recorrer($result);
if (!$anuario) { header('Location: ' . $portalURL . 'anuarios'); exit(); }

// Incrementar vistas (una vez por sesión por anuario)
$sesKey = 'vista_anuario_' . $id;
if (empty($_SESSION[$sesKey])) {
    $_SESSION[$sesKey] = true;
    $db->query("UPDATE VRE_ANUARIOS SET VISTAS = VISTAS + 1 WHERE ID = $id");
    $anuario['VISTAS'] = ($anuario['VISTAS'] ?? 0) + 1;
}

$titulo = $anuario['TITULO'];
$fotografos     = !empty($anuario['FOTOGRAFOS'])    ? array_map('trim', explode(',', $anuario['FOTOGRAFOS']))    : [];
$contribuyentes = !empty($anuario['CONTRIBUYENTES']) ? array_map('trim', explode(',', $anuario['CONTRIBUYENTES'])) : [];

include('assets/php/header.php');
?>

<!-- ── Muro de autenticación Google ── -->
<div id="authWall" style="position:fixed;inset:0;z-index:99999;background:rgba(20,20,40,0.97);display:flex;align-items:center;justify-content:center;padding:1rem;">
    <div class="card shadow-lg border-0 text-center px-5 py-5" style="max-width:440px;width:100%;border-radius:1.5rem;">
        <div class="mb-4">
            <div style="width:72px;height:72px;background:linear-gradient(135deg,#344767,#5e72e4);border-radius:1rem;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                <i class="fas fa-book-open fa-2x text-white"></i>
            </div>
        </div>
        <h4 class="font-weight-bolder mb-2">Anuarios Institucionales</h4>
        <p class="text-secondary mb-4" style="font-size:.875rem;line-height:1.6;">
            Esta sección es exclusiva para la comunidad universitaria.<br>
            Inicia sesión con tu cuenta de Google para continuar.
        </p>
        <div id="googleBtnAnuarios" class="d-flex justify-content-center mb-3"></div>
        <button id="btnGSIFallback"
                style="display:none;border:1px solid #dadce0;border-radius:4px;background:#fff;padding:10px 24px;font-size:.9rem;cursor:pointer;align-items:center;gap:10px;justify-content:center;width:100%;max-width:300px;margin:0 auto;"
                onclick="if(typeof google!=='undefined' && google.accounts)google.accounts.id.prompt();">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="20" alt="Google">
            Iniciar sesión con Google
        </button>
        <p class="text-muted mt-3 mb-0" style="font-size:.78rem;">
            <i class="fas fa-shield-alt me-1 text-primary"></i>Acceso restringido — Universidad de Monterrey
        </p>
    </div>
</div>

<script>
(function() {
    var wall = document.getElementById('authWall');

    if (sessionStorage.getItem('google_credential')) {
        wall.style.display = 'none';
        return;
    }

    var _orig = window.handleGoogleSignIn;
    window.handleGoogleSignIn = function(response) {
        if (_orig) _orig(response);
        if (wall) wall.style.display = 'none';
    };

    function renderBtn() {
        if (typeof google !== 'undefined' && google.accounts && google.accounts.id) {
            google.accounts.id.initialize({
                client_id: '<?php echo GOOGLE_CLIENT_ID; ?>',
                callback: window.handleGoogleSignIn,
                cancel_on_tap_outside: false
            });
            var container = document.getElementById('googleBtnAnuarios');
            google.accounts.id.renderButton(container, {
                theme: 'outline', size: 'large', width: 300, text: 'signin_with'
            });
            setTimeout(function() {
                if (!container.querySelector('iframe')) {
                    document.getElementById('btnGSIFallback').style.display = 'flex';
                }
            }, 2000);
        } else {
            setTimeout(renderBtn, 200);
        }
    }
    renderBtn();
})();
</script>

<!-- ── Hero portada ── -->
<div class="position-relative" style="height:360px;overflow:hidden;background:#1a1a2e;">
    <?php if (!empty($anuario['IMAGEN_PORTADA'])): ?>
        <img src="<?php echo htmlspecialchars($anuario['IMAGEN_PORTADA']); ?>"
             alt="<?php echo htmlspecialchars($anuario['TITULO']); ?>"
             style="width:100%;height:100%;object-fit:cover;opacity:.45;">
    <?php endif; ?>
    <div class="position-absolute inset-0 d-flex align-items-end" style="inset:0;padding:2rem 0;">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                <span class="badge bg-gradient-primary px-3 py-2" style="font-size:1rem;font-weight:800;"><?php echo $anuario['ANIO']; ?></span>
                <?php if ($anuario['ES_CONMEMORATIVO'] === 'S'): ?>
                    <span class="badge bg-gradient-warning px-3 py-2"><i class="fas fa-star me-1"></i>Anuario Conmemorativo</span>
                <?php endif; ?>
                <?php if (!empty($anuario['DECADA'])): ?>
                    <span class="badge bg-white text-dark px-3 py-2" style="font-size:.8rem;">Década <?php echo $anuario['DECADA']; ?>s</span>
                <?php endif; ?>
            </div>
            <h1 class="text-white fw-bolder mb-0" style="font-size:2rem;text-shadow:0 2px 12px rgba(0,0,0,.5);">
                <?php echo htmlspecialchars($anuario['TITULO']); ?>
            </h1>
        </div>
    </div>
</div>

<main class="container py-5">
    <div class="row g-5">

        <!-- ── Columna principal ── -->
        <div class="col-lg-8">

            <!-- Stats strip -->
            <div class="card shadow-sm border-0 border-radius-xl mb-4">
                <div class="card-body py-3">
                    <div class="row text-center g-0">
                        <div class="col-4 border-end">
                            <div class="fw-bolder text-primary" style="font-size:1.5rem;" id="likes-display">
                                <?php echo number_format($anuario['LIKES']); ?>
                            </div>
                            <div class="text-secondary" style="font-size:.8rem;"><i class="fas fa-heart text-danger me-1"></i>Likes</div>
                        </div>
                        <div class="col-4 border-end">
                            <div class="fw-bolder" style="font-size:1.5rem;color:#344767;"><?php echo number_format($anuario['VISTAS']); ?></div>
                            <div class="text-secondary" style="font-size:.8rem;"><i class="fas fa-eye me-1"></i>Vistas</div>
                        </div>
                        <div class="col-4">
                            <div class="fw-bolder" style="font-size:1.5rem;color:#344767;"><?php echo $anuario['TOTAL_PAGINAS'] > 0 ? $anuario['TOTAL_PAGINAS'] : '—'; ?></div>
                            <div class="text-secondary" style="font-size:.8rem;"><i class="fas fa-file-alt me-1"></i>Páginas</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Descripción -->
            <?php if (!empty($anuario['DESCRIPCION'])): ?>
            <div class="mb-4">
                <h5 class="font-weight-bolder mb-3"><i class="fas fa-align-left me-2 text-primary"></i>Descripción</h5>
                <p class="text-secondary" style="line-height:1.8;white-space:pre-line;"><?php echo htmlspecialchars($anuario['DESCRIPCION']); ?></p>
            </div>
            <?php endif; ?>

            <!-- Razón conmemorativa -->
            <?php if ($anuario['ES_CONMEMORATIVO'] === 'S' && !empty($anuario['RAZON_CONMEMORATIVA'])): ?>
            <div class="card border-0 border-radius-xl mb-4" style="background:linear-gradient(135deg,#fff8e1,#fff3cd);">
                <div class="card-body">
                    <h6 class="font-weight-bolder mb-2"><i class="fas fa-star me-2 text-warning"></i>Razón Conmemorativa</h6>
                    <p class="mb-0 text-secondary"><?php echo htmlspecialchars($anuario['RAZON_CONMEMORATIVA']); ?></p>
                </div>
            </div>
            <?php endif; ?>

            <!-- Fotógrafos -->
            <?php if (!empty($fotografos)): ?>
            <div class="mb-4">
                <h5 class="font-weight-bolder mb-3"><i class="fas fa-camera me-2 text-primary"></i>Fotógrafos</h5>
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach ($fotografos as $f): ?>
                        <?php if ($f !== ''): ?>
                        <span class="badge bg-light text-dark px-3 py-2" style="font-size:.85rem;border:1px solid #e9ecef;border-radius:.75rem;">
                            <i class="fas fa-user-circle me-1 text-primary"></i><?php echo htmlspecialchars($f); ?>
                        </span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Contribuyentes -->
            <?php if (!empty($contribuyentes)): ?>
            <div class="mb-4">
                <h5 class="font-weight-bolder mb-3"><i class="fas fa-users me-2 text-primary"></i>Contribuyentes</h5>
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach ($contribuyentes as $c): ?>
                        <?php if ($c !== ''): ?>
                        <span class="badge bg-light text-dark px-3 py-2" style="font-size:.85rem;border:1px solid #e9ecef;border-radius:.75rem;">
                            <i class="fas fa-user me-1 text-secondary"></i><?php echo htmlspecialchars($c); ?>
                        </span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Visor PDF -->
            <?php if (!empty($anuario['PDF_URL'])): ?>
            <div class="mb-4">
                <h5 class="font-weight-bolder mb-3"><i class="fas fa-file-pdf me-2 text-danger"></i>Visor del Anuario</h5>
                <div class="border-0 border-radius-xl overflow-hidden shadow" style="height:600px;">
                    <iframe src="<?php echo htmlspecialchars($anuario['PDF_URL']); ?>"
                            width="100%" height="100%" style="border:none;display:block;" allowfullscreen></iframe>
                </div>
                <div class="mt-2 text-end">
                    <a href="<?php echo htmlspecialchars($anuario['PDF_URL']); ?>" target="_blank"
                       class="btn btn-sm btn-outline-danger border-radius-lg">
                        <i class="fas fa-external-link-alt me-1"></i>Abrir en nueva pestaña
                    </a>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <!-- ── Columna lateral ── -->
        <div class="col-lg-4">

            <!-- Portada -->
            <?php if (!empty($anuario['IMAGEN_PORTADA'])): ?>
            <div class="card shadow border-0 border-radius-xl overflow-hidden mb-4">
                <img src="<?php echo htmlspecialchars($anuario['IMAGEN_PORTADA']); ?>"
                     alt="Portada" class="w-100" style="max-height:320px;object-fit:cover;">
            </div>
            <?php endif; ?>

            <!-- Like card -->
            <div class="card shadow-sm border-0 border-radius-xl mb-4">
                <div class="card-body text-center py-4">
                    <p class="text-secondary mb-3" style="font-size:.875rem;">¿Te gustó este anuario?</p>
                    <button id="btnLike" class="btn btn-outline-danger btn-lg w-100" style="border-radius:.75rem;" data-id="<?php echo $anuario['ID']; ?>">
                        <i class="fas fa-heart me-2"></i>Dar Like
                        <span class="badge bg-danger ms-2" id="like-badge"><?php echo $anuario['LIKES']; ?></span>
                    </button>
                    <p class="text-muted mt-2 mb-0" style="font-size:.75rem;" id="like-msg"></p>
                </div>
            </div>

            <!-- Ficha técnica -->
            <div class="card shadow-sm border-0 border-radius-xl mb-4">
                <div class="card-body">
                    <h6 class="font-weight-bolder mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Ficha Técnica</h6>
                    <table class="table table-sm table-borderless mb-0" style="font-size:.875rem;">
                        <tbody>
                            <tr><th class="text-secondary ps-0" style="width:40%;">Año</th><td><?php echo $anuario['ANIO']; ?></td></tr>
                            <?php if (!empty($anuario['DECADA'])): ?>
                            <tr><th class="text-secondary ps-0">Década</th><td><?php echo $anuario['DECADA']; ?>s</td></tr>
                            <?php endif; ?>
                            <?php if ($anuario['TOTAL_PAGINAS'] > 0): ?>
                            <tr><th class="text-secondary ps-0">Páginas</th><td><?php echo $anuario['TOTAL_PAGINAS']; ?></td></tr>
                            <?php endif; ?>
                            <tr><th class="text-secondary ps-0">Likes</th><td id="likes-sidebar"><?php echo number_format($anuario['LIKES']); ?></td></tr>
                            <tr><th class="text-secondary ps-0">Vistas</th><td><?php echo number_format($anuario['VISTAS']); ?></td></tr>
                            <tr><th class="text-secondary ps-0">Conmem.</th><td><?php echo $anuario['ES_CONMEMORATIVO'] === 'S' ? '<span class="badge bg-warning text-dark">Sí</span>' : 'No'; ?></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Volver -->
            <a href="<?php echo $portalURL; ?>anuarios" class="btn btn-outline-primary w-100" style="border-radius:.75rem;">
                <i class="fas fa-arrow-left me-2"></i>Ver todos los anuarios
            </a>

        </div>
    </div>
</main>

<script>
document.getElementById('btnLike')?.addEventListener('click', function() {
    const id  = this.dataset.id;
    const btn = this;
    const msg = document.getElementById('like-msg');
    window.likeConGoogle(id, btn, document.getElementById('likes-display'));
    // También actualizar el badge y sidebar al completar
    const origLike = window.likeConGoogle;
});
// Mensaje cuando Google aún no está listo
document.getElementById('btnLike')?.addEventListener('click', function() {
    if (!sessionStorage.getItem('google_credential') && typeof google === 'undefined') {
        const msg = document.getElementById('like-msg');
        if (msg) { msg.textContent = 'Inicia sesión con Google para dar like.'; msg.style.display = ''; }
    }
}, {once: false});
</script>

<?php include('assets/php/footer.php'); ?>
