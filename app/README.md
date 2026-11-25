# CleanTrack

Sistema de gestión de inmuebles, tareas y tiempos para empresas de limpieza.

Proyecto individual del curso **ISW-912** de la **Universidad Técnica Nacional (UTN)**, desarrollado con la metodología **Scrum**.

## Funcionalidades implementadas (Sprint 1)

| Historia | Funcionalidad | Descripción |
| --- | --- | --- |
| US-01 | Registro de clientes | Registrar clientes con nombre, tipo (residencial o comercial) y teléfono, y consultarlos en una lista. |
| US-02 | Registro de inmuebles por cliente | Registrar los inmuebles de cada cliente con su dirección y tipo (casa, apartamento, oficina o local). Un cliente puede tener varios inmuebles. |
| US-03 | Áreas del inmueble | Registrar la cantidad de habitaciones, baños, cocinas y oficinas de cada inmueble. |
| US-04 | Ficha del inmueble | Consultar en una sola pantalla la dirección, el tipo, el cliente y las áreas de un inmueble. |

Todos los formularios validan los datos en el servidor y muestran los errores en español. Las pantallas se adaptan a teléfonos.

## Tecnologías

| Tecnología | Versión |
| --- | --- |
| PHP | 8.3 (desarrollado con 8.3.30) |
| Laravel | 13 (desarrollado con 13.43.0) |
| PostgreSQL | Base de datos de la aplicación |
| Blade | Motor de plantillas de las vistas |
| PHPUnit | Pruebas automatizadas |

## Requisitos

- **PHP 8.3 o superior**, con las extensiones `pdo_pgsql` (para PostgreSQL) y `pdo_sqlite` (para las pruebas).
- **Composer**.
- **PostgreSQL**.

## Instalación

1. Clona el repositorio y entra a la carpeta de la aplicación:

   ```bash
   git clone https://github.com/romeron29/CleanTrack_Admin_Proyectos.git
   cd CleanTrack_Admin_Proyectos/app
   ```

2. Instala las dependencias de PHP:

   ```bash
   composer install
   ```

3. Copia el archivo de configuración de ejemplo:

   ```bash
   cp .env.example .env
   ```

4. Crea la base de datos `cleantrack` en PostgreSQL:

   ```bash
   createdb -U postgres cleantrack
   ```

   o, desde `psql`:

   ```sql
   CREATE DATABASE cleantrack;
   ```

5. Configura PostgreSQL en el archivo `.env`. Reemplaza las líneas `DB_` (que vienen configuradas para SQLite) por las siguientes y ajusta el puerto, el usuario y la contraseña a tu instalación:

   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=cleantrack
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
   ```

6. Genera la clave de la aplicación:

   ```bash
   php artisan key:generate
   ```

7. Crea las tablas de la base de datos:

   ```bash
   php artisan migrate
   ```

## Ejecución

Inicia el servidor de desarrollo:

```bash
php artisan serve
```

La aplicación queda disponible en <http://127.0.0.1:8000>. El sistema empieza en la lista de clientes, en <http://127.0.0.1:8000/clientes>. Desde ahí se llega a los inmuebles de cada cliente y a la ficha de cada inmueble.

## Pruebas

Ejecuta las pruebas automatizadas con:

```bash
php artisan test
```

Las pruebas usan una base de datos SQLite en memoria, así que no modifican los datos de PostgreSQL.

## Estado del proyecto

- **Sprint 1** (24 y 25 de noviembre de 2026): completado. Incluye US-01, US-02, US-03 y US-04.
- **Tablero del proyecto:** [GitHub Projects](https://github.com/users/romeron29/projects/3)

## Autor

Nestor Ramon Romero Borge
