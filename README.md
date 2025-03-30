# Restaurants Management

## Description
This project is a restaurants management system built using Laravel, a PHP web application framework with expressive, elegant syntax. The goal of this project is to provide a comprehensive solution for managing restaurant operations, including orders, kitchen view, and concessions.

## Getting Started

### Prerequisites
- Git
- XAMPP or WAMPP server
- Composer
- PHP
- MySQL

### Installation

1. Clone the repository:
   git clone https://github.com/AnujaLd/restaurants-management.git

2. Start XAMPP or WAMPP server and ensure MySQL is running.

3. Create a new database named `restaurants` and import the existing attached database.

4. Navigate to the project directory and install the dependencies:
   composer install

5. Copy the `.env.example` file to `.env`:
   cp .env.example .env

6. Update the `.env` file with your database configuration:

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=restaurants
   DB_USERNAME=root
   DB_PASSWORD=

7. Generate the application key:
   php artisan key:generate

8. Serve the application:
   php artisan serve

9. Access the application in your browser:
   http://127.0.0.1:8000/

### Usage

1. Home Page:
   ```
   http://127.0.0.1:8000/
   ```

2. Concession Page:
   ```
   http://127.0.0.1:8000/concession
   ```

3. Orders Page:
   ```
   http://127.0.0.1:8000/orders
   ```

4. Kitchen View:
   ```
   http://127.0.0.1:8000/kitchen
   ```

## Technologies Used
- PHP
- Laravel
- Blade
- JavaScript

## Contributors
- [AnujaLd](https://github.com/AnujaLd)

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.