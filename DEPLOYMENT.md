# Guía de Deployment - Vida Estudiantil UM

## 📋 Configuración de URLs

El sistema ahora usa un archivo de configuración centralizado que **detecta automáticamente** si estás en desarrollo (MAMP) o producción.

### Archivo: `config.php`

Este archivo se encuentra en la raíz del proyecto y maneja todas las URLs del sistema.

## 🖥️ Configuración LOCAL (MAMP/XAMPP)

**No necesitas hacer nada** - el sistema detecta automáticamente que estás en localhost y usa:

```php
SITE_URL   = '/vida_estudiantil_Hitha/'
PORTAL_URL = '/vida_estudiantil_Hitha/vidaEstudiantil/'
CPANEL_URL = '/vida_estudiantil_Hitha/cpanel/'
```

## 🌐 Configuración PRODUCCIÓN (Servidor)

Cuando subas el proyecto al servidor, edita el archivo `config.php` líneas 26-28:

### Opción 1: Sitio en la RAÍZ del dominio
Si tu sitio estará en `https://tudominio.com`:

```php
define('SITE_URL', '/');
define('PORTAL_URL', '/vidaEstudiantil/');
define('CPANEL_URL', '/cpanel/');
```

### Opción 2: Sitio en SUBCARPETA
Si tu sitio estará en `https://tudominio.com/vida_estudiantil/`:

```php
define('SITE_URL', '/vida_estudiantil/');
define('PORTAL_URL', SITE_URL . 'vidaEstudiantil/');
define('CPANEL_URL', SITE_URL . 'cpanel/');
```

## 🚀 Pasos para Subir al Servidor

1. **Sube todos los archivos** al servidor vía FTP/cPanel
2. **Edita `config.php`** (líneas 26-28) según dónde esté alojado
3. **Configura la base de datos** en `cpanel/assets/API/db.php`:
   - Cambia el host (probablemente `localhost`)
   - Cambia usuario y contraseña de MySQL
   - Cambia nombre de la base de datos

4. **Importa la base de datos** usando phpMyAdmin o similar

5. **Verifica permisos** de carpetas:
   ```bash
   chmod 755 cpanel/assets/uploads/
   chmod 755 cpanel/assets/uploads/clubes/
   chmod 755 cpanel/assets/uploads/eventos/
   chmod 755 cpanel/assets/uploads/instalaciones/
   ```

## ✅ Verificación

Después del deployment, verifica que funcionen:

- ✅ Portal público: `tudominio.com/vidaEstudiantil/`
- ✅ Cpanel: `tudominio.com/cpanel/`
- ✅ Las imágenes se muestran correctamente
- ✅ Los enlaces funcionan

## 🔧 Troubleshooting

### Las imágenes no cargan
- Verifica que `SITE_URL` en `config.php` sea correcto
- Verifica permisos de la carpeta `uploads/`

### Error 404 en todas las páginas
- Verifica que las rutas en `config.php` coincidan con la estructura de tu servidor
- Si usas subcarpeta, asegúrate de incluir el `/` inicial y final

### Los estilos CSS no cargan
- Verifica que `PORTAL_URL` apunte correctamente a la carpeta `vidaEstudiantil/`
- Revisa la consola del navegador (F12) para ver errores

## 📝 Archivos Importantes

- `config.php` - Configuración de URLs (EDITAR para producción)
- `cpanel/assets/API/db.php` - Configuración de base de datos (EDITAR para producción)
- `cpanel/assets/php/template.php` - Clase Template del cpanel (usa config.php automáticamente)
- `vidaEstudiantil/assets/php/header.php` - Header del portal
- `.htaccess` - Configuración Apache (si aplica)

## 🗑️ Archivos .bak (Backups)

Los archivos `.bak` son copias de seguridad creadas durante la actualización:

```
club.php.bak (9.3K)
clubes.php.bak (9.7K)
deporte.php.bak (5.5K)
eventos.php.bak (7.1K)
index.php.bak (28K)
instalacion.php.bak (6.0K)
instalaciones.php.bak (15K)
ministerio.php.bak (7.0K)
ministerios.php.bak (12K)
```

**Para eliminarlos:**
```bash
cd vidaEstudiantil
./limpiar_backups.sh
```

⚠️ **IMPORTANTE:** NO subas los archivos .bak al servidor de producción

## 🔐 Seguridad

Antes de subir a producción:

1. Cambia las credenciales de base de datos
2. Asegúrate que `mostrarErrores = false` en `db.php`
3. Cambia el `GOOGLE_CLIENT_ID` en `header.php` si usas uno diferente
4. No subas archivos `.bak` al servidor

---

**Nota:** Los archivos `.bak` son respaldos automáticos creados durante la actualización. Puedes eliminarlos cuando estés seguro que todo funciona correctamente.
