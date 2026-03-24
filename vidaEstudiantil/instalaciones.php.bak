<?php
$titulo = 'Instalaciones';
$paginaActiva = 'instalaciones';
$siteURL = '/vida_estudiantil_Hitha/';
$portalURL = $siteURL . 'vidaEstudiantil/';

include('assets/php/header.php');
include('../cpanel/assets/API/db.php');
$db = new Conexion();

$instalaciones = [];
$sql = $db->query("SELECT ID, NOMBRE, DESCRIPCION, IMAGEN_URL, UBICACION, HORARIO, CAPACIDAD, SERVICIOS, RESPONSABLE_CONTACTO
    FROM VRE_INSTALACIONES WHERE ACTIVO='S' ORDER BY ORDEN ASC, NOMBRE ASC");
while ($r = $db->recorrer($sql)) $instalaciones[] = $r;
?>

<!-- Page Header - Diseño Campus Virtual Tour -->
<div class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #2c3e50 0%, #3a5167 50%, #2c3e50 100%); padding: 6rem 0 5rem;">
    <!-- Patrón arquitectónico de fondo -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.05; background-image: url('data:image/svg+xml,%3Csvg width=\"100\" height=\"100\" viewBox=\"0 0 100 100\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z\" fill=\"%23ffffff\" fill-opacity=\"1\" fill-rule=\"evenodd\"/%3E%3C/svg%3E');">
    </div>

    <div class="container position-relative">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-lg-10">
                <!-- Icono principal de instalaciones -->
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                         style="width: 90px; height: 90px; background: rgba(251, 218, 32, 0.15); backdrop-filter: blur(10px); border: 2px solid rgba(251, 218, 32, 0.3);">
                        <i class="fas fa-building" style="font-size: 2.5rem; color: #fbda20;"></i>
                    </div>
                </div>

                <h1 class="text-white font-weight-bolder mb-3" style="font-size: 3.2rem; line-height: 1.2; letter-spacing: -0.5px;">
                    Nuestras Instalaciones
                </h1>
                <p class="text-white mb-4" style="font-size: 1.25rem; opacity: 0.9; max-width: 700px; margin: 0 auto;">
                    Descubre los espacios que hacen de nuestro campus un lugar único para crecer, aprender y servir
                </p>

                <div class="d-flex gap-3 flex-wrap justify-content-center align-items-center">
                    <span class="badge px-4 py-2" style="background: rgba(251, 218, 32, 0.2); color: #fbda20; border: 1px solid rgba(251, 218, 32, 0.4); font-weight: 600; font-size: 0.95rem;">
                        <i class="fas fa-map-marked-alt me-2"></i><?php echo count($instalaciones); ?> Espacios Disponibles
                    </span>
                    <span class="badge px-4 py-2" style="background: rgba(255, 255, 255, 0.1); color: white; font-weight: 600; font-size: 0.95rem; backdrop-filter: blur(10px);">
                        <i class="fas fa-clock me-2"></i>Tour Virtual del Campus
                    </span>
                </div>

                <!-- Buscador integrado en el header -->
                <?php if (!empty($instalaciones)): ?>
                <div class="mt-5">
                    <div class="position-relative d-inline-block" style="width: 100%; max-width: 500px;">
                        <input type="text" id="buscador" class="form-control form-control-lg px-4 py-3"
                            placeholder="Buscar instalación..."
                            style="border-radius: 50px; border: none; background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); box-shadow: 0 10px 40px rgba(0,0,0,0.2); padding-left: 50px;">
                        <i class="fas fa-search position-absolute" style="left: 20px; top: 50%; transform: translateY(-50%); color: #8392ab; font-size: 1.1rem;"></i>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Wave separador -->
    <div class="position-absolute bottom-0 start-0 w-100" style="transform: translateY(1px);">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" style="display: block;">
            <path fill="#f8f9fa" d="M0,32L80,37.3C160,43,320,53,480,53.3C640,53,800,43,960,42.7C1120,43,1280,53,1360,58.7L1440,64L1440,80L1360,80C1280,80,1120,80,960,80C800,80,640,80,480,80C320,80,160,80,80,80L0,80Z"/>
        </svg>
    </div>
</div>

<main class="bg-gray-100 py-5">
    <div class="container">
        <?php if (empty($instalaciones)): ?>
            <div class="text-center py-5">
                <div class="icon icon-shape shadow mx-auto mb-4" style="width: 120px; height: 120px; background: linear-gradient(135deg, #2c3e50 0%, #3a5167 100%); border-radius: 20px;">
                    <i class="fas fa-building text-white opacity-10" style="font-size: 4rem; line-height: 120px;"></i>
                </div>
                <h4 class="text-muted">No hay instalaciones disponibles por el momento</h4>
                <p class="text-secondary">Pronto tendremos información sobre nuestras instalaciones</p>
            </div>
        <?php else: ?>
            <!-- Grid de Instalaciones - Estilo Masonry/Pinterest -->
            <div class="row g-4" id="listaInstalaciones">
                <?php foreach ($instalaciones as $index => $inst):
                    // Alturas variables para efecto masonry
                    $alturas = [450, 500, 550];
                    $altura = $alturas[$index % 3];
                ?>
                <div class="col-sm-6 col-lg-4 instalacion-item" data-nombre="<?php echo strtolower($inst['NOMBRE']); ?>">
                    <div class="card border-0 shadow-lg overflow-hidden h-100 instalacion-card"
                         style="transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); border-radius: 16px;">

                        <!-- Imagen de la instalación -->
                        <div class="position-relative instalacion-imagen" style="height: <?php echo $altura; ?>px; overflow: hidden;">
                            <?php if (!empty($inst['IMAGEN_URL'])): ?>
                                <img src="<?php echo $siteURL . htmlspecialchars($inst['IMAGEN_URL']); ?>"
                                     class="w-100 h-100"
                                     style="object-fit: cover; transition: transform 0.6s ease;"
                                     alt="<?php echo htmlspecialchars($inst['NOMBRE']); ?>">
                            <?php else: ?>
                                <!-- Gradiente de respaldo -->
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center"
                                     style="background: linear-gradient(135deg, #2c3e50 0%, #3a5167 50%, #2c3e50 100%);">
                                    <i class="fas fa-building" style="font-size: 6rem; color: #fbda20; opacity: 0.3;"></i>
                                </div>
                            <?php endif; ?>

                            <!-- Overlay con gradiente -->
                            <div class="position-absolute top-0 start-0 w-100 h-100 instalacion-overlay"
                                 style="background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.3) 50%, rgba(44,62,80,0.9) 100%); transition: all 0.4s ease;"></div>

                            <!-- Información flotante -->
                            <div class="position-absolute bottom-0 start-0 w-100 p-4" style="z-index: 2;">
                                <h4 class="text-white font-weight-bolder mb-2" style="font-size: 1.5rem; line-height: 1.3;">
                                    <?php echo htmlspecialchars($inst['NOMBRE']); ?>
                                </h4>

                                <?php if (!empty($inst['UBICACION'])): ?>
                                <p class="mb-3" style="color: #fbda20; font-size: 0.9rem; font-weight: 600;">
                                    <i class="fas fa-map-marker-alt me-1"></i><?php echo htmlspecialchars($inst['UBICACION']); ?>
                                </p>
                                <?php endif; ?>

                                <!-- Info rápida con iconos -->
                                <div class="d-flex gap-3 mb-3 flex-wrap">
                                    <?php if (!empty($inst['CAPACIDAD'])): ?>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                             style="width: 32px; height: 32px; background: rgba(251, 218, 32, 0.2); backdrop-filter: blur(10px);">
                                            <i class="fas fa-users" style="font-size: 0.75rem; color: #fbda20;"></i>
                                        </div>
                                        <span class="text-white" style="font-size: 0.85rem; font-weight: 500;">
                                            <?php echo htmlspecialchars($inst['CAPACIDAD']); ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>

                                    <?php if (!empty($inst['HORARIO'])): ?>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                             style="width: 32px; height: 32px; background: rgba(251, 218, 32, 0.2); backdrop-filter: blur(10px);">
                                            <i class="fas fa-clock" style="font-size: 0.75rem; color: #fbda20;"></i>
                                        </div>
                                        <span class="text-white" style="font-size: 0.85rem; font-weight: 500;">
                                            <?php echo htmlspecialchars($inst['HORARIO']); ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Botón de ver detalles -->
                                <a href="<?php echo $portalURL; ?>instalacion/<?php echo $inst['ID']; ?>"
                                   class="btn w-100 font-weight-bold mb-0 shadow-sm btn-instalacion"
                                   style="backdrop-filter: blur(10px);">
                                    Explorar instalación <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Mensaje sin resultados -->
            <div class="text-center py-5" id="sinResultados" style="display:none;">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No se encontraron instalaciones con ese criterio</h5>
                <p class="text-secondary">Intenta con otro término de búsqueda</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<!-- Estilos para instalaciones -->
<style>
    /* Hover effects para las tarjetas */
    .instalacion-card:hover {
        transform: translateY(-12px) !important;
        box-shadow: 0 25px 50px rgba(44, 62, 80, 0.3) !important;
    }

    .instalacion-card:hover .instalacion-imagen img {
        transform: scale(1.1);
    }

    .instalacion-card:hover .instalacion-overlay {
        background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.4) 50%, rgba(44,62,80,0.95) 100%) !important;
    }

    /* Botón con colores de campus */
    .btn-instalacion {
        background: linear-gradient(135deg, #fbda20 0%, #f5c842 100%);
        color: #2c3e50;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        font-weight: 700;
        border-radius: 8px;
    }

    .btn-instalacion:hover {
        background: white;
        color: #fbda20;
        border: 2px solid #fbda20;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(251, 218, 32, 0.4);
    }

    /* Animación de entrada */
    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(30px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .instalacion-item {
        animation: fadeInScale 0.6s ease forwards;
        opacity: 0;
    }

    .instalacion-item:nth-child(1) { animation-delay: 0.1s; }
    .instalacion-item:nth-child(2) { animation-delay: 0.2s; }
    .instalacion-item:nth-child(3) { animation-delay: 0.3s; }
    .instalacion-item:nth-child(4) { animation-delay: 0.4s; }
    .instalacion-item:nth-child(5) { animation-delay: 0.5s; }
    .instalacion-item:nth-child(6) { animation-delay: 0.6s; }
    .instalacion-item:nth-child(n+7) { animation-delay: 0.7s; }

    /* Estilos del buscador */
    #buscador:focus {
        outline: none;
        box-shadow: 0 15px 50px rgba(251, 218, 32, 0.25) !important;
        background: white !important;
    }
</style>

<script>
// Buscador de instalaciones
document.getElementById('buscador')?.addEventListener('input', function() {
    const query = this.value.toLowerCase().trim();
    const items = document.querySelectorAll('.instalacion-item');
    let visiblesCount = 0;

    items.forEach(item => {
        const nombre = item.dataset.nombre;
        if (nombre.includes(query)) {
            item.style.display = '';
            visiblesCount++;
        } else {
            item.style.display = 'none';
        }
    });

    document.getElementById('sinResultados').style.display = visiblesCount === 0 ? '' : 'none';
});

// Log de carga
document.addEventListener('DOMContentLoaded', function() {
    console.log('Página de instalaciones cargada - Tour Virtual del Campus');
});
</script>

<?php include('assets/php/footer.php'); ?>
