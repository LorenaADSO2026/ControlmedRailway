# CONTROLMED - Backend Laravel

Este paquete contiene el **backend en Laravel** (modelos, migraciones, controladores,
rutas y vistas Blade) que conecta tu diseño front-end (HTML/CSS/JS que ya tenías)
con tu base de datos `controlmed` de phpMyAdmin/XAMPP.

No usa API ni AJAX: todo funciona con formularios normales (POST/PUT/DELETE)
que Laravel procesa en el servidor y devuelve la página ya con los datos reales.

## 1. Requisitos

- XAMPP con Apache y MySQL activos (phpMyAdmin funcionando, como en tu captura).
- PHP 8.2 o superior (revisa con `php -v`).
- Composer instalado (https://getcomposer.org/).

## 2. Crear el proyecto Laravel base

Abre una terminal (fuera de XAMPP, puede ser cmd/PowerShell) y ejecuta:

```
composer create-project laravel/laravel controlmed
```

Esto crea una carpeta `controlmed` con un proyecto Laravel limpio (con todas las
carpetas de "vendor", `artisan`, etc. que no vienen en este paquete).

## 3. Copiar los archivos de este paquete

Copia (reemplazando cuando pregunte) estas carpetas y archivos de este ZIP dentro
de la carpeta `controlmed` que generó Composer:

```
app/Http/Controllers/*.php   -> controlmed/app/Http/Controllers/
app/Models/*.php             -> controlmed/app/Models/
database/migrations/*.php    -> controlmed/database/migrations/
database/seeders/*.php       -> controlmed/database/seeders/
routes/web.php                -> controlmed/routes/web.php   (reemplaza el existente)
config/auth.php                -> controlmed/config/auth.php   (reemplaza el existente)
resources/views/*.blade.php y subcarpetas -> controlmed/resources/views/
public/CSS/                    -> controlmed/public/CSS/
public/JAVASCRIPT/             -> controlmed/public/JAVASCRIPT/
public/IMAGENES/               -> controlmed/public/IMAGENES/
```

## 4. Configurar la conexión a la base de datos

Copia el archivo `.env.example` de este paquete y pégalo como `.env` en la raíz
de `controlmed` (reemplaza el que trae Laravel por defecto), o simplemente edita
el `.env` que ya existe y ajusta estas líneas:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=controlmed
DB_USERNAME=root
DB_PASSWORD=
```

(usuario `root` y contraseña vacía son los valores por defecto de XAMPP; ajústalos
si tú configuraste otros).

Luego, en la terminal, dentro de la carpeta `controlmed`, genera la clave de la app:

```
php artisan key:generate
```

## 5. Crear las tablas en la base de datos

Tu base de datos `controlmed` ya existe en phpMyAdmin con tablas vacías o de
prueba. Para que coincidan exactamente con lo que el backend espera, lo más
seguro es dejar que Laravel las cree desde cero con las migraciones incluidas
en este paquete (respetan los mismos nombres de tabla que viste en phpMyAdmin:
`usuarios`, `medicamentos`, `pacientes`, `roles`, `alertas`, etc.):

```
php artisan migrate:fresh --seed
```

> ⚠️ `migrate:fresh` borra las tablas existentes y las vuelve a crear. Si ya
> tienes datos importantes en `controlmed`, haz un respaldo (Exportar) desde
> phpMyAdmin antes de ejecutar este comando.

El `--seed` crea automáticamente los 4 roles que ya tenías: Administrador,
Supervisor del punto de entrega, Auxiliar de farmacia y Secretario de salud.

## 6. Levantar el proyecto

```
php artisan serve
```

Abre el navegador en **http://localhost:8000**. Ahí verás tu pantalla de inicio
de sesión (`inicio.html` original, ahora servida por Laravel). Como aún no hay
usuarios, entra a "Registrarse" para crear el primer usuario del sistema.

## 7. Flujo de módulos ya conectados a la base de datos

- **Inicio de sesión / Registro** → tabla `usuarios` y `roles`, con contraseñas
  encriptadas (`Hash::make`) y sesión real de Laravel.
- **Inventario** → tabla `medicamentos`, con `inventario_movimientos` como
  bitácora de entradas/salidas/ajustes.
- **Pacientes** → tablas `pacientes` y `historial_pacientes`.
- **Alertas** → tabla `alertas`, generadas automáticamente según cantidad baja
  (≤ 5 unidades) o fecha de vencimiento próxima (≤ 30 días).
- **Reportes** → filtra `medicamentos` e `historial_acceso` por rango de fechas
  usando un formulario normal (GET), exporta a PDF (vista imprimible) o a CSV
  compatible con Excel. Cada exportación queda registrada en
  `reportes_inventarios` / `reportes_acceso`.
- **Configuración → Usuarios y Roles** → CRUD real sobre las tablas `usuarios`
  y `roles`.
- **Historial de acceso** → cada login, logout e intento fallido se guarda en
  `historial_acceso`.

## 8. Control de versiones (Git)

Dentro de la carpeta `controlmed`, después de copiar todos los archivos:

```
git init
git add .
git commit -m "Backend Laravel CONTROLMED conectado a phpMyAdmin"
```

Luego crea un repositorio vacío en GitHub/GitLab y sigue las instrucciones para
hacer `git remote add origin <url>` y `git push`.

## 9. Notas de validación (para tu documento de evidencia)

Cada formulario valida en dos capas:
1. **Cliente (JavaScript)**: campos vacíos, formato de cédula, código numérico,
   longitud de contraseña, letras en nombres, etc.
2. **Servidor (Laravel `$request->validate()`)**: la misma validación se repite
   en el backend (nunca se confía solo en el JavaScript), incluyendo tipos de
   dato, longitudes máximas, unicidad (cédula, usuario, código de medicamento)
   y formatos con expresiones regulares. Los mensajes de error aparecen en
   español arriba de cada formulario.
