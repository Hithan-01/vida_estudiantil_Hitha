<?php
$titulo = 'Anuarios Institucionales';
$paginaActiva = 'anuarios';

// Cargar configuración global
require_once('../config.php');

include('assets/php/header.php');
include('../cpanel/assets/API/db.php');
$db = new Conexion();

// ── Filtros ──
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$decade = isset($_GET['decada']) ? intval($_GET['decada']) : 0;
$order  = in_array($_GET['orden'] ?? '', ['recent','oldest','likes','views']) ? $_GET['orden'] : 'recent';
$conmem = isset($_GET['conmemorativo']) && $_GET['conmemorativo'] === '1';

// Décadas disponibles
$decadasRes = $db->query("SELECT DISTINCT DECADA FROM VRE_ANUARIOS WHERE ACTIVO='S' AND DECADA IS NOT NULL ORDER BY DECADA ASC");
$decadas = [];
while ($r = $db->recorrer($decadasRes)) $decadas[] = $r['DECADA'];

// ── Query ──
$q = "SELECT * FROM VRE_ANUARIOS WHERE ACTIVO='S'";
if ($search !== '') {
    $s = $db->real_escape_string($search);
    $q .= " AND (TITULO LIKE '%$s%' OR DESCRIPCION LIKE '%$s%')";
}
if ($decade > 0) $q .= " AND DECADA = $decade";
if ($conmem)     $q .= " AND ES_CONMEMORATIVO = 'S'";

switch ($order) {
    case 'oldest': $q .= " ORDER BY ANIO ASC";    break;
    case 'likes':  $q .= " ORDER BY LIKES DESC";  break;
    case 'views':  $q .= " ORDER BY VISTAS DESC"; break;
    default:       $q .= " ORDER BY ANIO DESC";   break;
}

$anuarios = [];
$res = $db->query($q);
while ($r = $db->recorrer($res)) $anuarios[] = $r;
?>

<!-- ── Page Header ── -->
<div style="background:linear-gradient(135deg,#344767,#5e72e4);padding:3rem 0;color:#fff;margin-bottom:0;">
    <div class="container">
        <h1 style="font-size:2.25rem;font-weight:800;margin-bottom:.5rem;">
            <i class="fas fa-book-open me-3"></i>Anuarios Institucionales
        </h1>
        <p style="opacity:.85;margin:0;">Repositorio histórico de anuarios de la Universidad de Monterrey</p>
    </div>
</div>

<main class="container py-5">

    <!-- ── Filtros y buscador ── -->
    <form method="get" id="filtroForm" class="mb-5">
        <div class="row g-3 align-items-end">
            <!-- Buscador -->
            <div class="col-lg-4 col-md-6">
                <label class="form-label fw-semibold text-secondary" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.05em;">Buscar</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-secondary"></i></span>
                    <input type="text" name="q" class="form-control border-start-0"
                           placeholder="Título o descripción…"
                           value="<?php echo htmlspecialchars($search); ?>"
                           style="border-radius:0 .75rem .75rem 0;">
                </div>
            </div>
            <!-- Décadas -->
            <div class="col-lg-2 col-md-3 col-6">
                <label class="form-label fw-semibold text-secondary" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.05em;">Década</label>
                <select name="decada" class="form-select" style="border-radius:.75rem;">
                    <option value="0">Todas</option>
                    <?php foreach ($decadas as $d): ?>
                        <option value="<?php echo $d; ?>" <?php echo $decade === (int)$d ? 'selected' : ''; ?>>
                            <?php echo $d; ?>s
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Ordenar -->
            <div class="col-lg-2 col-md-3 col-6">
                <label class="form-label fw-semibold text-secondary" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.05em;">Ordenar</label>
                <select name="orden" class="form-select" style="border-radius:.75rem;">
                    <option value="recent"  <?php echo $order === 'recent'  ? 'selected' : ''; ?>>Más reciente</option>
                    <option value="oldest"  <?php echo $order === 'oldest'  ? 'selected' : ''; ?>>Más antiguo</option>
                    <option value="likes"   <?php echo $order === 'likes'   ? 'selected' : ''; ?>>Más votado</option>
                    <option value="views"   <?php echo $order === 'views'   ? 'selected' : ''; ?>>Más visto</option>
                </select>
            </div>
            <!-- Conmemorativos -->
            <div class="col-lg-2 col-md-6">
                <div class="form-check form-switch mt-4 pt-1">
                    <input class="form-check-input" type="checkbox" id="chkConmem" name="conmemorativo" value="1"
                           <?php echo $conmem ? 'checked' : ''; ?>>
                    <label class="form-check-label fw-semibold" for="chkConmem" style="font-size:.875rem;">
                        Solo conmemorativos
                    </label>
                </div>
            </div>
            <!-- Botón -->
            <div class="col-lg-2 col-md-6">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill" style="border-radius:.75rem;">
                        <i class="fas fa-filter me-1"></i>Filtrar
                    </button>
                    <?php if ($search || $decade || $conmem || $order !== 'recent'): ?>
                        <a href="<?php echo $portalURL; ?>anuarios" class="btn btn-outline-secondary" style="border-radius:.75rem;" title="Limpiar">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>

    <!-- ── Resultados ── -->
    <?php if (empty($anuarios)): ?>
        <div class="text-center py-6">
            <i class="fas fa-book fa-4x text-muted mb-4" style="opacity:.3;"></i>
            <h4 class="text-muted">No se encontraron anuarios</h4>
            <p class="text-secondary">Prueba con otros filtros de búsqueda.</p>
            <a href="<?php echo $portalURL; ?>anuarios" class="btn btn-outline-primary mt-2">Ver todos los anuarios</a>
        </div>
    <?php else: ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <p class="text-muted mb-0">
                <strong><?php echo count($anuarios); ?></strong> anuario<?php echo count($anuarios) !== 1 ? 's' : ''; ?> encontrado<?php echo count($anuarios) !== 1 ? 's' : ''; ?>
            </p>
        </div>
        <div class="row g-4">
            <?php foreach ($anuarios as $a): ?>
            <?php
                $fotografos    = !empty($a['FOTOGRAFOS'])   ? array_map('trim', explode(',', $a['FOTOGRAFOS']))   : [];
                $contribuyentes = !empty($a['CONTRIBUYENTES']) ? array_map('trim', explode(',', $a['CONTRIBUYENTES'])) : [];
            ?>
            <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="card shadow border-0 border-radius-xl move-on-hover h-100 position-relative overflow-hidden">

                    <!-- Portada -->
                    <a href="<?php echo $portalURL; ?>anuario/<?php echo $a['ID']; ?>" class="text-decoration-none d-block position-relative">
                        <?php if (!empty($a['IMAGEN_PORTADA'])): ?>
                            <img src="<?php echo htmlspecialchars($a['IMAGEN_PORTADA']); ?>"
                                 alt="<?php echo htmlspecialchars($a['TITULO']); ?>"
                                 class="w-100" style="height:230px;object-fit:cover;">
                        <?php else: ?>
                            <div class="bg-gradient-dark d-flex align-items-center justify-content-center" style="height:230px;">
                                <i class="fas fa-book-open fa-4x text-white" style="opacity:.4;"></i>
                            </div>
                        <?php endif; ?>
                        <!-- Año badge -->
                        <span class="badge bg-gradient-primary position-absolute top-0 end-0 m-2 px-2 py-1" style="font-size:.85rem;font-weight:800;">
                            <?php echo $a['ANIO']; ?>
                        </span>
                        <!-- Conmemorativo badge -->
                        <?php if ($a['ES_CONMEMORATIVO'] === 'S'): ?>
                            <span class="badge bg-gradient-warning position-absolute top-0 start-0 m-2">
                                <i class="fas fa-star me-1"></i>Conmemorativo
                            </span>
                        <?php endif; ?>
                    </a>

                    <div class="card-body d-flex flex-column px-3 pb-3 pt-2">
                        <!-- Título -->
                        <h6 class="font-weight-bolder mb-1" style="font-size:.95rem;line-height:1.3;">
                            <a href="<?php echo $portalURL; ?>anuario/<?php echo $a['ID']; ?>" class="text-dark text-decoration-none">
                                <?php echo htmlspecialchars($a['TITULO']); ?>
                            </a>
                        </h6>
                        <!-- Décadas -->
                        <?php if (!empty($a['DECADA'])): ?>
                            <span class="text-secondary" style="font-size:.75rem;"><i class="fas fa-clock me-1"></i>Década de los <?php echo $a['DECADA']; ?>s</span>
                        <?php endif; ?>
                        <!-- Descripción -->
                        <?php if (!empty($a['DESCRIPCION'])): ?>
                            <p class="text-secondary mt-2 mb-2" style="font-size:.8rem;line-height:1.5;">
                                <?php echo htmlspecialchars(mb_substr($a['DESCRIPCION'], 0, 90)); ?><?php echo mb_strlen($a['DESCRIPCION']) > 90 ? '…' : ''; ?>
                            </p>
                        <?php endif; ?>
                        <!-- Meta info -->
                        <div class="mt-auto">
                            <div class="d-flex flex-wrap gap-2 mb-2" style="font-size:.75rem;color:#8392ab;">
                                <?php if (!empty($a['TOTAL_PAGINAS']) && $a['TOTAL_PAGINAS'] > 0): ?>
                                    <span><i class="fas fa-file-alt me-1"></i><?php echo $a['TOTAL_PAGINAS']; ?> págs.</span>
                                <?php endif; ?>
                                <?php if (!empty($fotografos)): ?>
                                    <span title="<?php echo htmlspecialchars(implode(', ', $fotografos)); ?>">
                                        <i class="fas fa-camera me-1"></i><?php echo count($fotografos); ?> fotógrafo<?php echo count($fotografos) !== 1 ? 's' : ''; ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($contribuyentes)): ?>
                                    <span title="<?php echo htmlspecialchars(implode(', ', $contribuyentes)); ?>">
                                        <i class="fas fa-users me-1"></i><?php echo count($contribuyentes); ?> contribuyente<?php echo count($contribuyentes) !== 1 ? 's' : ''; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <!-- Likes / Vistas / Like button -->
                            <div class="d-flex align-items-center justify-content-between mt-2 pt-2 border-top">
                                <div class="d-flex gap-3" style="font-size:.8rem;color:#8392ab;">
                                    <span class="likes-count-<?php echo $a['ID']; ?>">
                                        <i class="fas fa-heart me-1 text-danger"></i><?php echo number_format($a['LIKES']); ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-eye me-1"></i><?php echo number_format($a['VISTAS']); ?>
                                    </span>
                                </div>
                                <button class="btn btn-sm btn-outline-danger py-1 px-2 btn-like"
                                        data-id="<?php echo $a['ID']; ?>"
                                        style="font-size:.75rem;border-radius:.5rem;">
                                    <i class="fas fa-heart me-1"></i>Like
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<script>
document.querySelectorAll('.btn-like').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const id   = this.dataset.id;
        const self = this;
        const counter = document.querySelector('.likes-count-' + id);
        window.likeConGoogle(id, self, counter);
    });
});

// Auto-submit al cambiar selects
document.querySelectorAll('#filtroForm select').forEach(s => {
    s.addEventListener('change', () => document.getElementById('filtroForm').submit());
});
document.getElementById('chkConmem')?.addEventListener('change', () => document.getElementById('filtroForm').submit());
</script>
<?php include('assets/php/footer.php'); ?>
