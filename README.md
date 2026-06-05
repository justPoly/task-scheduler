# Laravel Task Scheduling and Redis Caching Assignment

## Overview

This project demonstrates the implementation of task scheduling and API response caching in Laravel.

### Features

* Logs API requests to a database
* Fetches weather data from the OpenWeatherMap API
* Caches API responses using Redis
* Automatically expires cached data after one hour
* Deletes API logs older than 30 days using Laravel's Task Scheduler
* Includes Artisan commands for cache and scheduled task management

---


## Technologies Used

* Laravel 12
* PHP 8.2+
* SQLite
* Redis
* OpenWeatherMap API
* Laravel Task Scheduler
* Laravel Cache
* Predis


---

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/justPoly/task-scheduler.git
cd task-scheduler
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Create Environment File

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

---

## Database Configuration

Create a MySQL database and update the `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_scheduler
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations:

```bash
php artisan migrate
```

---

## OpenWeatherMap API Configuration

Create a free account at https://openweathermap.org/api and generate an API key.

Add the API key to your `.env` file:

```env
WEATHER_API_KEY=your_api_key_here
```

---

## Redis Setup

### Ubuntu / WSL

Install Redis:

```bash
sudo apt update
sudo apt install redis-server
```

Start Redis:

```bash
sudo service redis-server start
```

Verify Redis is running:

```bash
redis-cli ping
```

Expected output:

```text
PONG
```

---

## Laravel Redis Configuration

Update the `.env` file:

```env
CACHE_STORE=redis

REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=null
```

Install Predis:

```bash
composer require predis/predis
```

Clear Laravel configuration cache:

```bash
php artisan optimize:clear
```

Verify Redis is being used:

```bash
php artisan tinker
```

```php
config('cache.default')
```

Expected output:

```php
"redis"
```

---

## Running the Application

Start the Laravel development server:

```bash
php artisan serve
```

Application URL:

```text
http://127.0.0.1:8000
```

---

## API Endpoint

### Get Weather Data

```http
GET /api/weather
```

Example:

```text
http://127.0.0.1:8000/api/weather
```

---

## How Caching Works

### First Request

When the endpoint is called for the first time:

1. Laravel checks Redis for cached weather data.
2. No cache is found.
3. Laravel fetches data from OpenWeatherMap.
4. The response is stored in Redis for one hour.

Response:

```json
{
  "source": "api"
}
```

### Subsequent Requests

When the endpoint is called again within one hour:

1. Laravel finds the cached data in Redis.
2. The external API is not called.
3. Data is returned directly from Redis.

Response:

```json
{
  "source": "cache"
}
```

---

## Cache Expiration

Weather data is cached for one hour using:

```php
Cache::put($cacheKey, $data, 3600);
```

After one hour, Laravel automatically invalidates the cache and retrieves fresh data from the external API.

---

## API Request Logging

Every request to the weather endpoint is logged to the database.

Information logged includes:

* Endpoint accessed
* IP address
* Timestamp

---

## Scheduled Task

A custom Artisan command removes API logs older than 30 days.

Run manually:

```bash
php artisan logs:clean
```

Expected output:

```text
Old logs cleaned
```

The command is also registered with Laravel's Task Scheduler and runs automatically once per day.

To test the scheduler manually:

```bash
php artisan schedule:run
```

Expected output:

```text
Running ["artisan" logs:clean]
DONE
```

---

## Testing Checklist

### Test API Endpoint

Open:

```text
http://127.0.0.1:8000/api/weather
```

First request:

```json
{
  "source": "api"
}
```

Second request:

```json
{
  "source": "cache"
}
```

### Verify Cache

```bash
php artisan tinker
```

```php
Cache::get('weather_lagos')
```

Weather data should be returned.

### Test Scheduled Task

```bash
php artisan logs:clean
```

### Test Scheduler

```bash
php artisan schedule:run
```

---

## Artisan Commands

```bash
php artisan serve
php artisan migrate
php artisan cache:clear
php artisan optimize:clear
php artisan logs:clean
php artisan schedule:run
```

---

## Author

**Polycarp Atalor**

* Email: [polycarpatalor@gmail.com](mailto:polycarpatalor@gmail.com)
