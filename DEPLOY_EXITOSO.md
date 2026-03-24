# ✅ Deploy Exitoso - Vida Estudiantil VPS

**Fecha:** 17 de Marzo, 2026
**Estado:** ✅ COMPLETADO Y FUNCIONAL

---

## 🎉 URLs del Sitio en Producción

### Portal Público:
```
http://216.238.79.66/vidaEstudiantil/
```

### Cpanel (Administración):
```
http://216.238.79.66/cpanel/login.php
```
O simplemente:
```
http://216.238.79.66/cpanel/
```
*(Redirige automáticamente al login)*

---

## 📊 Resumen del Deploy

### ✅ Software Instalado:
- **PHP:** 8.1 con extensiones (mysqli, mbstring, xml, curl, gd, zip)
- **MySQL:** 8.0.45
- **Nginx:** 1.18.0 (ya estaba instalado)
- **Certificado SSL:** Let's Encrypt (preexistente)

### ✅ Base de Datos:
- **Nombre:** `vida_estudiantil`
- **Usuario:** `vidaestudiantil`
- **Password:** `VidaUM2026Secure`
- **Tablas importadas:** 42 tablas
- **Datos migrados:** ✅ Completo desde MAMP

### ✅ Archivos Subidos:
- **Total:** 1,995 archivos
- **Ubicación:** `/home/linuxuser/vida_estudiantil_Hitha/`
- **Permisos:** Configurados correctamente (755/775, www-data)

---

## 🔧 Configuración Automática de Ambiente

Tu proyecto ahora detecta automáticamente si está en MAMP o en producción:

### `config.php`:
```php
// Detecta automáticamente el ambiente
$is_local = (
    $_SERVER['HTTP_HOST'] === 'localhost' ||
    $_SERVER['HTTP_HOST'] === 'localhost:8888' ||
    strpos($_SERVER['HTTP_HOST'], 'localhost:') === 0
);

if ($is_local) {
    // MAMP
    define('SITE_URL', '/vida_estudiantil_Hitha/');
} else {
    // PRODUCCIÓN
    define('SITE_URL', '/');
}
```

### `db.php`:
```php
if ($is_local) {
    // MAMP: localhost:8889, user: root, db: pruebasumadmin
} else {
    // VPS: localhost, user: vidaestudiantil, db: vida_estudiantil
}
```

---

## 🐛 Problemas Resueltos

### ❌ Error: "Table VRE_BANNERS doesn't exist"
**Causa:** PHP-FPM estaba cacheando versión antigua de `db.php` con credenciales de MAMP
**Solución:** Reinicio de PHP-FPM para limpiar opcache
**Comando usado:**
```bash
sudo systemctl restart php8.1-fpm
```

### ❌ Error: 404 en /cpanel/login/
**Causa:** La URL correcta es `/cpanel/login.php` no `/cpanel/login/`
**Solución:** Nginx configurado para manejar correctamente ambas rutas

---

## 📂 Estructura de URLs

| Tipo | Local (MAMP) | Producción (VPS) |
|------|--------------|------------------|
| **Raíz** | `/vida_estudiantil_Hitha/` | `/` |
| **Portal** | `/vida_estudiantil_Hitha/vidaEstudiantil/` | `/vidaEstudiantil/` |
| **Cpanel** | `/vida_estudiantil_Hitha/cpanel/` | `/cpanel/` |

---

## 🔐 Credenciales de Acceso

### SSH al VPS:
```bash
ssh linuxuser@216.238.79.66
# Password: [fP5%74YxQ_MrA.s
```

### MySQL en VPS:
```bash
mysql -u vidaestudiantil -pVidaUM2026Secure vida_estudiantil
```

### Cpanel del Sistema:
- Usuario: *(El que tengas configurado en SYSTEM_USUARIOS)*
- URL: `http://216.238.79.66/cpanel/login.php`

---

## 🚀 Comandos Útiles de Mantenimiento

### Reiniciar Servicios:
```bash
sudo systemctl restart nginx
sudo systemctl restart php8.1-fpm
sudo systemctl restart mysql
```

### Ver Logs de Errores:
```bash
# Nginx
sudo tail -f /var/log/nginx/vida-estudiantil-error.log

# PHP-FPM
sudo tail -f /var/log/php8.1-fpm.log
```

### Backup de Base de Datos:
```bash
mysqldump -u vidaestudiantil -pVidaUM2026Secure vida_estudiantil > backup_$(date +%Y%m%d_%H%M%S).sql
```

### Ver Estado de Servicios:
```bash
sudo systemctl status nginx
sudo systemctl status php8.1-fpm
sudo systemctl status mysql
```

---

## 🔄 Cómo Subir Cambios Futuros

### Opción 1: Usando SCP (archivos individuales)
```bash
# Desde tu Mac
cd /Applications/MAMP/htdocs/vida_estudiantil_Hitha
scp -r archivo_o_carpeta linuxuser@216.238.79.66:/home/linuxuser/vida_estudiantil_Hitha/

# En el VPS (ajustar permisos)
ssh linuxuser@216.238.79.66
sudo chown -R www-data:www-data /home/linuxuser/vida_estudiantil_Hitha/
```

### Opción 2: Usando Git (recomendado)
```bash
# Configurar Git (una vez)
cd /Applications/MAMP/htdocs/vida_estudiantil_Hitha
git init
git remote add origin https://github.com/TU_USUARIO/vida-estudiantil.git

# Para subir cambios
git add .
git commit -m "Descripción de cambios"
git push

# En el VPS
ssh linuxuser@216.238.79.66
cd /home/linuxuser/vida_estudiantil_Hitha
sudo git pull
sudo chown -R www-data:www-data .
```

### Opción 3: Cambios Solo en Base de Datos
```bash
# Exportar desde MAMP
mysqldump -h localhost -P 8889 -u root -proot pruebasumadmin > cambios.sql

# Subir al VPS
scp cambios.sql linuxuser@216.238.79.66:/tmp/

# Importar en VPS
ssh linuxuser@216.238.79.66
mysql -u vidaestudiantil -pVidaUM2026Secure vida_estudiantil < /tmp/cambios.sql
```

---

## ⚠️ Notas Importantes

1. **Siempre que hagas cambios en PHP:**
   ```bash
   sudo systemctl restart php8.1-fpm
   ```
   Esto limpia el cache de PHP y aplica los cambios inmediatamente.

2. **Permisos de archivos:**
   - Carpetas: `755` (lectura/ejecución para todos, escritura solo owner)
   - Archivos: `644` (lectura para todos, escritura solo owner)
   - Uploads: `775` (lectura/escritura para www-data)

3. **URLs en el código:**
   - NO uses rutas hardcoded
   - USA las constantes: `SITE_URL`, `PORTAL_URL`, `CPANEL_URL`
   - El sistema detecta automáticamente el ambiente

4. **Credenciales en código:**
   - NUNCA subas `db.php` con credenciales hardcoded
   - Usa siempre la detección automática de ambiente
   - Las credenciales de producción ya están en `db.php`

---

## ✅ Checklist de Verificación

- [✅] PHP 8.1 instalado y funcionando
- [✅] MySQL 8.0 instalado y corriendo
- [✅] Base de datos importada (42 tablas)
- [✅] Archivos subidos (1,995 archivos)
- [✅] `config.php` con detección de ambiente
- [✅] `db.php` con credenciales de producción
- [✅] `template.php` con detección de ambiente
- [✅] Permisos de archivos configurados
- [✅] Nginx configurado y reiniciado
- [✅] Portal público funciona: ✅ http://216.238.79.66/vidaEstudiantil/
- [✅] Cpanel funciona: ✅ http://216.238.79.66/cpanel/
- [✅] Sistema de videos hero desde base de datos
- [✅] Archivos de test eliminados

---

## 🎓 Diferencias MAMP vs VPS

| Aspecto | MAMP (Local) | VPS (Producción) |
|---------|--------------|------------------|
| **Servidor Web** | Apache | Nginx |
| **Puerto MySQL** | 8889 | 3306 (default) |
| **Usuario MySQL** | root | vidaestudiantil |
| **Base de Datos** | pruebasumadmin | vida_estudiantil |
| **Path** | `/Applications/MAMP/htdocs/` | `/home/linuxuser/` |
| **URLs** | Con carpeta (`/vida_estudiantil_Hitha/`) | Sin carpeta (`/`) |
| **Case Sensitivity** | Insensible (macOS) | Sensible (Linux) |

---

## 🎉 Conclusión

Tu sitio **Vida Estudiantil** está completamente funcional en el VPS. Puedes seguir desarrollando en MAMP y cuando quieras subir cambios, usa una de las opciones de la sección "Cómo Subir Cambios Futuros".

**¡Deploy exitoso! 🚀**
