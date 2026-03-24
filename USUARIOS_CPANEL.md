# 👥 Usuarios del Cpanel - Vida Estudiantil

**Fecha:** 17 de Marzo, 2026

---

## 🔐 Credenciales de Acceso

### URL del Cpanel:
```
http://216.238.79.66/cpanel/login.php
```

---

## 📋 Usuarios Disponibles

| Usuario | Password | Email | Rol/Categoría | Estado |
|---------|----------|-------|---------------|--------|
| **Suriel** | `1234` | - | ID_CAT: 1 | ✅ Activo |
| **admin** | `6wfncSZF` | - | ID_CAT: 2 | ✅ Activo |
| **Joshua** | `12345678` | starrynight@gmail.com | ID_CAT: 11 | ✅ Activo |
| **Michael** | `12345678` | 1220593@alumno.um.edu.mx | ID_CAT: 8 | ✅ Activo |
| **COBB** | `LosGuiasUM2024!!` | - | ID_CAT: 1 | ✅ Activo |
| **JESSICA** | `1234` | - | ID_CAT: 2 | ✅ Activo |
| **director.guias** | `12345678` | Crispinhithan@gmail.com | ID_CAT: 8, Club: 3 | ✅ Activo |

---

## 🔑 Usuarios Recomendados para Probar

### **Opción 1 - Admin Principal:**
```
Usuario: admin
Password: 6wfncSZF
```
Este parece ser el usuario administrador principal.

### **Opción 2 - Usuario Simple:**
```
Usuario: Suriel
Password: 1234
```
Usuario con categoría 1, fácil de recordar.

### **Opción 3 - Director:**
```
Usuario: director.guias
Password: 12345678
```
Usuario con club asignado (ID: 3).

---

## ⚠️ Notas de Seguridad

1. **Passwords débiles detectados:**
   - `1234` - Usado por Suriel y JESSICA
   - `12345678` - Usado por Joshua, Michael y director.guias

2. **Recomendación:**
   Una vez que entres al sistema, cambia estos passwords por contraseñas más seguras.

3. **Hasheado:**
   Los passwords están almacenados en MD5 en la base de datos (no es el método más seguro actualmente).

---

## 🔍 Información Técnica

### Tabla en Base de Datos:
```sql
SELECT NOMBRE, EMAIL, ACTIVO FROM system_usuarios WHERE ACTIVO = 'S';
```

### Campos de la tabla `system_usuarios`:
- **ID** - ID único del usuario
- **NOMBRE** - Nombre de usuario para login
- **PASS** - Password hasheado en MD5
- **EMAIL** - Email del usuario
- **ID_CAT** - ID de categoría/rol
- **ID_CLUB_ASIGNADO** - Club asignado (si aplica)
- **ID_MINISTERIO_ASIGNADO** - Ministerio asignado (si aplica)
- **ACTIVO** - 'S' = Activo, 'N' = Inactivo
- **PRIMER_LOGIN** - 'S' si ya hizo primer login, 'N' si no
- **TOKEN** - Token de sesión
- **ULTIMO_ACCESO** - Fecha/hora del último acceso
- **FECHA_CREACION** - Fecha de creación del usuario

---

## 🚀 Últimos Accesos

| Usuario | Último Acceso | Token Activo |
|---------|---------------|--------------|
| Suriel | 2026-03-17 09:18:11 | ✅ Sí |
| director.guias | 2026-03-12 14:45:10 | ✅ Sí |
| admin | - | ❌ No |
| Joshua | - | ✅ Sí |
| Michael | - | ✅ Sí |
| COBB | - | ❌ No |
| JESSICA | - | ❌ No |

---

## 📝 Para Crear Nuevos Usuarios

Desde el cpanel, busca la sección de usuarios/administración y podrás crear nuevos usuarios con contraseñas más seguras.

---

**¡Ya puedes entrar al cpanel con cualquiera de estos usuarios! 🎉**
