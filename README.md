# Canteen Ordering System

Laravel 11 monolithic application for a canteen ordering system with MySQL database.

## Tech Stack

- PHP 8.3
- Laravel 11
- MySQL 8.0
- Bootstrap 5

## Features

- Product listing with stock
- Order placement with quantity validation
- Stock check before order (redirects with "Stok tidak mencukupi" if insufficient)
- Bootstrap 5 alerts for success/error messages
- Order modal for each product

## Docker Setup

### Prerequisites

- Docker & Docker Compose

### Run the Application

1. **Build and start containers:**

```bash
docker compose up -d --build
```

2. **Seed the database with sample products:**

```bash
docker compose exec app php artisan db:seed
```

3. **Access the application:**

Open http://localhost:8000 in your browser.

### Docker Services

- **app** (port 8000): PHP 8.3 + Nginx
- **db** (port 3306): MySQL 8.0

The app service waits for the database to be healthy before starting (via `depends_on` with `condition: service_healthy`).

### Useful Commands

```bash
# Run migrations
docker compose exec app php artisan migrate

# Seed database
docker compose exec app php artisan db:seed

# View logs
docker compose logs -f app

# Stop containers
docker compose down
```

## Database Schema

### products
- id, name, price (decimal), stock (integer)

### orders
- id, product_id, quantity, total_price, status, created_at
