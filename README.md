# Simple Library API

This is a Laravel-based API for managing books and categories. The API allows you to perform CRUD (Create, Read, Update, Delete) operations on books and categories. Each book belongs to a category, and the API provides endpoints to retrieve books by category and categories with their associated books.

## Features
- Manage books and their associated categories.
- Create, read, update, and delete both books and categories.
- Retrieve books by their category.
- Retrieve all categories with their associated books.

## Table of Contents
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [API Endpoints](#api-endpoints)
- [Usage](#usage)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

## Installation

### Requirements
- PHP 8.0+
- Composer
- MySQL (or another supported database)
- Laravel 9.x

### Steps
1. **Clone the repository**:
   ```
   git clone https://github.com/your-username/book-category-api.git
   cd book-category-api
   ```

2. **Install dependencies**:

   ```
   composer install
   ```

3. **Set up environment**:

 - Copy the `.env.example` file to `.env`:

   ```
   cp .env.example .env
   ```

 - Update the `.env` file with your database and mail configuration details:

   ```
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Generate application key**:

   ```
   php artisan key:generate
   ```

5. **Run migrations: Run database migrations to create the necessary tables**:

   ```
   php artisan migrate
   ```

6. **Seed the database**:

   ```
   php artisan db:seed
   ```

## Configuration

- After setting up your `.env` file, ensure your database is correctly configured.
- You can configure other aspects such as cache, mail, and queues in the `.env` file.


### Running the Application

Start the Laravel development server:

```bash
php artisan serve
```

Visit `http://localhost:8000` to access the API.

### Example API Calls

1. **Retrieve a list of all books**:

```bash
GET /api/books
```

2. **Retrieve all categories with their associated books**:

```bash
GET /api/books/category
```

3. **Create a new book**:

```bash
POST /api/books
```

### Usage
- List Books: Retrieves all books with pagination.
- Create Book: Requires a `title`, `author`, `published_at`, `is_active`, and `category_id`.
- Update Book: Only fields that need to be updated should be sent in the request.
- Delete Book: Deleting a book will remove it from the database.


## Testing
To run tests, you can use Postman

## License
This project is open-source and licensed under the [MIT license](https://opensource.org/licenses/MIT).