<?php
header('Content-Type: application/json');
include('../db.php');

$db = new Conexion();
$id_anuario = isset($_POST['id']) ? intval($_POST['id']) : 0;
$credential  = isset($_POST['credential']) ? trim($_POST['credential']) : '';

if ($id_anuario === 0) {
    echo json_encode(['success' => false, 'message' => 'ID inválido']);
    exit();
}

if (empty($credential)) {
    echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión con Google para dar like.', 'requiere_google' => true]);
    exit();
}

// ── Verificar token de Google ──
$tokenInfo = @file_get_contents('https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($credential));
if ($tokenInfo === false) {
    // Fallback: decodificar JWT localmente para obtener el sub (sin verificar firma)
    $parts = explode('.', $credential);
    if (count($parts) !== 3) {
        echo json_encode(['success' => false, 'message' => 'Token inválido', 'token_invalido' => true]);
        exit();
    }
    $payload = json_decode(base64_decode(str_pad(strtr($parts[1], '-_', '+/'), strlen($parts[1]) % 4 == 0 ? strlen($parts[1]) : strlen($parts[1]) + 4 - strlen($parts[1]) % 4, '=', STR_PAD_RIGHT)), true);
} else {
    $payload = json_decode($tokenInfo, true);
}

if (empty($payload) || !empty($payload['error']) || empty($payload['sub'])) {
    echo json_encode(['success' => false, 'message' => 'Token de Google inválido o expirado.', 'token_invalido' => true]);
    exit();
}

$google_sub   = $db->real_escape_string($payload['sub']);         // ID único de Google
$google_email = $db->real_escape_string($payload['email'] ?? '');
$google_name  = $payload['name'] ?? ($payload['email'] ?? 'Usuario');
$identifier   = 'g_' . $google_sub; // prefijo g_ para diferenciar de matrículas reales

// ── Verificar si ya dio like ──
$check = $db->query("SELECT ID FROM VRE_ANUARIOS_LIKES WHERE ID_ANUARIO = $id_anuario AND MATRICULA = '$identifier'");
if ($check && $db->rows($check) > 0) {
    $cnt = $db->recorrer($db->query("SELECT LIKES FROM VRE_ANUARIOS WHERE ID = $id_anuario"));
    echo json_encode(['success' => false, 'ya_dio_like' => true, 'likes' => (int)($cnt['LIKES'] ?? 0), 'message' => 'Ya diste like a este anuario']);
    exit();
}

// ── Registrar like ──
$ip = $db->real_escape_string($_SERVER['REMOTE_ADDR']);
$db->query("INSERT INTO VRE_ANUARIOS_LIKES (ID_ANUARIO, MATRICULA, IP) VALUES ($id_anuario, '$identifier', '$ip')");
$db->query("UPDATE VRE_ANUARIOS SET LIKES = LIKES + 1 WHERE ID = $id_anuario");

$cnt = $db->recorrer($db->query("SELECT LIKES FROM VRE_ANUARIOS WHERE ID = $id_anuario"));
echo json_encode([
    'success' => true,
    'likes'   => (int)($cnt['LIKES'] ?? 0),
    'name'    => $google_name,
    'message' => '¡Gracias por tu like, ' . htmlspecialchars($google_name) . '!'
]);
