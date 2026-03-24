<?php
class Conexion extends mysqli {
    public $mostrarErrores = TRUE;

    public function __construct(){
        // Detectar ambiente (local vs producción)
        $is_local = (
            $_SERVER['HTTP_HOST'] === 'localhost' ||
            $_SERVER['HTTP_HOST'] === 'localhost:8888' ||
            strpos($_SERVER['HTTP_HOST'], 'localhost:') === 0
        );

        if ($is_local) {
            // CONFIGURACIÓN LOCAL (MAMP)
            parent::__construct('localhost','root','root','pruebasumadmin',8889);
        } else {
            // CONFIGURACIÓN PRODUCCIÓN (VPS)
            parent::__construct('localhost','vidaestudiantil','VidaUM2026Secure','vida_estudiantil');
        }

        if ($this->connect_errno) {
            die("❌ Error de conexión: " . $this->connect_error);
        }
    }

    public function recorrer($y){
        return mysqli_fetch_array($y);
    }

    public function rows($y){
        return mysqli_num_rows($y);
    }
}

function security() {
    if (isset($_COOKIE['system_name']) && isset($_COOKIE["system_token"])) {
        $db = new Conexion();
        $cad = "SELECT * FROM SYSTEM_USUARIOS
                WHERE ACTIVO = 'S'
                AND NOMBRE = '" . $db->real_escape_string($_COOKIE['system_name']) . "'
                AND TOKEN = '" . $db->real_escape_string($_COOKIE['system_token']) . "'";
        $sql = $db->query($cad);
        return $db->rows($sql) > 0;
    } else {
        return false;
    }
}
?>
