# Company Management System

A Laravel application for business management with specific functionalities for tax and accounting administration.

## Features

- Company management with complete tax information
- User system with company assignment
- Support for Spanish tax configurations
- PDF generation with DOMPDF
- Modern interface with Blade and Tailwind CSS

## Requirements

- PHP >= 8.1
- MySQL/MariaDB
- Composer
- Node.js and NPM

## Installation

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd company-test
    ```

2. **Install dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Configure environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configure database**

    Update the `.env` file with your database credentials:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=company_db
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

5. **Run migrations and seeders**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

6. **Compile assets**

    ```bash
    npm run build (For production)
    npm run dev (For development)
    ```

7. **Start the server**
    ```bash
    php artisan serve
    ```

## Application Structure

### Main Models

- **User**: System users related to companies
- **Company**: Companies with complete tax information

### Seeders

- **CompanySeeder**: Creates 15 sample companies
- **UserSeeder**: Creates test users

## Technologies

- **Backend**: Laravel 10.x
- **Frontend**: Blade, Tailwind CSS, Vite
- **Base de Datos**: MySQL
- **PDF Generation**: DOMPDF
- **Testing**: PHPUnit
