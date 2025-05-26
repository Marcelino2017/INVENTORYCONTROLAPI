# API de Gestión de Inventario Simple con Roles

API RESTful desarrollada con Laravel para gestionar inventarios y usuarios con control de roles (admin y user).

### 📐 Decisiones de Diseño

1. Enum vs Tabla de Roles
   Opté por usar un enum en la tabla de usuarios para definir los roles (admin, user), ya que solo se manejan dos y no era necesario crear una tabla adicional.Sin embargo, en caso de que el proyecto llegue a requerir más roles o una gestión de permisos más compleja, consideraría implementar el paquete  `spatie/laravel-permission`, ya que facilita considerablemente la administración y validación de roles en aplicaciones de mayor escala..
2. Middleware o Paquete de Autorización
   Se implemento la libreria el middleware `auth:api` y la libreria ` tymon/jwt-auth` para la autenticaion con jwt
3. Policy
   Se utilizado Policies para validar la autorización de los usuarios en función de sus roles.

## 🔒 Seguridad

Se implemento la librería `tymon/jwt-auth` para la autenticación con JWT, lo que permite validar al usuario sin necesidad de guardar información en el servidor, ya que toda la información necesaria va dentro del token. Además, el token va cifrados, por lo que no pueden ser modificados sin autorización.

## 🧠 Arquitectura y Patrones

* **Controller-Service-Repository** :
  * Contralador: Se utilizo para coordinar las peticione; el cual se encarga de validar la peticion http, delengando asi la logica los servicio
  * Services: Se manejo la lógica del negocio, encargados de procesar la información y la interacción con los repositorios.
  * Repositories: se encargo de las consultas a los datos, centralizando las consultas y facilitando cambios en la capa de datos sin afectar la lógica del negocio
* **SOLID pricipio de responsabilidad unica** Por ejemplo, los Controladores manejan solo las peticiones y respuestas, los Servicios contienen la lógica del negocio, y los Repositorios solo acceden a la base de datos.
* **SOLID Principio de Inversión de Dependencias** Por ejemplo, los servicios dependen de interfaces de repositorios, que se inyectan mediante el contenedor de dependencias de Laravel.
* **SOLID Principio de Segregación de Interfaces (Interface Segregation Principle)**  Se definen interfaces específicas y pequeñas para cada funcionalidad, evitando que las clases dependan de métodos que no usan.

## 🚀 Requisitos del sistema

Asegúrate de tener instalado lo siguiente:

- **PHP >= 8.1**
- **Composer >= 2.x**
- **MySQL >= 5.7**
- **Node.js y npm** (para compilar assets si aplica)

## 🛠️ Instrucciones para configuración local

Sigue estos pasos para correr la API en tu entorno local:

1. **Clonar el repositorio**

```
git clone https://github.com/Marcelino2017/INVENTORYCONTROLAPI.git
cd INVENTORYCONTROLAPI
```

2. **Instalar dependencias PHP**

```bash
composer install
```

3. **Copiar el archivo de entorno y configurarlo**

```bash
cp .env.example .env
```

4. **Configurar variables de entorno en `.env`**

Ejemplo básico:

```
APP_NAME=INVENTORYCONTROLAPI
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_db
DB_USERNAME=root
DB_PASSWORD=

JWT_SECRET=tu_clave_jwt_generada
```

5. **Generar clave de aplicación**

```bash
php artisan key:generate
php artisan jwt:secret
```

6. **Ejecutar las migraciones**

```bash
php artisan migrate
```

7. **(Opcional) Ejecutar los seeders**

```bash
php artisan db:seed
```

8. **Levantar el servidor**

```bash
php artisan serve
```

### **Usuarios para pruebas**

```
email: admin@example.com
password: password


email: user@example.com
password: password
```
