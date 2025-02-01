# WeatherApi 🌤️

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php)](https://php.net/)
[![Laravel Version](https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel)](https://laravel.com)
[![Redis](https://img.shields.io/badge/Redis-Caching-DC382D?logo=redis)](https://redis.io)

API para obtener datos meteorológicos de una ciudad, desarrollada como parte del [reto Weather API de roadmap.sh](https://roadmap.sh/projects/weather-api). Este proyecto implementa almacenamiento en caché con Redis y limitación de solicitudes para garantizar un rendimiento óptimo.

## Tabla de Contenidos

- [Características Clave](#características-clave-)
- [Tecnologías Principales](#tecnologías-principales-%EF%B8%8F)
- [Endpoints](#endpoints-)
- [Uso de la API](#uso-de-la-api-)
- [Instalación](#instalación-%EF%B8%8F)
- [Configuración de Redis](#configuración-de-redis-)
- [Estructura del Proyecto](#estructura-del-proyecto-%EF%B8%8F)
- [Manejo de Errores](#manejo-de-errores-%EF%B8%8F)
- [Contribución](#contribución-)
- [Créditos](#créditos)

## Características Clave 🔥

- ✅ **Obtención de datos meteorológicos**: Integración con la API de [Visual Crossing](https://www.visualcrossing.com/).
- ✅ **Almacenamiento en caché**: Uso de Redis para almacenar datos meteorológicos durante 12 horas.
- ✅ **Limitación de solicitudes**: Middleware personalizado para limitar las solicitudes a 60 por minuto por IP.
- ✅ **Manejo de errores**: Respuestas claras y detalladas en caso de errores.
- ✅ **Variables de entorno**: Configuración segura de claves API y conexiones.

## Tecnologías Principales 🛠️

- **Laravel 11**: Framework backend para desarrollo rápido y seguro.
- **Redis**: Almacenamiento en caché de datos meteorológicos.
- **HTTP Client**: Consumo de la API de Visual Crossing.

## Endpoints 🚪


| Método | Endpoint          | Descripción                                 |
| ------- | ----------------- | -------------------------------------------- |
| GET     | `/weather/{city}` | Obtener datos meteorológicos de una ciudad. |

## Uso de la API 📡

### 1. Obtener datos meteorológicos

```bash
curl -X GET http://localhost:8000/weather/Madrid
```

**Respuesta exitosa (200):**

```json
{
  "success": true,
  "weather": {
    "latitude": 40.4168,
    "longitude": -3.7038,
    "timezone": "Europe/Madrid",
    "currently": {
      "temperature": 15,
      "summary": "Clear",
      "humidity": 0.5,
      "windSpeed": 5
    }
  }
}
```

**Respuesta de error (404):**

```json
{
  "success": false,
  "message": "Could not get weather information."
}
```

### 2. Limitación de solicitudes

Si se exceden las 60 solicitudes por minuto, se devolverá:

```json
{
  "error": "Too many requests. Please try again later."
}
```

## Instalación 🛠️

1. Clonar repositorio:

```bash
git clone https://github.com/tu-usuario/api-tiempo.git
cd api-tiempo
```

2. Instalar dependencias:

```bash
composer install
```

3. Configurar entorno:

```bash
cp .env.example .env
php artisan key:generate
```

4. Configurar variables de entorno en `.env`:

```env
WEATHER_API_KEY=tu_clave_api_de_visual_crossing
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

5. Ejecutar migraciones (si es necesario):

```bash
php artisan migrate
```

6. Iniciar servidor:

```bash
php artisan serve
```

## Configuración de Redis 🧠

La API utiliza Redis para almacenar en caché los datos meteorológicos durante 12 horas.

### Instalación de Redis

#### Ubuntu

```bash
sudo apt-get install redis-server
```

#### Fedora

```bash
sudo dnf install redis
sudo systemctl start redis
sudo systemctl enable redis
```

#### Windows

1. Descarga el archivo MSI del instalador de Redis desde [Github Releases](https://github.com/microsoftarchive/redis/releases)
2. Ejecuta el instalador MSI
3. Durante la instalación, marca la opción "Add the Redis installation folder to the PATH environment variable"
4. El servicio de Redis se iniciará automáticamente
5. Para verificar la instalación, abre una terminal y ejecuta:

```bash
redis-cli ping
```

Deberías recibir "PONG" como respuesta

### Configuración en Laravel

La configuración de Redis se encuentra en el archivo `.env`:

```env
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## Estructura del Proyecto 🏗️

- **Controlador**: `App\Http\Controllers\WeatherController`
  - Maneja la lógica para obtener y devolver datos meteorológicos.
- **Middleware**: `App\Http\Middleware\CustomRateLimit`
  - Limita las solicitudes a 60 por minuto por IP.
- **Rutas**: Definidas en `routes/api.php`
  - Configura el endpoint `/weather/{city}`.

## Manejo de Errores ⚠️

**Ejemplo de error (500):**

```json
{
  "success": false,
  "message": "Error processing request:"
}
```

**Códigos de estado comunes:**

- 404 Not Found
- 429 Too Many Requests
- 500 Internal Server Error


> **Nota del Desarrollador** 💡
> Este proyecto implementa todas las mejores prácticas recomendadas por [roadmap.sh](https://roadmap.sh/projects/weather-api-wrapper-service) para APIs. ¡Espero que te sea útil! 🚀

## Créditos

- Desarrollado por [Fernando Gil](https://github.com/fer-gc05)
- Basado en el [reto Weather API de roadmap](https://roadmap.sh/projects/weather-api-wrapper-service).
