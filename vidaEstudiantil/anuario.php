<?php
session_start();

$titulo = 'Anuario';
$paginaActiva = 'anuarios';

// Cargar configuración global
require_once('../config.php');

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

// Obtener URL del PDF (ya viene correcta de la BD)
$pdfUrl = $anuario['PDF_URL'] ?? '';

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
            <i class="fas fa-shield-alt me-1 text-primary"></i>Acceso restringido — Universidad de Montemorelos
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

<!-- ── TOPBAR ── -->
<style>
.anu-back-btn {
    display:inline-flex; align-items:center; gap:.4rem;
    color:#64748b; text-decoration:none; font-size:.82rem;
    background:#f8fafc; border:1px solid #e2e8f0;
    padding:.38rem .85rem; border-radius:2rem;
    transition:all .2s;
}
.anu-back-btn:hover { background:#f1f5f9; color:#1e293b; border-color:#cbd5e1; }
.anu-year-badge {
    display:inline-block;
    background:linear-gradient(135deg,#6366f1,#8b5cf6);
    color:#fff; font-size:.85rem; font-weight:800;
    padding:.3rem .9rem; border-radius:2rem;
    box-shadow:0 4px 20px rgba(99,102,241,.35);
    letter-spacing:.04em;
}
.anu-badge-comm {
    display:inline-flex; align-items:center; gap:.35rem;
    background:linear-gradient(135deg,#d97706,#f59e0b);
    color:#fff; font-size:.78rem; font-weight:700;
    padding:.3rem .85rem; border-radius:2rem;
    box-shadow:0 4px 16px rgba(217,119,6,.3);
}
.anu-badge-decade {
    display:inline-flex; align-items:center;
    background:#f1f5f9; color:#64748b;
    font-size:.78rem; padding:.3rem .85rem;
    border-radius:2rem; border:1px solid #e2e8f0;
}
/* Stats chips floating below hero */
.anu-stats-bar {
    background:#fff;
    padding:.2rem 2rem 2rem;
    border-bottom: 1px solid #e2e8f0;
}
.anu-stat-chip {
    display:inline-flex; align-items:center; gap:.6rem;
    background:#f8fafc;
    border:1px solid #e2e8f0;
    border-radius:1rem; padding:.6rem 1.2rem;
    color:#1e293b; font-size:.88rem;
    transition:background .2s, transform .2s, box-shadow .2s;
}
.anu-stat-chip:hover { background:#f1f5f9; transform:translateY(-2px); box-shadow:0 4px 12px rgba(0,0,0,.08); }
.anu-stat-chip strong { font-size:1.15rem; font-weight:800; }
.anu-stat-chip .chip-icon {
    width:32px; height:32px; border-radius:.6rem;
    display:flex; align-items:center; justify-content:center;
    font-size:.85rem;
}
</style>

<!-- Topbar: back + título + badges -->
<div style="background:#fff;border-bottom:1px solid #e2e8f0;padding:1rem 2rem;">
    <div class="d-flex flex-wrap align-items-center gap-3">
        <a href="<?php echo $portalURL; ?>anuarios" class="anu-back-btn">
            <i class="fas fa-arrow-left" style="font-size:.75rem;"></i> Volver a anuarios
        </a>
        <span class="anu-year-badge"><?php echo $anuario['ANIO']; ?></span>
        <?php if ($anuario['ES_CONMEMORATIVO'] === 'S'): ?>
            <span class="anu-badge-comm"><i class="fas fa-star" style="font-size:.75rem;"></i> Conmemorativo</span>
        <?php endif; ?>
        <?php if (!empty($anuario['DECADA'])): ?>
            <span class="anu-badge-decade">Década <?php echo $anuario['DECADA']; ?>s</span>
        <?php endif; ?>
        <h1 style="font-size:1.25rem;font-weight:700;color:#0f172a;margin:0;"><?php echo htmlspecialchars($anuario['TITULO']); ?></h1>
    </div>
</div>

<!-- Stats -->
<div class="anu-stats-bar">
    <div class="d-flex flex-wrap gap-2">
        <div class="anu-stat-chip">
            <div class="chip-icon" style="background:rgba(239,68,68,.15);color:#f87171;"><i class="fas fa-heart"></i></div>
            <div><strong id="likes-display"><?php echo number_format($anuario['LIKES']); ?></strong><br><span style="font-size:.72rem;color:#94a3b8;">Likes</span></div>
        </div>
        <div class="anu-stat-chip">
            <div class="chip-icon" style="background:rgba(59,130,246,.15);color:#60a5fa;"><i class="fas fa-eye"></i></div>
            <div><strong><?php echo number_format($anuario['VISTAS']); ?></strong><br><span style="font-size:.72rem;color:#94a3b8;">Vistas</span></div>
        </div>
        <?php if ($anuario['TOTAL_PAGINAS'] > 0): ?>
        <div class="anu-stat-chip">
            <div class="chip-icon" style="background:rgba(168,85,247,.15);color:#c084fc;"><i class="fas fa-book"></i></div>
            <div><strong><?php echo $anuario['TOTAL_PAGINAS']; ?></strong><br><span style="font-size:.72rem;color:#94a3b8;">Páginas</span></div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ── Visor flipbook (PRIMERO, ancho completo) ── -->
<?php if (!empty($pdfUrl)):
    $isFlipIframe = strpos($pdfUrl,'fliphtml5.com')!==false; // solo FlipHTML5 usa iframe
?>
<div style="background:#f8fafc;padding:1.5rem 0 2rem;border-bottom:1px solid #e2e8f0;">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 style="color:#1e293b;" class="mb-0"><i class="fas fa-book-open me-2" style="color:#6366f1;"></i>Visor del Anuario</h5>
            <a href="<?php echo htmlspecialchars($pdfUrl); ?>" target="_blank"
               class="btn btn-sm btn-outline-secondary" style="border-radius:.5rem;">
                <i class="fas fa-external-link-alt me-1"></i>Abrir en nueva pestaña
            </a>
        </div>

        <?php if ($isFlipIframe): ?>
        <!-- FlipHTML5: ya es un flipbook interactivo, se muestra en iframe -->
        <div style="border-radius:1rem;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.6);">
            <iframe src="<?php echo htmlspecialchars($pdfUrl); ?>"
                    width="100%" height="700" style="border:none;display:block;" allowfullscreen></iframe>
        </div>

        <?php else: ?>
        <?php
            // Google Drive: convertir a URL del proxy para evitar CORS
            $isDrive2 = strpos($pdfUrl,'drive.google.com')!==false;
            $flipPdfUrl = $isDrive2
                ? $portalURL . 'assets/php/pdf-proxy.php?url=' . urlencode($pdfUrl)
                : $pdfUrl;
        ?>
        <!-- ── FLIP BOOK ── -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
        <style>
            @keyframes bkSpin  { to { transform: rotate(360deg); } }
            @keyframes bkShad  { 0%{opacity:0} 35%{opacity:.45} 65%{opacity:.45} 100%{opacity:0} }

            #bkVisor { position:relative; user-select:none; }

            #bkScene {
                display:flex; justify-content:center; align-items:center;
                width:100%; overflow:hidden;
            }

            #bkBook {
                position:relative; display:flex; flex-shrink:0;
                box-shadow: 0 30px 80px rgba(0,0,0,.7), 0 8px 24px rgba(0,0,0,.5);
                perspective: 3000px;
            }
            .bk-page {
                position:relative; overflow:hidden;
                background:#fff; flex-shrink:0;
            }
            .bk-page canvas { display:block; position:absolute; top:0; left:0; width:100%; height:100%; }
            #bkLeft  { border-right:2px solid rgba(0,0,0,.2); box-shadow:inset -18px 0 50px -18px rgba(0,0,0,.2); }
            #bkRight { box-shadow:inset  18px 0 50px -18px rgba(0,0,0,.2); }

            /* Flip card */
            .bk-card {
                position:absolute; top:0;
                transform-style:preserve-3d;
                z-index:10; pointer-events:none;
            }
            .bk-fwd { right:0; transform-origin:left center;  transition:transform .7s cubic-bezier(.645,.045,.355,1); }
            .bk-bwd { left:0;  transform-origin:right center; transition:transform .7s cubic-bezier(.645,.045,.355,1); }
            .bk-fwd.go { transform:rotateY(-180deg); }
            .bk-bwd.go { transform:rotateY( 180deg); }

            .bk-face {
                position:absolute; inset:0;
                backface-visibility:hidden; -webkit-backface-visibility:hidden;
                overflow:hidden; background:#fff;
            }
            .bk-face canvas { display:block; width:100%; height:100%; }
            .bk-back { transform:rotateY(180deg); }

            .bk-fwd .bk-front::after { content:''; position:absolute; inset:0; background:linear-gradient(to left,  rgba(0,0,0,.18),transparent 35%); pointer-events:none; }
            .bk-fwd .bk-back::after  { content:''; position:absolute; inset:0; background:linear-gradient(to right, rgba(0,0,0,.12),transparent 35%); pointer-events:none; }
            .bk-bwd .bk-front::after { content:''; position:absolute; inset:0; background:linear-gradient(to right, rgba(0,0,0,.18),transparent 35%); pointer-events:none; }
            .bk-bwd .bk-back::after  { content:''; position:absolute; inset:0; background:linear-gradient(to left,  rgba(0,0,0,.12),transparent 35%); pointer-events:none; }

            .bk-shadow { position:absolute; top:0; pointer-events:none; z-index:9; animation:bkShad .75s ease forwards; }
            .bk-sh-l   { left:0;  background:linear-gradient(to right,rgba(0,0,0,.35),transparent); }
            .bk-sh-r   { right:0; background:linear-gradient(to left, rgba(0,0,0,.35),transparent); }

            /* Loading */
            #bkLoading {
                position:absolute; inset:0; display:flex; flex-direction:column;
                align-items:center; justify-content:center;
                background:#f8fafc; color:#1e293b; z-index:30; gap:1rem; border-radius:.75rem;
            }
            .bk-spinner {
                width:46px; height:46px;
                border:4px solid #e2e8f0; border-top-color:#6366f1;
                border-radius:50%; animation:bkSpin .9s linear infinite;
            }

            /* Nav arrows */
            .bk-arrow {
                position:absolute; top:50%; transform:translateY(-50%);
                background:#fff; border:1px solid #e2e8f0;
                color:#475569; width:40px; height:64px; border-radius:8px;
                cursor:pointer; display:flex; align-items:center; justify-content:center;
                font-size:1.4rem; transition:background .2s, box-shadow .2s; z-index:20;
                box-shadow:0 2px 8px rgba(0,0,0,.08);
            }
            .bk-arrow:hover    { background:#f1f5f9; box-shadow:0 4px 16px rgba(0,0,0,.12); }
            .bk-arrow:disabled { opacity:.3; cursor:not-allowed; }
            #bkArrowL { left:6px; }
            #bkArrowR { right:6px; }

            /* Controls bar */
            #bkControls {
                display:flex; align-items:center; justify-content:center;
                gap:.75rem; margin-top:.75rem; flex-wrap:wrap;
            }
            .bk-btn {
                background:#fff; border:1px solid #e2e8f0;
                color:#475569; padding:.35rem .9rem; border-radius:8px;
                cursor:pointer; font-size:.82rem; display:inline-flex; align-items:center; gap:5px;
                transition:background .2s, box-shadow .2s; text-decoration:none;
                box-shadow:0 1px 3px rgba(0,0,0,.06);
            }
            .bk-btn:hover    { background:#f1f5f9; box-shadow:0 2px 8px rgba(0,0,0,.1); }
            .bk-btn:disabled { opacity:.3; cursor:not-allowed; }
            #bkPageInfo {
                background:#f8fafc; border:1px solid #e2e8f0;
                color:#64748b; padding:.35rem .9rem; border-radius:8px;
                font-size:.82rem; min-width:80px; text-align:center;
            }
        </style>

        <div id="bkVisor" style="border-radius:1rem;overflow:visible;">
            <div id="bkScene" style="height:620px; position:relative;">
                <div id="bkLoading">
                    <div class="bk-spinner"></div>
                    <div>Cargando anuario...</div>
                </div>
                <button class="bk-arrow" id="bkArrowL" onclick="bkFlipPrev()" disabled>&#8249;</button>
                <div style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;">
                    <div id="bkBook">
                        <div class="bk-page" id="bkLeft">  <canvas id="bkCanvasL"></canvas></div>
                        <div class="bk-page" id="bkRight"> <canvas id="bkCanvasR"></canvas></div>
                    </div>
                </div>
                <button class="bk-arrow" id="bkArrowR" onclick="bkFlipNext()" disabled>&#8250;</button>
            </div>
            <div id="bkControls">
                <button class="bk-btn" id="bkPrevBtn" onclick="bkFlipPrev()" disabled>&#8249; Anterior</button>
                <span id="bkPageInfo">– / –</span>
                <button class="bk-btn" id="bkNextBtn" onclick="bkFlipNext()" disabled>Siguiente &#8250;</button>
                <span style="width:1px;height:22px;background:#e2e8f0;display:inline-block;margin:0 4px;"></span>
                <button class="bk-btn" onclick="bkZoomOut()" title="Alejar">−</button>
                <span id="bkZoomInfo" class="bk-btn" style="cursor:default;min-width:54px;text-align:center;">100%</span>
                <button class="bk-btn" onclick="bkZoomIn()" title="Acercar">+</button>
            </div>
        </div>

        <script>
        (function(){
            const PDF_URL = '<?php echo addslashes($flipPdfUrl); ?>';
            pdfjsLib.GlobalWorkerOptions.workerSrc =
                'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

            let pdf=null, total=0, cur=0, PW=0, PH=0, busy=false;

            // Caché: pageNum → canvas ya renderizado
            const cache = {};
            // Renderizaciones en progreso: pageNum → Promise
            const inProgress = {};

            /* ── INIT ── */
            pdfjsLib.getDocument({
                url: PDF_URL,
                disableStream: false,       // carga progresiva
                disableAutoFetch: false,
                rangeChunkSize: 65536,      // 64 KB por chunk
            }).promise.then(async doc => {
                pdf   = doc;
                total = doc.numPages;

                const fp  = await doc.getPage(1);
                const vp0 = fp.getViewport({scale:1});
                const asp = vp0.width / vp0.height;

                const scene = document.getElementById('bkScene');
                const maxH  = scene.clientHeight - 10;
                const maxW  = scene.clientWidth  - 100;
                PH = Math.min(maxH, maxW / (asp * 2));
                PW = Math.round(PH * asp);

                const book = document.getElementById('bkBook');
                const bkL  = document.getElementById('bkLeft');
                const bkR  = document.getElementById('bkRight');
                book.style.width   = (PW*2)+'px';
                book.style.height  = PH+'px';
                bkL.style.width  = bkR.style.width  = PW+'px';
                bkL.style.height = bkR.style.height = PH+'px';

                // Mostrar primera página lo antes posible
                await drawFromCache(1, document.getElementById('bkCanvasR'));
                drawBlank(document.getElementById('bkCanvasL'));
                document.getElementById('bkLoading').style.display = 'none';
                bkSetNav(true);
                bkUpdateUI();

                // Pre-renderizar páginas 2-5 en segundo plano sin bloquear
                prerender([2, 3, 4, 5]);

            }).catch(err => {
                document.getElementById('bkLoading').innerHTML =
                    `<div style="color:#e74c3c;text-align:center;">
                        <div style="font-size:2.5rem;margin-bottom:.5rem;">✕</div>
                        <div>No se pudo cargar el PDF</div>
                        <div style="font-size:.8rem;opacity:.6;margin-top:.4rem;">${err.message}</div>
                    </div>`;
            });

            /* ── CACHÉ: obtener canvas renderizado ─────────────────────── */
            function getPageCanvas(num) {
                if (cache[num]) return Promise.resolve(cache[num]);
                if (inProgress[num]) return inProgress[num];
                if (num < 1 || num > total || !pdf) return Promise.resolve(null);

                inProgress[num] = (async () => {
                    const page = await pdf.getPage(num);
                    const vp0  = page.getViewport({scale:1});
                    const sc   = Math.min(PW/vp0.width, PH/vp0.height) * window.devicePixelRatio;
                    const vp   = page.getViewport({scale: sc});

                    const cv   = document.createElement('canvas');
                    cv.width   = Math.round(vp.width);
                    cv.height  = Math.round(vp.height);
                    await page.render({canvasContext: cv.getContext('2d'), viewport: vp}).promise;
                    cache[num] = cv;
                    delete inProgress[num];
                    return cv;
                })();
                return inProgress[num];
            }

            function drawBlank(canvas) {
                canvas.width  = PW;
                canvas.height = PH;
                const ctx = canvas.getContext('2d');
                ctx.fillStyle = '#f8f5ef';
                ctx.fillRect(0, 0, PW, PH);
            }

            async function drawFromCache(num, canvas) {
                canvas.width  = PW;
                canvas.height = PH;
                const ctx = canvas.getContext('2d');
                ctx.fillStyle = '#f8f5ef';
                ctx.fillRect(0, 0, PW, PH);
                if (num < 1 || num > total) return;
                const src = await getPageCanvas(num);
                if (!src) return;
                ctx.fillStyle = '#fff';
                ctx.fillRect(0, 0, PW, PH);
                // Centrar y escalar al tamaño del canvas destino
                const scale = Math.min(PW / src.width, PH / src.height);
                const w = src.width  * scale;
                const h = src.height * scale;
                ctx.drawImage(src, (PW-w)/2, (PH-h)/2, w, h);
            }

            /* Pre-renderiza páginas en segundo plano (idle) */
            function prerender(nums) {
                const run = () => {
                    const n = nums.shift();
                    if (!n) return;
                    getPageCanvas(n).then(() => {
                        if (nums.length) requestIdleCallback ? requestIdleCallback(run) : setTimeout(run, 50);
                    });
                };
                requestIdleCallback ? requestIdleCallback(run) : setTimeout(run, 100);
            }

            async function bkRenderSpread() {
                await Promise.all([
                    drawFromCache(cur,   document.getElementById('bkCanvasL')),
                    drawFromCache(cur+1, document.getElementById('bkCanvasR')),
                ]);
                bkUpdateUI();
                // Pre-cargar páginas adyacentes en fondo
                prerender([cur+2, cur+3, cur-1, cur-2].filter(n=>n>=1&&n<=total&&!cache[n]));
            }

            /* ── FLIP NEXT ── */
            window.bkFlipNext = async function() {
                if (busy||cur+1>total) return;
                busy=true; bkSetNav(false);
                const book   = document.getElementById('bkBook');
                const newCur = cur+2;

                // Iniciar pre-carga mientras se crea el card
                const [srcFront, srcBack] = await Promise.all([
                    getPageCanvas(cur+1),
                    getPageCanvas(newCur),
                ]);

                const sh   = mkShadow('bk-sh-l'); book.appendChild(sh);
                const card = mkCard('bk-fwd');    book.appendChild(card);

                await Promise.all([
                    drawFromCache(cur+1,  card.querySelector('.bk-front canvas')),
                    drawFromCache(newCur, card.querySelector('.bk-back  canvas')),
                ]);

                rAF2(() => card.classList.add('go'));
                setTimeout(async()=>{
                    cur=newCur;
                    await bkRenderSpread();
                    card.remove(); sh.remove();
                    busy=false; bkSetNav(true);
                }, 750);
            };

            /* ── FLIP PREV ── */
            window.bkFlipPrev = async function() {
                if (busy||cur<=0) return;
                busy=true; bkSetNav(false);
                const book   = document.getElementById('bkBook');
                const newCur = cur-2;

                await Promise.all([
                    getPageCanvas(cur),
                    getPageCanvas(newCur+1),
                ]);

                const sh   = mkShadow('bk-sh-r'); book.appendChild(sh);
                const card = mkCard('bk-bwd');    book.appendChild(card);

                await Promise.all([
                    drawFromCache(cur,      card.querySelector('.bk-front canvas')),
                    drawFromCache(newCur+1, card.querySelector('.bk-back  canvas')),
                ]);

                rAF2(() => card.classList.add('go'));
                setTimeout(async()=>{
                    cur=newCur;
                    await bkRenderSpread();
                    card.remove(); sh.remove();
                    busy=false; bkSetNav(true);
                }, 750);
            };

            /* ── HELPERS ── */
            function mkCard(dir) {
                const c=document.createElement('div'); c.className='bk-card '+dir;
                c.style.width=PW+'px'; c.style.height=PH+'px';
                ['bk-front','bk-back'].forEach(cls=>{
                    const f=document.createElement('div'); f.className='bk-face '+cls;
                    const cv=document.createElement('canvas'); cv.width=PW; cv.height=PH;
                    f.appendChild(cv); c.appendChild(f);
                });
                return c;
            }
            function mkShadow(side) {
                const s=document.createElement('div'); s.className='bk-shadow '+side;
                s.style.width=PW+'px'; s.style.height=PH+'px'; return s;
            }
            function rAF2(fn){ requestAnimationFrame(()=>requestAnimationFrame(fn)); }

            function bkSetNav(on) {
                ['bkArrowL','bkArrowR','bkPrevBtn','bkNextBtn'].forEach(id=>{
                    const e=document.getElementById(id); if(e) e.disabled=!on;
                });
            }
            function bkUpdateUI() {
                const canP=cur>0, canN=cur+1<=total;
                ['bkArrowL','bkPrevBtn'].forEach(id=>{ const e=document.getElementById(id); if(e) e.disabled=!canP; });
                ['bkArrowR','bkNextBtn'].forEach(id=>{ const e=document.getElementById(id); if(e) e.disabled=!canN; });
                const l=cur, r=Math.min(cur+1,total);
                document.getElementById('bkPageInfo').textContent =
                    l<1 ? `1 / ${total}` : (r>total ? `${l} / ${total}` : `${l}–${r} / ${total}`);
            }

            /* ── ZOOM ── */
            let bkZoom = 1;
            const ZOOM_MIN = 0.5, ZOOM_MAX = 3, ZOOM_STEP = 0.2;

            window.bkZoomIn  = () => { bkZoom = Math.min(ZOOM_MAX, +(bkZoom + ZOOM_STEP).toFixed(2)); applyZoom(); };
            window.bkZoomOut = () => { bkZoom = Math.max(ZOOM_MIN, +(bkZoom - ZOOM_STEP).toFixed(2)); applyZoom(); };

            function applyZoom() {
                const book = document.getElementById('bkBook');
                book.style.transform       = `scale(${bkZoom})`;
                book.style.transformOrigin = 'center center';
                const info = document.getElementById('bkZoomInfo');
                if (info) info.textContent = Math.round(bkZoom * 100) + '%';
            }

            /* Rueda del mouse → zoom */
            document.getElementById('bkScene').addEventListener('wheel', e => {
                if (!e.ctrlKey && Math.abs(e.deltaY) < 50) return; // solo zoom intencional
                e.preventDefault();
                if (e.deltaY < 0) bkZoomIn(); else bkZoomOut();
            }, { passive: false });

            /* Pinch-to-zoom táctil */
            let pinchDist0 = null;
            let zoom0 = 1;
            document.getElementById('bkScene').addEventListener('touchstart', e => {
                if (e.touches.length === 2) {
                    pinchDist0 = Math.hypot(
                        e.touches[0].clientX - e.touches[1].clientX,
                        e.touches[0].clientY - e.touches[1].clientY
                    );
                    zoom0 = bkZoom;
                }
            }, { passive: true });
            document.getElementById('bkScene').addEventListener('touchmove', e => {
                if (e.touches.length !== 2 || pinchDist0 === null) return;
                e.preventDefault();
                const d = Math.hypot(
                    e.touches[0].clientX - e.touches[1].clientX,
                    e.touches[0].clientY - e.touches[1].clientY
                );
                bkZoom = Math.min(ZOOM_MAX, Math.max(ZOOM_MIN, +(zoom0 * d / pinchDist0).toFixed(2)));
                applyZoom();
            }, { passive: false });
            document.getElementById('bkScene').addEventListener('touchend', e => {
                if (e.touches.length < 2) pinchDist0 = null;
            });

            /* Keyboard */
            document.addEventListener('keydown', e=>{
                if(e.key==='ArrowLeft')  bkFlipPrev();
                if(e.key==='ArrowRight') bkFlipNext();
                if(e.key==='+' || e.key==='=') bkZoomIn();
                if(e.key==='-') bkZoomOut();
                if(e.key==='0') { bkZoom=1; applyZoom(); }
            });

            /* Swipe (solo con 1 dedo) */
            let tx=0;
            document.getElementById('bkVisor').addEventListener('touchstart',e=>{
                if(e.touches.length===1) tx=e.touches[0].clientX;
            },{passive:true});
            document.getElementById('bkVisor').addEventListener('touchend',e=>{
                if(pinchDist0!==null) return; // era pinch, no swipe
                const dx=e.changedTouches[0].clientX-tx;
                if(dx<-60) bkFlipNext(); else if(dx>60) bkFlipPrev();
            });
        })();
        </script>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<style>
.anu-section {
    background: #f1f5f9;
    padding: 3rem 0 4rem;
    min-height: 400px;
}
/* Card */
.anu-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 1.25rem;
    padding: 1.75rem;
    margin-bottom: 1.5rem;
    transition: border-color .25s, box-shadow .25s;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}
.anu-card:hover { border-color: #cbd5e1; box-shadow: 0 8px 24px rgba(0,0,0,.08); }
.anu-card-title {
    font-size: .7rem; font-weight: 700; letter-spacing: .12em;
    text-transform: uppercase; color: #94a3b8;
    margin-bottom: 1.1rem;
    display: flex; align-items: center; gap: .5rem;
}
.anu-card-title::after {
    content:''; flex:1; height:1px; background:#e2e8f0;
}
/* Description */
.anu-desc {
    color: #475569; line-height: 1.9; font-size: .93rem;
    white-space: pre-line;
}
/* Commemorative banner */
.anu-comm-banner {
    background: linear-gradient(135deg, rgba(217,119,6,.08), rgba(245,158,11,.04));
    border: 1px solid rgba(245,158,11,.35);
    border-radius: 1rem; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem;
    display: flex; gap: 1rem; align-items: flex-start;
}
.anu-comm-icon {
    width: 38px; height: 38px; flex-shrink: 0;
    background: rgba(245,158,11,.15); color: #d97706;
    border-radius: .75rem; display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
}
/* People chips */
.anu-chip {
    display: inline-flex; align-items: center; gap: .45rem;
    background: #f8fafc; border: 1px solid #e2e8f0;
    color: #475569; padding: .4rem 1rem;
    border-radius: 2rem; font-size: .82rem;
    transition: background .2s, transform .15s, box-shadow .15s;
}
.anu-chip:hover { background: #f1f5f9; transform: translateY(-1px); box-shadow: 0 3px 10px rgba(0,0,0,.07); }
/* Cover card */
.anu-cover-wrap {
    border-radius: 1.25rem; overflow: hidden;
    box-shadow: 0 12px 40px rgba(0,0,0,.15), 0 0 0 1px #e2e8f0;
    margin-bottom: 1.5rem; position: relative;
}
.anu-cover-wrap img { width: 100%; display: block; aspect-ratio: 3/4; object-fit: cover; }
.anu-cover-wrap::after {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 40%;
    background: linear-gradient(to top, rgba(0,0,0,.25), transparent);
    pointer-events: none;
}
/* Like button */
.anu-like-btn {
    width: 100%; padding: 1rem; border-radius: 1rem; border: none;
    background: linear-gradient(135deg, #dc2626, #ef4444);
    color: #fff; font-size: 1rem; font-weight: 700;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: .6rem;
    box-shadow: 0 6px 24px rgba(220,38,38,.3);
    transition: transform .18s, box-shadow .18s, background .2s;
    position: relative; overflow: hidden;
}
.anu-like-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 10px 32px rgba(220,38,38,.45);
    background: linear-gradient(135deg, #b91c1c, #dc2626);
}
.anu-like-btn:active:not(:disabled) { transform: translateY(0); }
.anu-like-btn:disabled { opacity: .6; cursor: not-allowed; transform: none; }
.anu-like-btn.liked {
    background: linear-gradient(135deg, #b91c1c, #dc2626);
}
.anu-like-btn .heart-icon { font-size: 1.1rem; transition: transform .3s cubic-bezier(.34,1.56,.64,1); }
.anu-like-btn:hover .heart-icon { transform: scale(1.25); }
@keyframes heartPop { 0%{transform:scale(1)} 40%{transform:scale(1.5)} 100%{transform:scale(1)} }
.anu-like-btn.pop .heart-icon { animation: heartPop .4s ease forwards; }
/* Ficha table */
.anu-ficha-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: .6rem 0; border-bottom: 1px solid #f1f5f9;
    font-size: .855rem;
}
.anu-ficha-row:last-child { border-bottom: none; padding-bottom: 0; }
.anu-ficha-label { color: #94a3b8; font-size: .78rem; text-transform: uppercase; letter-spacing:.06em; }
.anu-ficha-val { color: #1e293b; font-weight: 600; }
</style>

<div class="anu-section">
    <div class="container">
        <div class="row g-4">

            <!-- ── Columna principal ── -->
            <div class="col-lg-8">

                <?php if (!empty($anuario['DESCRIPCION'])): ?>
                <div class="anu-card">
                    <div class="anu-card-title"><i class="fas fa-align-left"></i> Descripción</div>
                    <p class="anu-desc mb-0"><?php echo htmlspecialchars($anuario['DESCRIPCION']); ?></p>
                </div>
                <?php endif; ?>

                <?php if ($anuario['ES_CONMEMORATIVO'] === 'S' && !empty($anuario['RAZON_CONMEMORATIVA'])): ?>
                <div class="anu-comm-banner">
                    <div class="anu-comm-icon"><i class="fas fa-star"></i></div>
                    <div>
                        <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#d97706;margin-bottom:.3rem;">Edición Conmemorativa</div>
                        <p style="color:#78350f;font-size:.9rem;line-height:1.7;margin:0;"><?php echo htmlspecialchars($anuario['RAZON_CONMEMORATIVA']); ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($fotografos)): ?>
                <div class="anu-card">
                    <div class="anu-card-title"><i class="fas fa-camera"></i> Fotógrafos</div>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($fotografos as $f): if ($f===''): continue; endif; ?>
                        <span class="anu-chip">
                            <i class="fas fa-circle" style="font-size:.4rem;color:#818cf8;"></i>
                            <?php echo htmlspecialchars($f); ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($contribuyentes)): ?>
                <div class="anu-card">
                    <div class="anu-card-title"><i class="fas fa-users"></i> Contribuyentes</div>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($contribuyentes as $c): if ($c===''): continue; endif; ?>
                        <span class="anu-chip">
                            <i class="fas fa-circle" style="font-size:.4rem;color:#34d399;"></i>
                            <?php echo htmlspecialchars($c); ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>

            <!-- ── Sidebar ── -->
            <div class="col-lg-4">

                <?php if (!empty($anuario['IMAGEN_PORTADA'])): ?>
                <div class="anu-cover-wrap">
                    <img src="<?php echo htmlspecialchars($anuario['IMAGEN_PORTADA']); ?>"
                         alt="Portada de <?php echo htmlspecialchars($anuario['TITULO']); ?>">
                </div>
                <?php endif; ?>

                <!-- Like -->
                <div class="anu-card" style="text-align:center;padding:1.5rem;">
                    <p style="color:#94a3b8;font-size:.78rem;text-transform:uppercase;letter-spacing:.09em;margin-bottom:1rem;">¿Te gustó este anuario?</p>
                    <button id="btnLike" class="anu-like-btn" data-id="<?php echo $anuario['ID']; ?>">
                        <i class="fas fa-heart heart-icon"></i>
                        <span class="btn-label">Dar Like</span>
                        <span id="like-badge" style="background:rgba(255,255,255,.25);padding:.15rem .6rem;border-radius:2rem;font-size:.8rem;font-weight:600;"><?php echo $anuario['LIKES']; ?></span>
                    </button>
                    <p id="like-msg" style="color:#94a3b8;font-size:.75rem;margin-top:.75rem;min-height:1em;"></p>
                </div>

                <!-- Ficha técnica -->
                <div class="anu-card">
                    <div class="anu-card-title"><i class="fas fa-info-circle"></i> Ficha Técnica</div>
                    <div class="anu-ficha-row"><span class="anu-ficha-label">Año</span><span class="anu-ficha-val"><?php echo $anuario['ANIO']; ?></span></div>
                    <?php if (!empty($anuario['DECADA'])): ?>
                    <div class="anu-ficha-row"><span class="anu-ficha-label">Década</span><span class="anu-ficha-val"><?php echo $anuario['DECADA']; ?>s</span></div>
                    <?php endif; ?>
                    <?php if ($anuario['TOTAL_PAGINAS'] > 0): ?>
                    <div class="anu-ficha-row"><span class="anu-ficha-label">Páginas</span><span class="anu-ficha-val"><?php echo $anuario['TOTAL_PAGINAS']; ?></span></div>
                    <?php endif; ?>
                    <div class="anu-ficha-row"><span class="anu-ficha-label">Likes</span><span class="anu-ficha-val" id="likes-sidebar"><?php echo number_format($anuario['LIKES']); ?></span></div>
                    <div class="anu-ficha-row"><span class="anu-ficha-label">Vistas</span><span class="anu-ficha-val"><?php echo number_format($anuario['VISTAS']); ?></span></div>
                    <div class="anu-ficha-row">
                        <span class="anu-ficha-label">Conmem.</span>
                        <span class="anu-ficha-val">
                            <?php if ($anuario['ES_CONMEMORATIVO'] === 'S'): ?>
                                <span style="background:rgba(245,158,11,.12);color:#d97706;padding:.15rem .7rem;border-radius:2rem;font-size:.78rem;border:1px solid rgba(245,158,11,.3);">✦ Sí</span>
                            <?php else: ?>
                                <span style="color:#cbd5e1;">No</span>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>

                <a href="<?php echo $portalURL; ?>anuarios"
                   style="display:flex;align-items:center;justify-content:center;gap:.5rem;
                          color:#64748b;font-size:.82rem;text-decoration:none;
                          padding:.75rem;border:1px solid #e2e8f0;border-radius:1rem;
                          transition:all .2s;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,.05);"
                   onmouseover="this.style.color='#1e293b';this.style.background='#f8fafc';this.style.borderColor='#cbd5e1'"
                   onmouseout="this.style.color='#64748b';this.style.background='#fff';this.style.borderColor='#e2e8f0'">
                    <i class="fas fa-arrow-left" style="font-size:.75rem;"></i> Ver todos los anuarios
                </a>

            </div>
        </div>
    </div>
</div>

<script>
(function(){
    const btn     = document.getElementById('btnLike');
    const msg     = document.getElementById('like-msg');
    const counter = document.getElementById('likes-display');
    const sidebar = document.getElementById('likes-sidebar');
    const badge   = document.getElementById('like-badge');
    if (!btn) return;

    // Proxy para sincronizar todos los contadores al actualizar
    const counterProxy = {
        set textContent(v) {
            if (counter) counter.textContent = v;
            if (sidebar) sidebar.textContent = v;
            if (badge)   badge.textContent   = v;
        }
    };

    // Override: agregar clase liked + animación al éxito
    const _origLike = window.likeConGoogle;
    window.likeConGoogle = function(id, btnEl, cEl) {
        // Animación del corazón
        btnEl.classList.add('pop');
        setTimeout(() => btnEl.classList.remove('pop'), 450);
        _origLike.call(this, id, btnEl, cEl);
    };

    btn.addEventListener('click', function() {
        if (!sessionStorage.getItem('google_credential')) {
            if (msg) msg.textContent = 'Inicia sesión con Google para dar like.';
        }
        // Marcar como liked visualmente al instante
        btn.classList.add('liked');
        window.likeConGoogle(btn.dataset.id, btn, counterProxy);
    });
})();
</script>

<?php include('assets/php/footer.php'); ?>