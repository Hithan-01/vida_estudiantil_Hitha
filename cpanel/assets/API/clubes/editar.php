<?php
include("../../php/template.php");

header('Content-Type: application/json');
$temp = new Template();
$db = new Conexion();
$info = [];

// Validar sesión
if (!$temp->validate_session()) {
    $info['success'] = 0;
    $info['message'] = 'Sesión inválida';
    echo json_encode($info);
    exit();
}

// Validar permiso
if (!$temp->tiene_permiso('clubes', 'editar')) {
    $info['success'] = 0;
    $info['message'] = 'No tienes permiso para editar clubes';
    echo json_encode($info);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar ID
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        $info['success'] = 0;
        $info['message'] = 'ID del club no proporcionado';
        echo json_encode($info);
        exit();
    }

    $id = intval($_POST['id']);

    // Recibir datos (sin campos de imagen, ahora usa VRE_GALERIA)
    $nombre = $db->real_escape_string($_POST['nombre'] ?? '');
    $descripcion = $db->real_escape_string($_POST['descripcion'] ?? '');
    $objetivo = $db->real_escape_string($_POST['objetivo'] ?? '');
    $requisitos = $db->real_escape_string($_POST['requisitos'] ?? '');
    $beneficios = $db->real_escape_string($_POST['beneficios'] ?? '');
    $horario = $db->real_escape_string($_POST['horario'] ?? '');
    $dia_reunion = $db->real_escape_string($_POST['dia_reunion'] ?? '');
    $lugar = $db->real_escape_string($_POST['lugar'] ?? '');
    $cupo_maximo = isset($_POST['cupo_maximo']) ? intval($_POST['cupo_maximo']) : null;
    $cupo_actual = isset($_POST['cupo_actual']) ? intval($_POST['cupo_actual']) : 0;
    $responsable_nombre = $db->real_escape_string($_POST['responsable_nombre'] ?? '');
    $responsable_contacto = $db->real_escape_string($_POST['responsable_contacto'] ?? '');
    $email = $db->real_escape_string($_POST['email'] ?? '');
    $telefono = $db->real_escape_string($_POST['telefono'] ?? '');
    $director_usuario = isset($_POST['director_usuario']) ? intval($_POST['director_usuario']) : null;
    $orden = isset($_POST['orden']) ? intval($_POST['orden']) : 0;
    $activo = $_POST['activo'] ?? 'S';

    // Validar campos obligatorios
    if (empty($nombre)) {
        $info['success'] = 0;
        $info['message'] = 'El nombre del club es obligatorio';
        echo json_encode($info);
        exit();
    }

    // Obtener datos actuales del club para saber si hay imagen anterior
    $check = $db->query("SELECT IMAGEN_URL FROM VRE_CLUBES WHERE ID = $id");
    if (!$check || $check->num_rows == 0) {
        $info['success'] = 0;
        $info['message'] = 'Club no encontrado';
        echo json_encode($info);
        exit();
    }
    $clubActual = $check->fetch_assoc();

    // Procesar nueva imagen principal si se subió
    $nuevaImagen = null;
    if (isset($_FILES['imagen_principal']) && $_FILES['imagen_principal']['error'] === UPLOAD_ERR_OK) {
        $archivo = $_FILES['imagen_principal'];

        // Validar tipo de archivo
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($archivo['type'], $tiposPermitidos)) {
            $info['success'] = 0;
            $info['message'] = 'Formato de imagen no válido. Solo JPG, PNG, GIF, WEBP.';
            echo json_encode($info);
            exit();
        }

        // Validar tamaño (máx 5MB)
        if ($archivo['size'] > 5 * 1024 * 1024) {
            $info['success'] = 0;
            $info['message'] = 'La imagen no puede superar los 5MB';
            echo json_encode($info);
            exit();
        }

        // Generar nombre único
        $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        $nombreArchivo = 'club_' . uniqid() . '_' . time() . '.' . $extension;
        $directorioDestino = '../../uploads/clubes/';

        // Crear directorio si no existe
        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0755, true);
        }

        $rutaCompleta = $directorioDestino . $nombreArchivo;

        // Mover archivo
        if (move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
            // Eliminar imagen anterior si existe
            if (!empty($clubActual['IMAGEN_URL'])) {
                $imagenAnterior = '../../' . $clubActual['IMAGEN_URL'];
                if (file_exists($imagenAnterior)) {
                    unlink($imagenAnterior);
                }
            }

            $nuevaImagen = 'assets/uploads/clubes/' . $nombreArchivo;
        }
    }

    // Preparar redes sociales
    $redes_sociales = isset($_POST['redes_sociales']) ? json_encode($_POST['redes_sociales']) : null;

    try {
        // Construir query UPDATE
        $updates = [
            "NOMBRE = '$nombre'",
            "DESCRIPCION = '$descripcion'",
            "OBJETIVO = '$objetivo'",
            "REQUISITOS = '$requisitos'",
            "BENEFICIOS = '$beneficios'",
            "HORARIO = '$horario'",
            "DIA_REUNION = '$dia_reunion'",
            "LUGAR = '$lugar'",
            "CUPO_MAXIMO = " . ($cupo_maximo ? $cupo_maximo : 'NULL'),
            "CUPO_ACTUAL = $cupo_actual",
            "RESPONSABLE_NOMBRE = '$responsable_nombre'",
            "RESPONSABLE_CONTACTO = '$responsable_contacto'",
            "EMAIL = '$email'",
            "TELEFONO = '$telefono'",
            "ID_DIRECTOR_USUARIO = " . ($director_usuario ? $director_usuario : 'NULL'),
            "REDES_SOCIALES = " . ($redes_sociales ? "'$redes_sociales'" : 'NULL'),
            "ACTIVO = '$activo'",
            "ORDEN = $orden"
        ];

        // Agregar imagen si se subió una nueva
        if ($nuevaImagen !== null) {
            $updates[] = "IMAGEN_URL = '$nuevaImagen'";
        }

        $cad = "UPDATE VRE_CLUBES SET " . implode(", ", $updates) . " WHERE ID = $id";

        $sql = $db->query($cad);

        if ($sql) {
            // Registrar en auditoría
            $temp->registrar_auditoria('CLUBES', 'EDITAR', "Club editado: $nombre (ID: $id)");

            $info['success'] = 1;
            $info['message'] = 'Club actualizado exitosamente';
        } else {
            $info['success'] = 0;
            $info['message'] = 'Error al actualizar el club';
            if ($db->mostrarErrores) {
                $info['query'] = $cad;
                $info['error'] = $db->error;
            }
        }

    } catch (Exception $e) {
        $info['success'] = 0;
        $info['message'] = 'Error al actualizar el club';
        if ($db->mostrarErrores) {
            $info['error'] = $e->getMessage();
        }
    }

} else {
    $info['success'] = 0;
    $info['message'] = 'Método no permitido';
}

echo json_encode($info);
?>