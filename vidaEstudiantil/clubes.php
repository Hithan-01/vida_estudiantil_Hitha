<?php
$titulo = 'Clubes';
$paginaActiva = 'clubes';
$siteURL = '/vida_estudiantil_Hitha/';
$portalURL = $siteURL . 'vidaEstudiantil/';

include('assets/php/header.php');
include('../cpanel/assets/API/db.php');
$db = new Conexion();

$clubes = [];
$sql = $db->query("SELECT ID, NOMBRE, DESCRIPCION, IMAGEN_URL, RESPONSABLE_NOMBRE, HORARIO, LUGAR, RESPONSABLE_CONTACTO AS CONTACTO
    FROM VRE_CLUBES WHERE ACTIVO='S' ORDER BY ORDEN ASC, NOMBRE ASC");
while ($r = $db->recorrer($sql)) $clubes[] = $r;
?>

<!-- Page Header con Logo y Fondo de Imagen -->
<div class="position-relative overflow-hidden" style="background: url('<?php echo $siteURL; ?>Fondo_Clubes.jpg') center center / cover no-repeat; padding: 5rem 0 4rem;">
    <!-- Overlay oscuro para legibilidad -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(21, 111, 181, 0.85) 0%, rgba(13, 84, 145, 0.9) 100%);"></div>

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
                        <h1 class="text-white font-weight-bolder mb-2" style="font-size: 2.8rem; line-height: 1.2;">
                            Clubes Estudiantiles
                        </h1>
                        <p class="text-white mb-3" style="font-size: 1.15rem; opacity: 0.95;">
                            Encuentra el club perfecto para ti y forma parte de una comunidad increíble
                        </p>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge px-3 py-2" style="background: rgba(251, 218, 32, 0.2); color: #fbda20; border: 1px solid #fbda20; font-weight: 600;">
                                <i class="fas fa-users me-1"></i><?php echo count($clubes); ?> Clubes Activos
                            </span>
                            <span class="badge px-3 py-2" style="background: rgba(255, 255, 255, 0.15); color: white; font-weight: 600;">
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
        <?php if (empty($clubes)): ?>
            <div class="text-center py-5">
                <div class="icon icon-shape shadow mx-auto mb-4" style="width: 100px; height: 100px; background: #156fb5;">
                    <i class="fas fa-users text-white opacity-10" style="font-size: 3rem; line-height: 100px;"></i>
                </div>
                <h4 class="text-muted">No hay clubes disponibles por el momento</h4>
                <p class="text-secondary">Pronto habrán nuevos clubes disponibles para ti</p>
            </div>
        <?php else: ?>
            <!-- Grid de Clubes -->
            <div class="row g-4" id="listaClubes">
                <?php foreach ($clubes as $club): ?>
                <div class="col-sm-6 col-lg-4 club-item">
                    <div class="card border-0 shadow-lg border-radius-xl overflow-hidden h-100"
                         style="transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">

                        <!-- Imagen del Club -->
                        <div class="position-relative" style="height: 350px; overflow: hidden;">
                            <?php if (!empty($club['IMAGEN_URL'])): ?>
                                <img src="<?php echo $siteURL . htmlspecialchars($club['IMAGEN_URL']); ?>"
                                     class="w-100 h-100"
                                     style="object-fit: cover; transition: transform 0.5s ease;"
                                     alt="<?php echo htmlspecialchars($club['NOMBRE']); ?>"
                                     onmouseover="this.style.transform='scale(1.08)'"
                                     onmouseout="this.style.transform='scale(1)'">
                            <?php else: ?>
                                <!-- Gradiente de respaldo con colores del logo -->
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #156fb5 0%, #0d5491 100%);">
                                    <i class="fas fa-users" style="font-size: 5rem; color: #fbda20; opacity: 0.4;"></i>
                                </div>
                            <?php endif; ?>

                            <!-- Gradiente overlay -->
                            <div class="position-absolute top-0 start-0 w-100 h-100"
                                 style="background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.2) 60%, rgba(0,0,0,0.7) 100%);"></div>

                            <!-- Badge flotante con colores del logo -->
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge px-3 py-2 shadow" style="background: #fbda20; color: #156fb5; font-size: 0.75rem; font-weight: 700;">
                                    <i class="fas fa-users me-1"></i>Club Estudiantil
                                </span>
                            </div>
                        </div>

                        <!-- Contenido del Club -->
                        <div class="card-body p-4" style="background: #fff;">
                            <!-- Nombre del Club -->
                            <h5 class="font-weight-bolder text-dark mb-3" style="font-size: 1.25rem; line-height: 1.4;">
                                <?php echo htmlspecialchars($club['NOMBRE']); ?>
                            </h5>

                            <!-- Descripción -->
                            <?php if (!empty($club['DESCRIPCION'])): ?>
                            <p class="text-sm text-secondary mb-3" style="line-height: 1.6;">
                                <?php echo htmlspecialchars(mb_substr($club['DESCRIPCION'], 0, 120)); ?>...
                            </p>
                            <?php endif; ?>

                            <!-- Info del Club -->
                            <div class="mb-3">
                                <?php if (!empty($club['HORARIO'])): ?>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="icon icon-xs shadow text-center border-radius-md me-2" style="width: 28px; height: 28px; background: #156fb5;">
                                        <i class="fas fa-clock text-white" style="font-size: 0.7rem; line-height: 28px;"></i>
                                    </div>
                                    <p class="text-xs text-secondary mb-0 font-weight-500">
                                        <?php echo htmlspecialchars($club['HORARIO']); ?>
                                    </p>
                                </div>
                                <?php endif; ?>

                                <?php if (!empty($club['LUGAR'])): ?>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="icon icon-xs shadow text-center border-radius-md me-2" style="width: 28px; height: 28px; background: #156fb5;">
                                        <i class="fas fa-map-marker-alt text-white" style="font-size: 0.7rem; line-height: 28px;"></i>
                                    </div>
                                    <p class="text-xs text-secondary mb-0 font-weight-500">
                                        <?php echo htmlspecialchars($club['LUGAR']); ?>
                                    </p>
                                </div>
                                <?php endif; ?>

                                <?php if (!empty($club['RESPONSABLE_NOMBRE'])): ?>
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-xs shadow text-center border-radius-md me-2" style="width: 28px; height: 28px; background: #fbda20;">
                                        <i class="fas fa-user" style="font-size: 0.7rem; line-height: 28px; color: #156fb5;"></i>
                                    </div>
                                    <p class="text-xs text-secondary mb-0 font-weight-500">
                                        <strong style="color: #156fb5;">Director:</strong> <?php echo htmlspecialchars($club['RESPONSABLE_NOMBRE']); ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Botón de acción con colores del logo -->
                            <a href="<?php echo $portalURL; ?>club/<?php echo $club['ID']; ?>"
                               class="btn w-100 font-weight-bold mb-0 shadow-sm btn-club-doulos">
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

<!-- Estilos adicionales con colores Ministerio Doulos -->
<style>
    /* Colores del logo: Azul #156fb5 y Amarillo #fbda20 */
    .card:hover {
        transform: translateY(-8px) !important;
        box-shadow: 0 20px 40px rgba(21, 101, 192, 0.25) !important;
    }

    /* Botón con colores del logo */
    .btn-club-doulos {
        background: linear-gradient(135deg, #156fb5 0%, #0d5491 100%);
        color: white;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .btn-club-doulos:hover {
        background: white;
        color: #156fb5;
        border: 2px solid #156fb5;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(21, 101, 192, 0.3);
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

    .club-item {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .club-item:nth-child(1) { animation-delay: 0.1s; }
    .club-item:nth-child(2) { animation-delay: 0.2s; }
    .club-item:nth-child(3) { animation-delay: 0.3s; }
    .club-item:nth-child(4) { animation-delay: 0.4s; }
    .club-item:nth-child(5) { animation-delay: 0.5s; }
    .club-item:nth-child(6) { animation-delay: 0.6s; }
    .club-item:nth-child(n+7) { animation-delay: 0.7s; }
</style>

<script>
// Animación suave al cargar
document.addEventListener('DOMContentLoaded', function() {
    // Las animaciones se manejan por CSS ahora
    console.log('Página de clubes cargada - Ministerio Juvenil Doulos');
});
</script>

<?php include('assets/php/footer.php'); ?>
