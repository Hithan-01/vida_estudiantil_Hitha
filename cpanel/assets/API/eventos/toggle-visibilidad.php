<?php
error_reporting(0);
ini_set('display_errors', 0);

/**
 * API: Toggle visibilidad de evento (campo ACTIVO)
 * Cambia entre S (visible) y N (oculto)
 */

include("../../php/template.php");
header('Content-Type: application/json');

$temp = new Template();
$db = new Conexion();
$info = [];

if (!$temp->validate_session()) {
    $info['success'] = 0;
    $info['message'] = 'Sesión inválida';
    echo json_encode($info);
    exit();
}

if (!$temp->tiene_permiso('eventos', 'editar')) {
    $info['success'] = 0;
    $info['message'] = 'No tienes permiso para cambiar la visibilidad';
    echo json_encode($info);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['id'])) {
        $info['success'] = 0;
        $info['message'] = 'Falta el ID del evento';
        echo json_encode($info);
        exit();
    }

    $id = intval($_POST['id']);

    // Obtener estado actual
    $check = $db->query("SELECT ACTIVO, TITULO FROM VRE_EVENTOS WHERE ID = $id");
    if (!$check || $check->num_rows == 0) {
        $info['success'] = 0;
        $info['message'] = 'Evento no encontrado';
        echo json_encode($info);
        exit();
    }

    $evento = $check->fetch_assoc();
    $estadoActual = $evento['ACTIVO'];
    $titulo = $evento['TITULO'];

    // Toggle: Si es 'S' cambia a 'N', si es 'N' cambia a 'S'
    $nuevoEstado = ($estadoActual == 'S') ? 'N' : 'S';

    // Actualizar
    $sql = $db->query("UPDATE VRE_EVENTOS SET ACTIVO = '$nuevoEstado' WHERE ID = $id");

    if ($sql) {
        $accion = ($nuevoEstado == 'S') ? 'visible' : 'oculto';
        $temp->registrar_auditoria('EVENTOS', 'TOGGLE_VISIBILIDAD', "Evento '$titulo' (ID: $id) cambiado a $accion");

        $info['success'] = 1;
        $info['message'] = ($nuevoEstado == 'S') ? 'Evento ahora es visible en el sitio público' : 'Evento ocultado del sitio público';
        $info['nuevo_estado'] = $nuevoEstado;
    } else {
        $info['success'] = 0;
        $info['message'] = 'Error al cambiar visibilidad: ' . $db->error;
    }
} else {
    $info['success'] = 0;
    $info['message'] = 'Método no permitido. Use POST.';
}

echo json_encode($info);
exit();
