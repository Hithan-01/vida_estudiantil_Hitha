<?php
/**
 * Proxy PDF — Google Drive sin CORS.
 * Usa drive.usercontent.google.com (URL actual de Google) con manejo de
 * confirmación de virus-scan para archivos grandes.
 */
@ini_set('memory_limit', '512M');
@set_time_limit(180);

$url = $_GET['url'] ?? '';

if (empty($url)) { http_response_code(400); exit('URL requerida'); }
if (strpos($url, 'drive.google.com') === false) { http_response_code(403); exit('Solo Google Drive'); }

// Extraer file ID
$fileId = '';
if      (preg_match('#/d/([a-zA-Z0-9_-]+)#',     $url, $m)) $fileId = $m[1];
elseif  (preg_match('#[?&]id=([a-zA-Z0-9_-]+)#', $url, $m)) $fileId = $m[1];

if (empty($fileId)) { http_response_code(400); exit('ID de archivo no encontrado'); }

// URL moderna de descarga de Google Drive
$downloadUrl = "https://drive.usercontent.google.com/download?id={$fileId}&export=download&authuser=0";

if (!function_exists('curl_init')) {
    http_response_code(500);
    exit('cURL no disponible en este servidor');
}

/**
 * Descarga el contenido completo con cURL (sin streaming para poder analizar respuesta).
 */
function driveDownload(string $url): array {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 120,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        CURLOPT_HTTPHEADER     => [
            'Accept: application/pdf,*/*;q=0.8',
            'Accept-Language: es-MX,es;q=0.9,en;q=0.8',
        ],
        CURLOPT_COOKIEFILE     => '',   // habilita manejo de cookies en memoria
        CURLOPT_COOKIEJAR      => '',
        CURLOPT_SSL_VERIFYPEER => true,
    ]);

    $body    = curl_exec($ch);
    $info    = curl_getinfo($ch);
    $err     = curl_error($ch);
    curl_close($ch);

    return ['body' => $body, 'info' => $info, 'error' => $err];
}

// ── Intento 1: descarga directa ──────────────────────────────────────────────
$r = driveDownload($downloadUrl);

if ($r['error']) {
    http_response_code(502);
    exit('Error de red: ' . $r['error']);
}

$body = $r['body'];

// Si ya es un PDF, servir directamente
if (substr($body, 0, 4) === '%PDF') {
    header('Content-Type: application/pdf');
    header('Content-Length: ' . strlen($body));
    header('Cache-Control: private, max-age=3600');
    echo $body;
    exit;
}

// ── Intento 2: Google mostró página de confirmación (virus scan) ──────────────
// Extraer el UUID del formulario de confirmación
$uuid = '';
if (preg_match('/name="uuid"\s+value="([^"]+)"/i', $body, $m)) {
    $uuid = $m[1];
} elseif (preg_match('/[?&]uuid=([a-zA-Z0-9_-]+)/i', $body, $m)) {
    $uuid = $m[1];
} elseif (preg_match('/uuid["\s]*:["\s]*["\']([a-zA-Z0-9_-]+)["\']/', $body, $m)) {
    $uuid = $m[1];
}

if ($uuid) {
    $confirmUrl = "https://drive.usercontent.google.com/download?id={$fileId}&export=download&confirm=t&uuid={$uuid}";
    $r2 = driveDownload($confirmUrl);

    if (!$r2['error'] && substr($r2['body'], 0, 4) === '%PDF') {
        header('Content-Type: application/pdf');
        header('Content-Length: ' . strlen($r2['body']));
        header('Cache-Control: private, max-age=3600');
        echo $r2['body'];
        exit;
    }
}

// ── Intento 3: URL alternativa antigua ───────────────────────────────────────
$fallbackUrl = "https://drive.google.com/uc?export=download&id={$fileId}&confirm=t";
$r3 = driveDownload($fallbackUrl);

if (!$r3['error'] && substr($r3['body'], 0, 4) === '%PDF') {
    header('Content-Type: application/pdf');
    header('Content-Length: ' . strlen($r3['body']));
    header('Cache-Control: private, max-age=3600');
    echo $r3['body'];
    exit;
}

// ── Error final ───────────────────────────────────────────────────────────────
http_response_code(502);
header('Content-Type: text/plain; charset=utf-8');
echo "No se pudo descargar el PDF de Google Drive.\n\n";
echo "Verifica que:\n";
echo "1. El archivo sea PDF (no otro tipo de archivo)\n";
echo "2. El archivo esté compartido como 'Cualquier persona con el enlace puede ver'\n";
echo "3. El enlace de Drive sea válido\n\n";
echo "File ID: {$fileId}\n";