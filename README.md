# API

## 🚀Desarrollo

Configurar el archivo de las variables de entorno `.env`

```sh
# Ejecutar entorno de desarrollo
php artisan serve

# Generar la key de la API
php artisan key:generate

# Ejecutar las migraciones
php artisan migrate
```

```sh
# Listar los endpoints
php artisan route:list
```

### 🐘Base de datos - PostgreSQL (16)

Credenciales por defecto:

- **Usuario:** `postgres`
- **Contraseña:** `123456`
- **Base de datos:** `hotels`

```sh
docker build -t laravel-app .

# Crear el contenedor de la base de datos (docker-compose.yaml)
docker-compose up -d
```
