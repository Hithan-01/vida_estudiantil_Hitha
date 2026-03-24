<?php
$titulo = 'Deportes';
$paginaActiva = 'deportes';

// Cargar configuración global
require_once('../config.php');

include('assets/php/header.php');
include('../cpanel/assets/API/db.php');
$db = new Conexion();

$deportes = [];
$sql = $db->query("SELECT ID, NOMBRE, DESCRIPCION, IMAGEN_URL, RESPONSABLE_NOMBRE, RESPONSABLE_CONTACTO
    FROM VRE_DEPORTES WHERE ACTIVO='S' ORDER BY ORDEN ASC, NOMBRE ASC");
while ($r = $db->recorrer($sql)) $deportes[] = $r;
?>

<!-- Page Header con Colores Deportivos Energéticos -->
<div class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #fb6340 0%, #fbb140 100%); padding: 5rem 0 4rem;">
    <!-- Patrón de fondo sutil -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.1; background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="container position-relative">
        <div class="row align-items-center">
            <!-- Título y Logo -->
            <div class="col-lg-8">
                <div class="d-flex align-items-start mb-4">
                    <!-- Icono Deportivo -->
                    <div class="me-4" style="min-width: 100px;">
                        <div class="d-flex align-items-center justify-content-center rounded-circle"
                             style="width: 100px; height: 100px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border: 3px solid rgba(255,255,255,0.3);">
                            <i class="fas fa-running" style="font-size: 3rem; color: white;"></i>
                        </div>
                    </div>

                    <div>
                        <h1 class="text-white font-weight-bolder mb-2" style="font-size: 2.8rem; line-height: 1.2;">
                            Deportes
                        </h1>
                        <p class="text-white mb-3" style="font-size: 1.15rem; opacity: 0.95;">
                            Mantente activo y compite representando a la universidad
                        </p>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge px-3 py-2" style="background: rgba(255, 255, 255, 0.25); color: white; border: 1px solid rgba(255,255,255,0.4); font-weight: 600;">
                                <i class="fas fa-trophy me-1"></i><?php echo count($deportes); ?> Deportes Activos
                            </span>
                            <span class="badge px-3 py-2" style="background: rgba(255, 255, 255, 0.15); color: white; font-weight: 600;">
                                <i class="fas fa-medal me-1"></i>Vida Deportiva UM
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
        <?php if (empty($deportes)): ?>
            <div class="text-center py-5">
                <div class="icon icon-shape shadow mx-auto mb-4" style="width: 100px; height: 100px; background: linear-gradient(135deg, #fb6340 0%, #fbb140 100%); border-radius: 20px;">
                    <i class="fas fa-running text-white opacity-10" style="font-size: 3rem; line-height: 100px;"></i>
                </div>
                <h4 class="text-muted">No hay deportes disponibles por el momento</h4>
                <p class="text-secondary">Pronto tendremos nuevos deportes disponibles para ti</p>
            </div>
        <?php else: ?>
            <!-- Grid de Deportes -->
            <div class="row g-4">
                <?php foreach ($deportes as $deporte): ?>
                <div class="col-sm-6 col-lg-4 deporte-item">
                    <div class="card border-0 shadow-lg border-radius-xl overflow-hidden h-100"
                         style="transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">

                        <!-- Imagen del Deporte -->
                        <div class="position-relative" style="height: 350px; overflow: hidden;">
                            <?php if (!empty($deporte['IMAGEN_URL'])): ?>
                                <img src="<?php echo $siteURL . htmlspecialchars($deporte['IMAGEN_URL']); ?>"
                                     class="w-100 h-100"
                                     style="object-fit: cover; transition: transform 0.5s ease;"
                                     alt="<?php echo htmlspecialchars($deporte['NOMBRE']); ?>"
                                     onmouseover="this.style.transform='scale(1.08)'"
                                     onmouseout="this.style.transform='scale(1)'">
                            <?php else: ?>
                                <!-- Gradiente de respaldo deportivo -->
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #fb6340 0%, #fbb140 100%);">
                                    <i class="fas fa-running" style="font-size: 5rem; color: white; opacity: 0.4;"></i>
                                </div>
                            <?php endif; ?>

                            <!-- Gradiente overlay -->
                            <div class="position-absolute top-0 start-0 w-100 h-100"
                                 style="background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.2) 60%, rgba(0,0,0,0.7) 100%);"></div>

                            <!-- Badge flotante -->
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge px-3 py-2 shadow" style="background: #fb6340; color: white; font-size: 0.75rem; font-weight: 700;">
                                    <i class="fas fa-trophy me-1"></i>Deporte
                                </span>
                            </div>
                        </div>

                        <!-- Contenido del Deporte -->
                        <div class="card-body p-4" style="background: #fff;">
                            <!-- Nombre del Deporte -->
                            <h5 class="font-weight-bolder text-dark mb-3" style="font-size: 1.25rem; line-height: 1.4;">
                                <?php echo htmlspecialchars($deporte['NOMBRE']); ?>
                            </h5>

                            <!-- Descripción -->
                            <?php if (!empty($deporte['DESCRIPCION'])): ?>
                            <p class="text-sm text-secondary mb-3" style="line-height: 1.6;">
                                <?php echo htmlspecialchars(mb_substr($deporte['DESCRIPCION'], 0, 120)); ?>...
                            </p>
                            <?php endif; ?>

                            <!-- Info del Responsable -->
                            <?php if (!empty($deporte['RESPONSABLE_NOMBRE'])): ?>
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-xs shadow text-center border-radius-md me-2" style="width: 28px; height: 28px; background: #fb6340;">
                                        <i class="fas fa-user-tie text-white" style="font-size: 0.7rem; line-height: 28px;"></i>
                                    </div>
                                    <p class="text-xs text-secondary mb-0 font-weight-500">
                                        <strong style="color: #fb6340;">Coach:</strong> <?php echo htmlspecialchars($deporte['RESPONSABLE_NOMBRE']); ?>
                                    </p>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Botón de acción con colores deportivos -->
                            <a href="<?php echo $portalURL; ?>deporte/<?php echo $deporte['ID']; ?>"
                               class="btn w-100 font-weight-bold mb-0 shadow-sm btn-deporte">
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

<!-- Estilos adicionales con colores deportivos -->
<style>
    /* Colores deportivos energéticos: Naranja #fb6340 y Amarillo #fbb140 */
    .card:hover {
        transform: translateY(-8px) !important;
        box-shadow: 0 20px 40px rgba(251, 99, 64, 0.25) !important;
    }

    /* Botón con colores deportivos */
    .btn-deporte {
        background: linear-gradient(135deg, #fb6340 0%, #fbb140 100%);
        color: white;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        font-weight: 700;
    }

    .btn-deporte:hover {
        background: white;
        color: #fb6340;
        border: 2px solid #fb6340;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(251, 99, 64, 0.4);
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

    .deporte-item {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .deporte-item:nth-child(1) { animation-delay: 0.1s; }
    .deporte-item:nth-child(2) { animation-delay: 0.2s; }
    .deporte-item:nth-child(3) { animation-delay: 0.3s; }
    .deporte-item:nth-child(4) { animation-delay: 0.4s; }
    .deporte-item:nth-child(5) { animation-delay: 0.5s; }
    .deporte-item:nth-child(6) { animation-delay: 0.6s; }
    .deporte-item:nth-child(n+7) { animation-delay: 0.7s; }
</style>

<script>
// Animación suave al cargar
document.addEventListener('DOMContentLoaded', function() {
    console.log('Página de deportes cargada - Vida Deportiva UM');
});
</script>

<?php include('assets/php/footer.php'); ?>
