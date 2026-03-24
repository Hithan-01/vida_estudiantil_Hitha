<?php
header('Content-Type: application/json');
include('../../db.php');

// Log de errores para debugging
error_log("=== UPLOAD PORTADA DEBUG ===");
error_log("FILES: " . print_r($_FILES, true));
error_log("POST: " . print_r($_POST, true));

if (!security()) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

// Validar que se haya enviado un archivo
if (!isset($_FILES['portada'])) {
    echo json_encode([
        'success' => false,
        'message' => 'No se recibió ningún archivo',
        'debug' => [
            'filesEmpty' => empty($_FILES),
            'contentLength' => $_SERVER['CONTENT_LENGTH'] ?? 0,
            'uploadMaxFilesize' => ini_get('upload_max_filesize')
        ]
    ]);
    exit();
}

// Verificar errores de upload
$uploadError = $_FILES['portada']['error'];
if ($uploadError !== UPLOAD_ERR_OK) {
    $errorMessages = [
        UPLOAD_ERR_INI_SIZE => 'El archivo excede el tamaño máximo permitido por PHP',
        UPLOAD_ERR_FORM_SIZE => 'El archivo excede el tamaño máximo del formulario',
        UPLOAD_ERR_PARTIAL => 'El archivo se subió parcialmente',
        UPLOAD_ERR_NO_FILE => 'No se subió ningún archivo',
        UPLOAD_ERR_NO_TMP_DIR => 'Falta la carpeta temporal',
        UPLOAD_ERR_CANT_WRITE => 'Error al escribir el archivo en disco',
        UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la subida'
    ];

    $message = $errorMessages[$uploadError] ?? 'Error desconocido (código: ' . $uploadError . ')';
    error_log("Upload error: " . $message);
    echo json_encode(['success' => false, 'message' => $message]);
    exit();
}

$file = $_FILES['portada'];

// Validar tipo de archivo (imágenes)
$allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Solo se permiten imágenes JPG, PNG o WebP']);
    exit();
}

// Validar tamaño (máximo 10MB)
$maxSize = 10 * 1024 * 1024; // 10MB en bytes
if ($file['size'] > $maxSize) {
    echo json_encode(['success' => false, 'message' => 'La imagen es demasiado grande. Máximo 10MB']);
    exit();
}

// Crear carpeta si no existe
$uploadDir = __DIR__ . '/../../../../uploads/anuarios/portadas/';
error_log("Upload directory: " . $uploadDir);

if (!file_exists($uploadDir)) {
    error_log("Creating upload directory...");
    if (!mkdir($uploadDir, 0755, true)) {
        error_log("Failed to create directory");
        echo json_encode(['success' => false, 'message' => 'Error al crear la carpeta de uploads']);
        exit();
    }
}

// Verificar que la carpeta sea escribible
if (!is_writable($uploadDir)) {
    error_log("Directory is not writable");
    echo json_encode(['success' => false, 'message' => 'La carpeta de uploads no tiene permisos de escritura']);
    exit();
}

// Generar nombre único para el archivo
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$fileName = 'portada_' . time() . '_' . uniqid() . '.' . $extension;
$filePath = $uploadDir . $fileName;

error_log("Target file path: " . $filePath);

// Mover archivo a la carpeta de uploads
if (!move_uploaded_file($file['tmp_name'], $filePath)) {
    $error = error_get_last();
    error_log("move_uploaded_file failed: " . print_r($error, true));
    echo json_encode([
        'success' => false,
        'message' => 'Error al guardar el archivo',
        'debug' => [
            'uploadDir' => $uploadDir,
            'exists' => file_exists($uploadDir),
            'writable' => is_writable($uploadDir)
        ]
    ]);
    exit();
}

error_log("File uploaded successfully: " . $filePath);

// Generar URL del archivo
$fileUrl = '/cpanel/uploads/anuarios/portadas/' . $fileName;

echo json_encode([
    'success' => true,
    'message' => 'Imagen subida correctamente',
    'url' => $fileUrl,
    'fileName' => $fileName
]);
?>
