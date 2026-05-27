# ConstruPRO - ERP MVP para Constructora

Sistema web modular para gestionar proyectos de construccion, gastos, proveedores, materiales, inventario y compras.

## Stack

- Laravel 13
- PHP 8.3+
- PostgreSQL 16
- Docker + Nginx + Redis
- Blade + Tailwind CSS 4

## Requisitos

- Docker Desktop (o Docker Engine + Compose v2)
- Git

## Instalacion con Docker

```bash
# 1. Clonar el repositorio
git clone <url-del-repo> construpro
cd construpro

# 2. Copiar variables de entorno
cp .env.example .env

# 3. Levantar contenedores
docker compose up -d --build

# 4. Instalar dependencias PHP
docker compose exec app composer install

# 5. Generar clave de aplicacion
docker compose exec app php artisan key:generate

# 6. Migrar y sembrar datos demo
docker compose exec app php artisan migrate --seed

# 7. Enlace simbolico de storage
docker compose exec app php artisan storage:link

# 8. Si vas a trabajar la interfaz manualmente
docker compose exec app npm install
docker compose exec app npm run build
```

Abrir: **http://localhost:8080**

Nota: el contenedor `app` compila los assets automaticamente si `public/build/manifest.json` no existe.

### Credenciales demo

| Usuario | Contrasena | Rol |
|---------|------------|-----|
| admin@construpro.local | password | Administrador |
| gerente@construpro.local | password | Gerente |

## Comandos utiles

```bash
docker compose logs -f app
docker compose exec app php artisan tinker
docker compose down
docker compose down -v   # elimina volumenes (BD y storage)
```

## Estructura del proyecto

```text
app/
|-- Enums/              # Estados y roles tipados
|-- Http/
|   |-- Controllers/    # Controladores por modulo
|   |-- Middleware/     # EnsureRole
|   `-- Requests/       # Validaciones
|-- Models/             # Eloquent + relaciones
|-- Policies/           # Autorizacion
`-- Services/           # Inventario, compras, documentos
database/
|-- migrations/
|-- seeders/
`-- factories/
docker/
|-- nginx/
`-- php/
resources/views/        # Blade + Tailwind
routes/web.php
```

## Modulos incluidos

1. **Usuarios y roles** - Admin, Gerente, Supervisor, Bodega, Contabilidad, Usuario
2. **Proyectos** - CRUD, estados, evidencias, pestanas de detalle
3. **Gastos** - Registro, aprobacion/rechazo, filtros, facturas
4. **Proveedores** - CRUD completo
5. **Materiales e inventario** - Stock automatico con movimientos
6. **Compras** - Detalle multi-linea; al recibir genera entrada de inventario
7. **Dashboard y reportes** - KPIs y gastos por proyecto/categoria

## Seguridad

- Autenticacion obligatoria en rutas internas
- CSRF activo en formularios
- Contrasenas hasheadas (bcrypt)
- Validacion de archivos (tipo/tamano)
- Policies y middleware por rol

## Despliegue basico en servidor

1. Clonar repo en el servidor
2. Configurar `.env` con `APP_ENV=production`, `APP_DEBUG=false`
3. Ejecutar los mismos pasos Docker
4. Configurar dominio o reverse proxy apuntando al puerto 8080 (o mapear 80)
5. Programar backups del volumen `construpro_pgdata`

## Licencia

MIT
