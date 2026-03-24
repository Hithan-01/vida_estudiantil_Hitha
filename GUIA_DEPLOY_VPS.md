# 🚀 Guía de Deploy - Vida Estudiantil VPS

## 📊 Estado Actual de tu VPS

### ✅ **Lo que YA tienes instalado:**
- **SO:** Ubuntu 22.04 LTS
- **Servidor Web:** Nginx ✅ (corriendo en puerto 80 y 443)
- **Base de Datos:** PostgreSQL ✅ (puerto 5432)
- **SSL:** Let's Encrypt (Certbot) ✅
- **Acceso:** SSH con sudo completo ✅
- **Usuario:** `linuxuser`

### ❌ **Lo que FALTA instalar:**
- **PHP** (no está instalado)
- **MySQL/MariaDB** (tienes PostgreSQL, pero tu app usa MySQL)
- **PHP-FPM** (para que Nginx ejecute PHP)
- **Extensiones PHP:** mysqli, mbstring, json

---

## 🎯 **TU SITUACIÓN:**

**Problema:** Tu proyecto usa **MySQL** pero el servidor tiene **PostgreSQL**.

**Opciones:**

### **Opción 1: Instalar MySQL** (Recomendado - Más fácil)
- Instalar MySQL en el VPS
- No tocar código, funciona igual que en MAMP
- Importar tu base de datos actual

### **Opción 2: Migrar a PostgreSQL** (Más trabajo)
- Cambiar todo el código de mysqli a PostgreSQL
- Reescribir queries (sintaxis diferente)
- Migrar estructura de tablas
- **NO recomendado** para principiantes

**👉 Vamos con Opción 1: MySQL**

---

## 📝 **PLAN DE DEPLOY - Paso a Paso**

### **FASE 1: Instalar Software Necesario**

Conéctate por SSH:
```bash
ssh linuxuser@216.238.79.66
# Contraseña: [fP5%74YxQ_MrA.s
```

Ejecuta estos comandos:

```bash
# 1. Actualizar sistema
sudo apt update
sudo apt upgrade -y

# 2. Instalar PHP 8.1 con extensiones
sudo apt install -y php8.1-fpm php8.1-mysql php8.1-mbstring php8.1-xml php8.1-curl php8.1-gd php8.1-zip

# 3. Instalar MySQL Server
sudo apt install -y mysql-server

# 4. Verificar instalaciones
php -v
mysql --version
sudo systemctl status php8.1-fpm
sudo systemctl status mysql
```

---

### **FASE 2: Configurar MySQL**

```bash
# 1. Ejecutar configuración segura de MySQL
sudo mysql_secure_installation

# Responde:
# - VALIDATE PASSWORD: No (o Yes si quieres contraseñas fuertes)
# - Remove anonymous users: Yes
# - Disallow root login remotely: Yes
# - Remove test database: Yes
# - Reload privilege tables: Yes

# 2. Conectar a MySQL como root
sudo mysql

# 3. Dentro de MySQL, crear base de datos y usuario:
```

```sql
-- Crear base de datos
CREATE DATABASE vida_estudiantil CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear usuario
CREATE USER 'vidaestudiantil'@'localhost' IDENTIFIED BY 'TuPasswordSegura123!';

-- Dar permisos
GRANT ALL PRIVILEGES ON vida_estudiantil.* TO 'vidaestudiantil'@'localhost';
FLUSH PRIVILEGES;

-- Salir
EXIT;
```

---

### **FASE 3: Importar Base de Datos**

**En tu Mac (local):**

```bash
# 1. Exportar base de datos desde MAMP
cd /Applications/MAMP/htdocs/vida_estudiantil_Hitha
mysqldump -h localhost -P 8889 -u root -proot pruebasumadmin > backup_vida_estudiantil.sql

# 2. Subir backup al servidor
scp backup_vida_estudiantil.sql linuxuser@216.238.79.66:/home/linuxuser/
```

**En el VPS:**

```bash
# Importar la base de datos
mysql -u vidaestudiantil -p vida_estudiantil < /home/linuxuser/backup_vida_estudiantil.sql
# Contraseña: TuPasswordSegura123!

# Verificar que se importó
mysql -u vidaestudiantil -p vida_estudiantil -e "SHOW TABLES;"
```

---

### **FASE 4: Subir Archivos del Proyecto**

**Opción A - Desde tu Mac con SCP:**

```bash
cd /Applications/MAMP/htdocs/
scp -r vida_estudiantil_Hitha linuxuser@216.238.79.66:/home/linuxuser/
```

**Opción B - Usando Git (recomendado):**

```bash
# En tu Mac - Primero sube a GitHub
cd /Applications/MAMP/htdocs/vida_estudiantil_Hitha
git init
git add .
git commit -m "Deploy inicial"
git remote add origin https://github.com/TU_USUARIO/vida-estudiantil.git
git push -u origin main

# En el VPS - Clonar
cd /home/linuxuser/
git clone https://github.com/TU_USUARIO/vida-estudiantil.git
```

---

### **FASE 5: Configurar Archivos del Proyecto**

**En el VPS:**

```bash
cd /home/linuxuser/vida_estudiantil_Hitha

# 1. Editar config.php
nano config.php
```

**Cambiar estas líneas:**
```php
if ($is_local) {
    // ... mantener igual
} else {
    // PRODUCCIÓN
    define('SITE_URL', '/');
    define('PORTAL_URL', '/vidaEstudiantil/');
    define('CPANEL_URL', '/cpanel/');
}
```

```bash
# 2. Editar conexión de base de datos
nano cpanel/assets/API/db.php
```

**Cambiar:**
```php
class Conexion extends mysqli {
    public function __construct(){
        parent::__construct(
            'localhost',           // host
            'vidaestudiantil',     // usuario
            'TuPasswordSegura123!', // password
            'vida_estudiantil'     // database
        );
        if ($this->connect_errno) {
            die(' Error con la conexión: '.$this->connect_error);
        }
    }
}
```

```bash
# 3. Dar permisos correctos
sudo chown -R www-data:www-data /home/linuxuser/vida_estudiantil_Hitha
sudo chmod -R 755 /home/linuxuser/vida_estudiantil_Hitha
sudo chmod -R 775 /home/linuxuser/vida_estudiantil_Hitha/cpanel/assets/uploads
```

---

### **FASE 6: Configurar Nginx**

```bash
# Crear archivo de configuración
sudo nano /etc/nginx/sites-available/vida-estudiantil
```

**Pegar esta configuración:**

```nginx
server {
    listen 80;
    server_name 216.238.79.66;  # Cambiar por tu dominio si tienes

    root /home/linuxuser/vida_estudiantil_Hitha;
    index index.php index.html;

    # Logs
    access_log /var/log/nginx/vida-estudiantil-access.log;
    error_log /var/log/nginx/vida-estudiantil-error.log;

    # PHP
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Denegar acceso a archivos ocultos
    location ~ /\. {
        deny all;
    }

    # Directorio de uploads
    location ~ ^/cpanel/assets/uploads/ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

```bash
# Activar sitio
sudo ln -s /etc/nginx/sites-available/vida-estudiantil /etc/nginx/sites-enabled/

# Verificar configuración
sudo nginx -t

# Si dice "OK", reiniciar Nginx
sudo systemctl restart nginx
```

---

### **FASE 7: Probar el Sitio**

**Portal Público:**
```
http://216.238.79.66/vidaEstudiantil/
```

**Cpanel:**
```
http://216.238.79.66/cpanel/
```

---

## 🔒 **FASE 8: Seguridad Adicional (Opcional pero Recomendado)**

### **A. Instalar SSL con Let's Encrypt**

Si tienes un dominio (ej: `vidaestudiantil.tudominio.com`):

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d vidaestudiantil.tudominio.com
```

### **B. Proteger el Cpanel**

```bash
# Editar nginx config
sudo nano /etc/nginx/sites-available/vida-estudiantil
```

**Agregar protección por IP o password:**

```nginx
location /cpanel/ {
    # Opción 1: Solo permitir tu IP
    allow TU_IP_PUBLICA;
    deny all;

    # O Opción 2: Protección con password
    auth_basic "Admin Area";
    auth_basic_user_file /etc/nginx/.htpasswd;

    # ... resto de config PHP
}
```

**Para crear el archivo de passwords:**
```bash
sudo apt install -y apache2-utils
sudo htpasswd -c /etc/nginx/.htpasswd admin
# Te pedirá crear una contraseña
```

---

## 📊 **Checklist Final**

Antes de dar por terminado el deploy:

- [ ] PHP instalado y funcionando
- [ ] MySQL instalado y corriendo
- [ ] Base de datos importada correctamente
- [ ] Archivos subidos al servidor
- [ ] `config.php` configurado para producción
- [ ] `db.php` con credenciales correctas
- [ ] Permisos de archivos correctos (755/775)
- [ ] Nginx configurado y reiniciado
- [ ] Portal público funciona
- [ ] Cpanel funciona y puedes hacer login
- [ ] Imágenes se suben correctamente
- [ ] Base de datos responde correctamente

---

## 🆘 **Solución de Problemas Comunes**

### **Error: "502 Bad Gateway"**
```bash
# Verificar que PHP-FPM esté corriendo
sudo systemctl status php8.1-fpm
sudo systemctl restart php8.1-fpm
```

### **Error: "Access denied for user"**
```bash
# Verificar usuario de MySQL
mysql -u vidaestudiantil -p
# Si no funciona, recrear usuario
```

### **Las imágenes no cargan**
```bash
# Verificar permisos
ls -la cpanel/assets/uploads/
sudo chmod -R 775 cpanel/assets/uploads/
sudo chown -R www-data:www-data cpanel/assets/uploads/
```

### **Logs para debuggear**
```bash
# Ver logs de Nginx
sudo tail -f /var/log/nginx/vida-estudiantil-error.log

# Ver logs de PHP
sudo tail -f /var/log/php8.1-fpm.log
```

---

## 🎓 **Conceptos Importantes**

### **¿Qué es PHP-FPM?**
- PHP FastCGI Process Manager
- Permite a Nginx ejecutar archivos PHP
- En Apache se usa mod_php, en Nginx se usa PHP-FPM

### **¿Por qué MySQL y no PostgreSQL?**
- Tu código usa `mysqli` (específico de MySQL)
- PostgreSQL usa sintaxis diferente
- Migrar requeriría reescribir todo el código

### **Diferencias MAMP vs VPS:**
| MAMP | VPS |
|------|-----|
| Puerto 8889 | Puerto 3306 (default) |
| Usuario: root | Usuario: vidaestudiantil |
| Password: root | Password: segura |
| `/Applications/MAMP/htdocs/` | `/home/linuxuser/` |

---

## 📞 **Comandos Útiles para Mantenimiento**

```bash
# Ver uso de disco
df -h

# Ver logs en tiempo real
sudo tail -f /var/log/nginx/vida-estudiantil-error.log

# Reiniciar servicios
sudo systemctl restart nginx
sudo systemctl restart php8.1-fpm
sudo systemctl restart mysql

# Backup de base de datos
mysqldump -u vidaestudiantil -p vida_estudiantil > backup_$(date +%Y%m%d).sql

# Ver procesos de PHP
ps aux | grep php-fpm
```

---

**¿Listo para empezar? Pregúntame cualquier duda en cada fase! 🚀**
