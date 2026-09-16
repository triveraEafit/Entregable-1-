# 🛒 Tienda de Tecnología

Proyecto del curso **Arquitectura de Software** (EAFIT) — una tienda en línea de productos tecnológicos construida con Laravel, siguiendo el patrón MVC.

![PHP](https://img.shields.io/badge/PHP-8.4%2B-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)

📖 Más detalle de reglas de código, estilo y arquitectura en la **[Wiki del repositorio](../../wiki)**.

---

## Guía rápida para el equipo

### 1. Clonar el repositorio

```bash
git clone <URL-del-repo>
cd <nombre-carpeta>
```

### 2. Instalar dependencias

```bash
composer install
npm install
```

> ### ⚠ **Necesitas PHP 8.4 o superior.** Verifica con `php -v`. Si tu PHP es más viejo, o si `composer install` falla con `could not find driver`, abre tu `php.ini` y quítale el `;` a estas líneas, luego reinicia la consola:
>
> ```ini
> extension=pdo_mysql
> extension=mysqli
> ```

### 3. Configurar tu base de datos local

```bash
copy .env.example .env
php artisan key:generate
```

Crea tu propia base de datos MySQL vacía (con XAMPP, MAMP, Workbench, o lo que uses), y ajusta en `.env`:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306        # ajusta al puerto real de tu MySQL
DB_DATABASE=tienda_tecnologia
DB_USERNAME=root
DB_PASSWORD=tu_password

APP_LOCALE=es
APP_FALLBACK_LOCALE=en
```

### 4. Migrar con datos de prueba

```bash
php artisan migrate:fresh --seed
```

Esto crea todas las tablas y las llena con productos, categorías, marcas, usuarios y un pedido de ejemplo.

### 5. Levantar el proyecto

```bash
npm run build
php artisan serve
```

Abre **http://127.0.0.1:8000**

**Usuario administrador de prueba:**

| Campo | Valor |
|---|---|
| Email | `admin@tienda.com` |
| Contraseña | `password` |

---

## Flujo de trabajo con Git

1. Crea tu propia rama, nunca trabajes directo en `main`:
```bash
   git checkout -b feature/nombre-de-tu-tarea
```
2. Corre esto antes de cada commit (formatea el código con el estilo del equipo):
```bash
   ./vendor/bin/pint
```
3. Cuando termines tu parte:
```bash
   git add .
   git commit -m "feat: descripción de lo que hiciste"
   git push origin feature/nombre-de-tu-tarea
```
4. Abre un Pull Request hacia `main` en GitHub para que el arquitecto lo revise.

---

## Equipo

| Integrante | Rol | Clases |
|---|---|---|
| Tomás | Arquitecto | Infraestructura, User, Order, despliegue |
| Mateo | Desarrollador | Product, OrderItem |
| Ismael | Desarrollador | Category, Brand, Review |

---

## Documentación

Reglas de programación, guía de estilo, y demás detalles del proyecto están en la **[Wiki](../../wiki)** del repositorio.