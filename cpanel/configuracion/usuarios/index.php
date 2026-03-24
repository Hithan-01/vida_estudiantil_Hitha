<?php
// Redirigir a la ubicación correcta
require_once(__DIR__ . '/../../assets/php/template.php');
$temp = new Template();
header('Location: ' . $temp->siteURL . 'pages/configuracion/usuarios/');
exit();
?>
