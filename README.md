Tienda de Tecnología — Guía rápida para el equipo
1. Clonar el repo
bash
git clone <URL-del-repo>
cd <nombre-carpeta>
2. Instalar dependencias
bash
composer install
npm install

⚠️ Necesitas PHP 8.4 o superior. Verifica con php -v. Si tu PHP es más viejo o no tiene el driver de MySQL activado (could not find driver), abre tu php.ini, quítale el ; a estas dos líneas, y reinicia la consola:

extension=pdo_mysql
extension=mysqli
3. Configurar tu base de datos local
bash
copy .env.example .env
php artisan key:generate

Crea tu propia base de datos MySQL vacía (con XAMPP, MAMP, Workbench, o lo que uses), y ajusta en .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306        # ajusta al puerto real de tu MySQL
DB_DATABASE=tienda_tecnologia
DB_USERNAME=root
DB_PASSWORD=tu_password
4. Migrar con datos de prueba
bash
php artisan migrate:fresh --seed

Esto crea todas las tablas y las llena con productos, categorías, marcas, usuarios y un pedido de ejemplo.

5. Levantar el proyecto
bash
npm run build
php artisan serve

Abre http://127.0.0.1:8000.

Usuario administrador de prueba:

Email: admin@tienda.com
Contraseña: password
6. Antes de programar tu parte

Crea tu propia rama, nunca trabajes directo en main:

bash
git checkout -b feature/nombre-de-tu-tarea

Corre esto antes de cada commit (formatea el código con el estilo del equipo):

bash
./vendor/bin/pint

Cuando termines tu parte:

bash
git add .
git commit -m "Descripción de lo que hiciste"
git push origin feature/nombre-de-tu-tarea

Y abre un Pull Request hacia main en GitHub para que el arquitecto lo revise.

Reparto de tareas
Compañero 1: Product + OrderItem (revisar CRUD admin, validar checkout/stock, funcionalidad "top productos más vendidos").
Compañero 2: Category + Brand + Review (revisar CRUD admin de Category, crear CRUD admin de Brand, mejorar reseñas, agregar filtros).

Más detalle de reglas de código, estilo y el resto del proyecto está en la Wiki del repositorio.
