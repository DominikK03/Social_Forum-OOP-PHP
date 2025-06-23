# Social Forum - OOP PHP

Social networking forum application built in PHP using object-oriented programming approach, MVC pattern, Docker containers, and MySQL database.

## Project Description

Social Forum is a platform that allows users to publish posts, comment, and interact with other users. The application features a user account management system, an admin panel, and dedicated views for displaying content.

## Technologies

- PHP 8.3.8
- MySQL 8.0
- Docker and Docker Compose
- Nginx
- Composer
- PSR-4 Autoloading
- Ramsey/UUID
- PSR Container

## Project Structure

- **public/** - Public files directly accessible by the web server
  - **index.php** - Application entry point
  - **storage/** - Storage for resources (images, CSS, JS)
- **src/** - Application source code
  - **Controller/** - Controllers handling HTTP requests
  - **Core/** - Core of the application (DI, routing, HTTP handling)
  - **Enum/** - Enumeration types
  - **Exception/** - Custom exceptions
  - **Factory/** - Object factories
  - **Model/** - Data models
  - **PDO/** - Database access layer
  - **Repository/** - Repositories managing data access
  - **Request/** - Classes representing requests
  - **Service/** - Business service layer
  - **Util/** - Helper tools
  - **View/** - Views
- **templates/** - HTML templates
- **docker/** - Docker container configuration
  - **Dockerfile** - PHP container configuration
  - **mysql/** - Database configuration
  - **nginx/** - Web server configuration

## Main Features

- User registration and login
- User account management
- Creating and displaying posts
- Comment system
- Admin panel
- Image storage and display
- User role management

## Application Architecture

The application uses:
- MVC (Model-View-Controller) pattern for code organization
- Dependency Injection for dependency management
- Repository layer for database communication
- Service layer for business logic
- Validators for data validation
- Routing system for handling HTTP requests

## System Requirements

- Docker and Docker Compose
- Git

## How to Run?

To run the project locally, follow these steps:

```bash
# Clone the repository
git clone https://github.com/DominikK03/Social_Forum-OOP-PHP.git

# Navigate to the project directory
cd Social_Forum-OOP-PHP

# Start Docker containers
docker-compose up -d --build

# Enter the application container
docker exec -it sf-app bash

# Install Composer dependencies
composer install
```

After completing these steps, the application will be available at: http://localhost:8000
