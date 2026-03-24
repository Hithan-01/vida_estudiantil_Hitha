# Cambios: Sistema de Video Hero

## 📋 Resumen

El video de fondo del hero ahora se gestiona desde la **Configuración del Home** en el cpanel, en lugar de archivos locales.

---

## ✅ Cambios Realizados

### 1. **Modificado: `vidaEstudiantil/index.php`**

**ANTES:**
- Leía el video desde archivos locales:
  - `assets/videos/hero.mp4`
  - `assets/videos/hero.webm`
  - `assets/videos/hero-url.txt`

**AHORA:**
- ✅ Carga toda la configuración desde la tabla `VRE_HOME_CONFIG`
- ✅ Lee el video desde:
  - `$homeConfig['hero']['usar_video']` (activar/desactivar)
  - `$homeConfig['hero']['video_url']` (URL de YouTube o MP4)
- ✅ Detecta automáticamente si es YouTube y lo convierte a iframe embed
- ✅ Soporte para URLs directas a archivos MP4

---

### 2. **Deshabilitado: Sistema Antiguo de Video**

Los siguientes archivos fueron renombrados a `.disabled`:

✅ `cpanel/pages/vida-estudiantil/video-hero.php.disabled`
- Página antigua para subir videos locales
- Ya NO está accesible desde el menú

✅ `cpanel/assets/API/vida-estudiantil/video-hero.php.disabled`
- API antigua para manejar uploads
- Ya NO procesa requests

---

## 🎯 Cómo Usar el Nuevo Sistema

### **Configurar el Video desde el Cpanel:**

1. Ve a: `http://localhost:8888/vida_estudiantil_Hitha/cpanel/configuracion/home/`

2. En la pestaña **"Hero Section"**:
   - ✅ Activa el checkbox **"Usar Video de Fondo"**
   - ✅ Pega la URL del video en **"URL del Video"**

3. URLs soportadas:
   - **YouTube:** `https://www.youtube.com/watch?v=VIDEO_ID`
   - **YouTube corto:** `https://youtu.be/VIDEO_ID`
   - **MP4 directo:** `https://ejemplo.com/video.mp4`

4. Haz clic en **"Guardar Todo"**

5. Recarga la página de inicio: `http://localhost:8888/vida_estudiantil_Hitha/vidaEstudiantil/`

---

## 📊 Campos en VRE_HOME_CONFIG

Los siguientes campos controlan el video:

| SECCION | CLAVE | VALOR | DESCRIPCIÓN |
|---------|-------|-------|-------------|
| `hero` | `usar_video` | `0` o `1` | `0` = Usar gradiente, `1` = Usar video |
| `hero` | `video_url` | URL | URL de YouTube o archivo MP4 |

---

## 🔧 Configuración Actual

**Estado del video:**
```bash
# Ver configuración actual
mysql -h localhost -P 8889 -u root -proot pruebasumadmin \
  -e "SELECT CLAVE, VALOR FROM VRE_HOME_CONFIG WHERE SECCION='hero' AND CLAVE IN ('usar_video', 'video_url');"
```

**Archivos antiguos (ya NO se usan):**
- ❌ `assets/videos/hero.mp4` → Ignorado
- ❌ `assets/videos/hero.webm` → Ignorado
- ❌ `assets/videos/hero-url.txt` → Ignorado

Puedes eliminarlos si quieres limpiar espacio:
```bash
rm assets/videos/hero.mp4
rm assets/videos/hero.webm
rm assets/videos/hero-url.txt
```

---

## 🚀 Ventajas del Nuevo Sistema

✅ **Centralizado:** Todo desde una sola página de configuración
✅ **Sin archivos:** No necesitas subir archivos al servidor
✅ **Más rápido:** Videos de YouTube se cargan desde sus CDN
✅ **Fácil de cambiar:** Solo editas la URL y guardas
✅ **Consistente:** Misma interfaz que el resto de configuraciones del home

---

## 🔄 Para Restaurar el Sistema Antiguo (si es necesario)

Si necesitas volver al sistema antiguo:

```bash
# Restaurar archivos
mv video-hero.php.disabled video-hero.php
mv assets/API/vida-estudiantil/video-hero.php.disabled assets/API/vida-estudiantil/video-hero.php

# Revertir cambios en index.php (usar git o backup)
```

---

## ✨ Fecha de Cambio

**17 de Marzo, 2026**
