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

<!-- Page Header -->
<div style="background:linear-gradient(135deg,#5e72e4,#825ee4);padding:3rem 0;color:#fff;margin-bottom:0;">
    <div class="container">
        <h1 style="font-size:2.25rem;font-weight:800;margin-bottom:.5rem;">
            <i class="fas fa-users me-3"></i>Clubes Estudiantiles
        </h1>
        <p style="opacity:.9;margin:0;">Encuentra el club perfecto para ti y forma parte de una comunidad increíble</p>
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
