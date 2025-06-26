# PROTOTIPO_TATTOOSHOP

Proyecto de semestre para la asignatura  **Desarrollo de Software I**  
Sistema web para la gestión de una tienda de tatuajes: inventario, ventas, agendamiento de citas (reservas), usuarios y reportes.

## 📋 Descripción

Esta aplicación permite administrar productos, servicios, reservas, usuarios y el inventario (Kardex) de una tienda de tatuajes. Incluye funcionalidades para diferentes perfiles: administrador, empleados (artistas) y clientes.


## 🚀 Tecnologías utilizadas

- **Backend:** Laravel 12 (PHP 8.4)
- **Frontend:** Blade, CSS personalizado, JavaScript, HTML
- **Base de datos:** MySQL
- **Otros:** Composer, NPM, Laravel Mix/Vite

## ⚙️ Instalación y ejecución

1. **Clona el repositorio:**
   ```bash
   git clone https://github.com/tuusuario/PROTOTIPO_TATTOOSHOP.git
   cd PROTOTIPO_TATTOOSHOP
   ```

2. **Instala dependencias:**
   ```bash
   composer install
   npm install
   ```

3. **Configura el archivo `.env`:**
   - Copia `.env.example` a `.env` y ajusta los datos de tu base de datos y correo.

4. **Genera la clave de la app:**
   ```bash
   php artisan key:generate
   ```

5. **Ejecuta migraciones y seeders:**
   ```bash
   php artisan migrate --seed
   ```

6. **Compila los assets:**
   ```bash
   npm run dev
   ```

7. **Inicia el servidor:**
   ```bash
   php artisan serve
   ```

---

## 👤 Perfiles de usuario

- **Administrador:** Gestiona usuarios, inventario, reportes y configuración.
- **Empleado (Artista):** Consulta inventario, gestiona reservas y servicios.
- **Cliente:** Realiza reservas, compras y consulta su historial.

---

## 🛠️ Funcionalidades principales

- **Gestión de productos y servicios**
- **Carrito de compras y checkout**
- **Reservas de servicios**
- **Gestión de inventario (Kardex)**
- **Reportes imprimibles de facturas, inventario y reservas**
- **Gestión de usuarios y perfiles**
- **Autenticación y control de acceso**

---

## 📄 Estructura del proyecto

- `app/Http/Controllers/` — Controladores de la lógica de negocio
- `resources/views/` — Vistas Blade (interfaz de usuario)
- `routes/web.php` — Definición de rutas web
- `public/` — Archivos públicos (CSS, JS, imágenes)
- `database/` — Migraciones y seeders

---

## 🌐 Sobre el idioma de las rutas
Las rutas del sistema están en inglés porque fueron generadas automáticamente por Laravel, que utiliza este idioma por defecto en sus comandos y plantillas. Esto ayuda a mantener compatibilidad con la documentación oficial y las convenciones del framework. En el caso del modelo de autenticación (registro, inicio de sesión, etc) fue implementado por la tecnología LaravelBreeze dentro de la carpeta auth.

---

## 📝 Notas importantes

- El carrito de compras se vacía automáticamente al cerrar sesión.
- Solo usuarios autenticados pueden acceder a productos, servicios, reservas y carrito.
- Los reportes pueden imprimirse o exportarse como PDF desde la interfaz.
- El inventario solo es visible para administradores y empleados.
- La configuración solo es visible para administradores.
- Este repositorio cuenta con la base de datos 'gestion_tattoo_shop.sql' que se uso como base para la construcción (no contiene ningún dato real)

---

## 👨‍💻 Autores

- [José Fabián Ortiz Duque] [202369568]
- [Angie Stefany Herrera Ramírez] [202362397]
- [Johan Alejandro Rodríguez Cardona] [202362631]



---

## 📚 Licencia

Proyecto académico para uso educativo.  