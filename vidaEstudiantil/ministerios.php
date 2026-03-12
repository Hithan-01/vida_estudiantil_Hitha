<?php
$titulo = 'Ministerios';
$paginaActiva = 'ministerios';
$siteURL = '/vida_estudiantil_Hitha/';
$portalURL = $siteURL . 'vidaEstudiantil/';

include('assets/php/header.php');
include('../cpanel/assets/API/db.php');
$db = new Conexion();

$ministerios = [];
$sql = $db->query("SELECT ID, NOMBRE, TIPO, DESCRIPCION, IMAGEN_URL, RESPONSABLE_NOMBRE, HORARIO, LUGAR
    FROM VRE_MINISTERIOS WHERE ACTIVO='S' ORDER BY ORDEN ASC, NOMBRE ASC");
while ($r = $db->recorrer($sql)) $ministerios[] = $r;
?>

<!-- Page Header con Logo y Colores Amarillos del Ministerio -->
<div class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #fbda20 0%, #d9b000 100%); padding: 5rem 0 4rem;">
    <!-- Patrón de fondo sutil -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.08; background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%231565C0" fill-opacity="1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="container position-relative">
        <div class="row align-items-center">
            <!-- Logo y Título -->
            <div class="col-lg-8">
                <div class="d-flex align-items-start mb-4">
                    <!-- Logo del Ministerio -->
                    <div class="me-4" style="min-width: 100px;">
                        <img src="<?php echo $siteURL; ?>Logo_Clubes_Ministerios-removebg-preview.png"
                             alt="Logo Ministerio Juvenil"
                             style="width: 100px; height: auto; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));">
                    </div>

                    <div>
                        <h1 class="font-weight-bolder mb-2" style="font-size: 2.8rem; line-height: 1.2; color: #156fb5;">
                            Ministerios
                        </h1>
                        <p class="mb-3" style="font-size: 1.15rem; color: #156fb5; opacity: 0.9;">
                            Crece espiritualmente y sirve a tu comunidad universitaria
                        </p>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge px-3 py-2" style="background: rgba(21, 101, 192, 0.2); color: #156fb5; border: 1px solid #156fb5; font-weight: 600;">
                                <i class="fas fa-hands-praying me-1"></i><?php echo count($ministerios); ?> Ministerios Activos
                            </span>
                            <span class="badge px-3 py-2" style="background: rgba(21, 101, 192, 0.15); color: #156fb5; font-weight: 600;">
                                <i class="fas fa-heart me-1"></i>Ministerio Juvenil Doulos
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wave separador -->
    <div class="position-absolute bottom-0 start-0 w-100" style="transform: translateY(1px);">
        <svg viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg" style="display: block;">
            <path fill="#f8f9fa" d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"/>
        </svg>
    </div>
</div>

<main class="bg-gray-100 py-5">
    <div class="container">
        <?php if (empty($ministerios)): ?>
            <div class="text-center py-5">
                <div class="icon icon-shape shadow mx-auto mb-4" style="width: 100px; height: 100px; background: #fbda20;">
                    <i class="fas fa-hands-praying opacity-10" style="font-size: 3rem; line-height: 100px; color: #156fb5;"></i>
                </div>
                <h4 class="text-muted">No hay ministerios disponibles por el momento</h4>
                <p class="text-secondary">Pronto habrán nuevos ministerios disponibles para ti</p>
            </div>
        <?php else: ?>
            <!-- Grid de Ministerios -->
            <div class="row g-4">
                <?php foreach ($ministerios as $m): ?>
                <div class="col-sm-6 col-lg-4 ministerio-item">
                    <div class="card border-0 shadow-lg border-radius-xl overflow-hidden h-100"
                         style="transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">

                        <!-- Imagen del Ministerio -->
                        <div class="position-relative" style="height: 350px; overflow: hidden;">
                            <?php if (!empty($m['IMAGEN_URL'])): ?>
                                <img src="<?php echo $siteURL . htmlspecialchars($m['IMAGEN_URL']); ?>"
                                     class="w-100 h-100"
                                     style="object-fit: cover; transition: transform 0.5s ease;"
                                     alt="<?php echo htmlspecialchars($m['NOMBRE']); ?>"
                                     onmouseover="this.style.transform='scale(1.08)'"
                                     onmouseout="this.style.transform='scale(1)'">
                            <?php else: ?>
                                <!-- Gradiente de respaldo con colores amarillos -->
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #fbda20 0%, #d9b000 100%);">
                                    <i class="fas fa-hands-praying" style="font-size: 5rem; color: #156fb5; opacity: 0.4;"></i>
                                </div>
                            <?php endif; ?>

                            <!-- Gradiente overlay -->
                            <div class="position-absolute top-0 start-0 w-100 h-100"
                                 style="background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.2) 60%, rgba(0,0,0,0.7) 100%);"></div>

                            <!-- Badges flotantes -->
                            <div class="position-absolute top-0 start-0 m-3">
                                <?php if (!empty($m['TIPO'])): ?>
                                <span class="badge px-3 py-2 shadow mb-2 d-block" style="background: #156fb5; color: #fbda20; font-size: 0.7rem; font-weight: 700; width: fit-content;">
                                    <?php echo htmlspecialchars($m['TIPO']); ?>
                                </span>
                                <?php endif; ?>
                                <span class="badge px-3 py-2 shadow" style="background: #156fb5; color: white; font-size: 0.75rem; font-weight: 700;">
                                    <i class="fas fa-hands-praying me-1"></i>Ministerio
                                </span>
                            </div>
                        </div>

                        <!-- Contenido del Ministerio -->
                        <div class="card-body p-4" style="background: #fff;">
                            <!-- Nombre del Ministerio -->
                            <h5 class="font-weight-bolder text-dark mb-3" style="font-size: 1.25rem; line-height: 1.4;">
                                <?php echo htmlspecialchars($m['NOMBRE']); ?>
                            </h5>

                            <!-- Descripción -->
                            <?php if (!empty($m['DESCRIPCION'])): ?>
                            <p class="text-sm text-secondary mb-3" style="line-height: 1.6;">
                                <?php echo htmlspecialchars(mb_substr($m['DESCRIPCION'], 0, 120)); ?>...
                            </p>
                            <?php endif; ?>

                            <!-- Info del Ministerio -->
                            <div class="mb-3">
                                <?php if (!empty($m['HORARIO'])): ?>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="icon icon-xs shadow text-center border-radius-md me-2" style="width: 28px; height: 28px; background: #fbda20;">
                                        <i class="fas fa-clock" style="font-size: 0.7rem; line-height: 28px; color: #156fb5;"></i>
                                    </div>
                                    <p class="text-xs text-secondary mb-0 font-weight-500">
                                        <?php echo htmlspecialchars($m['HORARIO']); ?>
                                    </p>
                                </div>
                                <?php endif; ?>

                                <?php if (!empty($m['LUGAR'])): ?>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="icon icon-xs shadow text-center border-radius-md me-2" style="width: 28px; height: 28px; background: #fbda20;">
                                        <i class="fas fa-map-marker-alt" style="font-size: 0.7rem; line-height: 28px; color: #156fb5;"></i>
                                    </div>
                                    <p class="text-xs text-secondary mb-0 font-weight-500">
                                        <?php echo htmlspecialchars($m['LUGAR']); ?>
                                    </p>
                                </div>
                                <?php endif; ?>

                                <?php if (!empty($m['RESPONSABLE_NOMBRE'])): ?>
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-xs shadow text-center border-radius-md me-2" style="width: 28px; height: 28px; background: #156fb5;">
                                        <i class="fas fa-user text-white" style="font-size: 0.7rem; line-height: 28px;"></i>
                                    </div>
                                    <p class="text-xs text-secondary mb-0 font-weight-500">
                                        <strong style="color: #fbda20;">Director:</strong> <?php echo htmlspecialchars($m['RESPONSABLE_NOMBRE']); ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Botón de acción con colores amarillos -->
                            <a href="<?php echo $portalURL; ?>ministerio/<?php echo $m['ID']; ?>"
                               class="btn w-100 font-weight-bold mb-0 shadow-sm btn-ministerio-doulos">
                                Ver detalles <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<!-- Estilos adicionales con colores Ministerio Doulos (Amarillos) -->
<style>
    /* Colores del logo invertidos: Amarillo #fbda20 principal, Azul #156fb5 acento */
    .card:hover {
        transform: translateY(-8px) !important;
        box-shadow: 0 20px 40px rgba(255, 193, 7, 0.25) !important;
    }

    /* Botón con colores amarillos del logo */
    .btn-ministerio-doulos {
        background: linear-gradient(135deg, #fbda20 0%, #d9b000 100%);
        color: #156fb5;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        font-weight: 700;
    }

    .btn-ministerio-doulos:hover {
        background: white;
        color: #fbda20;
        border: 2px solid #fbda20;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 193, 7, 0.4);
    }

    .icon-xs {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-shape {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Animación de entrada */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .ministerio-item {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .ministerio-item:nth-child(1) { animation-delay: 0.1s; }
    .ministerio-item:nth-child(2) { animation-delay: 0.2s; }
    .ministerio-item:nth-child(3) { animation-delay: 0.3s; }
    .ministerio-item:nth-child(4) { animation-delay: 0.4s; }
    .ministerio-item:nth-child(5) { animation-delay: 0.5s; }
    .ministerio-item:nth-child(6) { animation-delay: 0.6s; }
    .ministerio-item:nth-child(n+7) { animation-delay: 0.7s; }
</style>

<script>
// Animación suave al cargar
document.addEventListener('DOMContentLoaded', function() {
    console.log('Página de ministerios cargada - Ministerio Juvenil Doulos');
});
</script>

<?php include('assets/php/footer.php'); ?>
