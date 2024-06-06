# Auto parts store

This pet project is a simple auto parts store. It is a web application that allows users to view a list of auto parts,
add them to the cart, and place an order. The application is built using Laravel.

## Table of contents

- [Installation](#installation)
- [Features](#features)

## Installation

For the application to work, you need to have `Docker` or `PHP`, `Composer` and `MySQL` installed on your machine. Follow these steps to
install the application:

1. Clone the repository:

```bash
git clone https://www.github.com/winicred/pet_auto-parts-store.git
cd pet_auto-parts-store
```

2. Install the dependencies:

```bash
composer install
npm install
```

3. Create a `.env` file:

```bash
# For Unix-based systems
cp .env.example .env

# For Windows
copy .env.example .env
```

4. Generate an application key:

```bash
php artisan key:generate
```

> **Note:** If you want to run the application using Docker, follow the instructions in the [Docker section](#docker).

5. Set up the database:

```bash
php artisan migrate
```

6. Seed the database (Optional):

```bash
php artisan db:seed
```

7. Create a Vite build:

```bash
npm run build
```

8. Start the server:

```bash
php artisan serve
```

### Docker

1. Install the Laravel Sail package:

```bash
composer require laravel/sail --dev
```

2. Publish the Sail configuration file:

```bash
php artisan sail:install
```

3. Build the Docker containers:

```bash
# For Unix-based systems
./vendor/bin/sail build --no-cache

# For Windows
bash ./vendor/bin/sail build --no-cache
```

4. Set up the database:

```bash
# For Unix-based systems
./vendor/bin/sail artisan migrate

# For Windows
bash ./vendor/bin/sail artisan migrate
```

5. Seed the database (Optional):

```bash
# For Unix-based systems
./vendor/bin/sail artisan db:seed

# For Windows
bash ./vendor/bin/sail artisan db:seed
```

6. Create a Vite build:

```bash
npm run build
```

7. Start the server:

```bash
# For Unix-based systems
./vendor/bin/sail up

# For Windows
bash ./vendor/bin/sail up
```


## Features

`Eparts` has 3 roles: `admin`, `manager`, and `customer`. Each role has its own set of permissions.

### Customer

Customers can:

- View a list of auto parts
- Add auto parts to the cart
- Place an order
- Edit the profile
- View the order history
- View the order details

### Manager

Manager can do everything that a customer can do, and:

- Visit the admin panel
- View the catalog
- Add/edit/delete auto parts

### Admin

Admin can do everything that a manager can do, and:

- Manage users
- View orders
- Change the order status