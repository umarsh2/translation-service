# Translation Management Service

## Overview

This project is a Translation Management Service developed using Laravel to evaluate the ability to write clean, scalable, and secure code with a focus on performance. The service allows the management of translations for multiple locales and supports efficient API endpoints for managing translations. It includes features such as creating, updating, viewing, and searching translations by tags, keys, or content. Additionally, the service provides a JSON export endpoint for frontend applications.

## Setup Instructions

### Prerequisites
1. **PHP** >= 8.2
2. **Composer**
3. **MySQL** (or any other relational database supported by Laravel)

### Installation

1. Clone the repository:
2. composer install
3. cp .env.example .env
4. Set up your database connection in the .env file:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=translation_service
DB_USERNAME=root
DB_PASSWORD=

5. php artisan key:generate
6. php artisan migrate
7. php artisan db:seed --class=TranslationSeeder
8. To test the endpoints, I have added a file named postman_collection.json at root of the project and you can import it into postman to test the APIs.

### Assumptions 
1. Translation may have multiple tags.
2. We have defined tags like web, mobile and desktop only.

