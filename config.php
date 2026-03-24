<?php
/**
 * Configuración Global - URLs del Sistema
 * Este archivo centraliza las rutas para facilitar el deployment
 */

// Detectar si estamos en localhost (MAMP) o en producción
$is_local = (
    $_SERVER['HTTP_HOST'] === 'localhost' ||
    $_SERVER['HTTP_HOST'] === 'localhost:8888' ||
    $_SERVER['HTTP_HOST'] === '127.0.0.1' ||
    strpos($_SERVER['HTTP_HOST'], 'localhost:') === 0
);

if ($is_local) {
    // ═══════════════════════════════════════════════════════════
    // CONFIGURACIÓN LOCAL (MAMP / XAMPP)
    // ═══════════════════════════════════════════════════════════
    define('SITE_URL', '/vida_estudiantil_Hitha/');
    define('PORTAL_URL', SITE_URL . 'vidaEstudiantil/');
    define('CPANEL_URL', SITE_URL . 'cpanel/');

} else {
    // ═══════════════════════════════════════════════════════════
    // CONFIGURACIÓN PRODUCCIÓN
    // ═══════════════════════════════════════════════════════════
    // Opción 1: Si el sitio está en la raíz del dominio (ej: tudominio.com)
    define('SITE_URL', '/');
    define('PORTAL_URL', '/vidaEstudiantil/');
    define('CPANEL_URL', '/cpanel/');

    // Opción 2: Si el sitio está en una subcarpeta (ej: tudominio.com/vida_estudiantil/)
    // define('SITE_URL', '/vida_estudiantil/');
    // define('PORTAL_URL', SITE_URL . 'vidaEstudiantil/');
    // define('CPANEL_URL', SITE_URL . 'cpanel/');
}

// Variables globales para compatibilidad con código existente
if (!isset($siteURL)) {
    $siteURL = SITE_URL;
}
if (!isset($portalURL)) {
    $portalURL = PORTAL_URL;
}
if (!isset($cpanelURL)) {
    $cpanelURL = CPANEL_URL;
}

// Información del ambiente (útil para debugging)
define('IS_LOCAL', $is_local);
define('BASE_PATH', __DIR__);
?>
