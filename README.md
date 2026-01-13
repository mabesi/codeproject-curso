# CODEPROJECT - Project Manager

A simple project management system built with PHP Laravel (backend) and AngularJS (frontend), developed during a programming course.

> [!CAUTION]
> **⚠️ ARCHIVED PROJECT - HISTORICAL REFERENCE ONLY**
> 
> This project is **no longer maintained** and uses outdated technologies and dependencies. It is preserved solely for **historical and educational reference purposes**. Do not use this code in production environments.

## :speech_balloon: Description

CodeProject is a didactic project management web application that demonstrates the integration between a PHP/Laravel RESTful API backend and an AngularJS single-page application (SPA) frontend. This project was created during a programming course to teach full-stack web development concepts, including:

- RESTful API design and implementation
- OAuth2 authentication flow
- Frontend-Backend separation of concerns
- Repository pattern in Laravel
- Single Page Application (SPA) architecture

## Table of Contents

- [Features](#features)
- [Architecture](#architecture)
- [Built With](#built-with)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
  - [Configuration](#configuration)
  - [Database Setup](#database-setup)
  - [Building Assets](#building-assets)
  - [Usage](#usage)
- [Project Structure](#project-structure)
- [API Endpoints](#api-endpoints)
- [Back Matter](#back-matter)
  - [Learning Objectives](#learning-objectives)
  - [Acknowledgements](#acknowledgements)
  - [Authors](#authors)
  - [License](#license)

## Features

The application includes the following features:

- **User Authentication**: OAuth2-based authentication system
- **Client Management**: Create, read, update, and delete clients (CRUD)
- **Project Management**: Full CRUD operations for projects
- **Project Notes**: Attach notes to projects
- **Project Tasks**: Manage tasks within projects
- **Project Members**: Add and remove team members from projects
- **File Attachments**: Upload and manage files for each project

## Architecture

The application follows a multi-layer architecture:

```
┌─────────────────────────────────────────────────────────────────┐
│                         Frontend (SPA)                          │
│                     AngularJS + Bootstrap                       │
├─────────────────────────────────────────────────────────────────┤
│                         HTTP/REST API                           │
├─────────────────────────────────────────────────────────────────┤
│                   Backend (Laravel 5.2)                         │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐          │
│  │  Controllers │──│   Services   │──│ Repositories │          │
│  └──────────────┘  └──────────────┘  └──────────────┘          │
│                                             │                   │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐          │
│  │  Validators  │  │ Transformers │  │   Entities   │          │
│  └──────────────┘  └──────────────┘  └──────────────┘          │
├─────────────────────────────────────────────────────────────────┤
│                      Database (MySQL)                           │
└─────────────────────────────────────────────────────────────────┘
```

## Built With

### Backend
- **PHP** >= 5.5.9
- **Laravel 5.2** - PHP Web Framework
- **L5 Repository** - Repository pattern implementation
- **OAuth2 Server Laravel** - Authentication
- **Fractal** - Data transformation layer

### Frontend
- **AngularJS 1.4.1** - JavaScript Framework
- **Angular Route** - Client-side routing
- **Angular Resource** - RESTful API communication
- **Angular Bootstrap** - UI components
- **Bootstrap 3.3.5** - CSS Framework

### Build Tools
- **Gulp** - Task runner
- **Laravel Elixir** - Asset compilation
- **Bower** - Frontend dependency management

## Getting Started

### Prerequisites

- PHP >= 5.5.9
- Composer
- Node.js and npm
- Bower (install globally: `npm install -g bower`)
- MySQL database

### Installation

Clone the repository on your local machine:

```bash
$ git clone git@github.com:mabesi/codeproject-curso.git
$ cd codeproject-curso
```

Install PHP dependencies:

```bash
$ composer install
```

Install Node.js dependencies:

```bash
$ npm install
```

Install frontend dependencies:

```bash
$ bower install
```

### Configuration

1. Copy the `.env.example` file to `.env`:

```bash
$ cp .env.example .env
```

2. Generate the application key:

```bash
$ php artisan key:generate
```

3. Configure your database connection in the `.env` file:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Database Setup

Run the migrations to create the database tables:

```bash
$ php artisan migrate
```

Seed the database with initial data (optional):

```bash
$ php artisan db:seed
```

### Building Assets

For development (with live reload):

```bash
$ npm run dev
```

For production:

```bash
$ npm run prod
```

### Usage

Start the development server:

```bash
$ php artisan serve
```

Open your browser and navigate to [http://localhost:8000](http://localhost:8000).

## Project Structure

```
codeproject-curso/
├── app/
│   ├── Console/          # Artisan commands
│   ├── Entities/         # Eloquent models (Project, Client, User, etc.)
│   ├── Http/
│   │   ├── Controllers/  # API controllers
│   │   ├── Middleware/   # HTTP middleware
│   │   └── routes.php    # Route definitions
│   ├── Presenters/       # Data presenters
│   ├── Repositories/     # Repository implementations
│   ├── Services/         # Business logic services
│   ├── Transformers/     # Fractal transformers
│   └── Validators/       # Request validators
├── config/               # Application configuration
├── database/
│   ├── migrations/       # Database migrations
│   └── seeds/            # Database seeders
├── public/               # Publicly accessible files
│   └── build/            # Compiled assets
├── resources/
│   └── assets/
│       ├── css/          # Stylesheets
│       └── js/
│           ├── app.js    # Angular application bootstrap
│           ├── controllers/  # Angular controllers
│           ├── services/     # Angular services
│           └── views/        # Angular templates (HTML)
└── storage/              # Application storage (logs, cache, etc.)
```

## API Endpoints

All API endpoints are protected by OAuth2 authentication.

### Authentication
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/oauth/access_token` | Get access token |

### Clients
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/client` | List all clients |
| POST | `/client` | Create a new client |
| GET | `/client/{id}` | Get a specific client |
| PUT | `/client/{id}` | Update a client |
| DELETE | `/client/{id}` | Delete a client |

### Projects
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/project` | List all projects |
| POST | `/project` | Create a new project |
| GET | `/project/{id}` | Get a specific project |
| PUT | `/project/{id}` | Update a project |
| DELETE | `/project/{id}` | Delete a project |

### Project Notes
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/project/{id}/note` | List project notes |
| POST | `/project/{id}/note` | Create a note |
| GET | `/project/{id}/note/{noteId}` | Get a specific note |
| PUT | `/project/{id}/note/{noteId}` | Update a note |
| DELETE | `/project/{id}/note/{noteId}` | Delete a note |

### Project Tasks
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/project/{id}/task` | List project tasks |
| POST | `/project/{id}/task` | Create a task |
| GET | `/project/{id}/task/{taskId}` | Get a specific task |
| PUT | `/project/{id}/task/{taskId}` | Update a task |
| DELETE | `/project/{id}/task/{taskId}` | Delete a task |

### Project Members
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/project/{id}/member` | List project members |
| GET | `/project/{id}/member/{memberId}` | Get a specific member |
| PUT | `/project/{id}/member/{memberId}` | Add a member |
| DELETE | `/project/{id}/member/{memberId}` | Remove a member |

### Project Files
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/project/{id}/file` | List project files |
| POST | `/project/{id}/file` | Upload a file |
| GET | `/project/{id}/file/{fileId}` | Get a specific file |
| PUT | `/project/{id}/file/{fileId}` | Update file metadata |
| DELETE | `/project/{id}/file/{fileId}` | Delete a file |

## Back Matter

### Learning Objectives

This project was designed to teach the following concepts:

1. **Backend Development**
   - Laravel framework fundamentals
   - RESTful API design principles
   - Repository pattern for data access
   - Service layer for business logic
   - Data transformation with Fractal
   - OAuth2 authentication implementation

2. **Frontend Development**
   - AngularJS architecture (controllers, services, directives)
   - Single Page Application (SPA) concepts
   - Client-side routing
   - Consuming RESTful APIs
   - Token-based authentication handling

3. **Development Practices**
   - Separation of concerns
   - Asset build pipeline with Gulp
   - Dependency management (Composer, npm, Bower)

### Acknowledgements

This project was developed during a programming course and is based on the teachings and materials provided by:

- [Code Education](https://code.education/) - Online Courses
- [Laravel](https://laravel.com/) - PHP Framework
- [AngularJS](https://angularjs.org/) - JavaScript Framework

### Authors

| [<img loading="lazy" src="https://github.com/mabesi/mabesi/blob/master/octocat-mabesi.png" width=115><br><sub>Plinio Mabesi</sub>](https://github.com/mabesi) |
| :---: |

### License

This project is licensed under the [MIT License](LICENSE.md).
