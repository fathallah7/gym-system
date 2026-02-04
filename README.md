# Gym Management System

A comprehensive, full-stack web application for managing gym operations, including member management, membership subscriptions, payment processing, and administrative dashboards.

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [System Architecture](#system-architecture)
- [Installation](#installation)
- [Configuration](#configuration)
- [API Documentation](#api-documentation)
- [Database Schema](#database-schema)
- [Usage](#usage)
- [Testing](#testing)
- [Deployment](#deployment)
- [Contributing](#contributing)
- [License](#license)

## Overview

The Gym Management System is a modern, production-ready application designed to streamline gym operations. Built with Laravel 12 and Vue.js 3, it provides a robust backend API with a responsive, intuitive frontend interface. The system handles member registration, subscription management, payment tracking, and provides comprehensive analytics through an interactive dashboard.

## Features

### Member Management
- Complete CRUD operations for gym members
- Member status tracking (active, banned)
- Advanced search and filtering capabilities
- Member profile management with contact information
- Pagination support for large member databases

### Membership Subscriptions
- Flexible subscription plans with customizable durations
- Multiple subscription statuses (active, expired, frozen, canceled)
- Automatic expiration tracking
- Subscription renewal management
- Plan-based pricing structure

### Payment Processing
- Payment record management
- Multiple payment method support (cash, credit card, bank transfer)
- Payment history tracking
- Invoice generation and management
- Payment status monitoring (paid, unpaid, partial)

### Administrative Dashboard
- Real-time analytics and metrics
- Visual data representation with Chart.js
- Monthly revenue tracking
- Membership growth statistics
- Subscription distribution analysis
- Recent activity monitoring

### Authentication & Authorization
- Secure authentication using Laravel Sanctum
- Token-based API authentication
- Role-based access control
- Protected routes and endpoints

## Technology Stack

### Backend
- **Framework**: Laravel 12.x
- **Language**: PHP 8.2+
- **Authentication**: Laravel Sanctum 4.0
- **Database**: MySQL/PostgreSQL/SQLite
- **API**: RESTful API with versioning (v1)
- **Testing**: Pest PHP 3.8

### Frontend
- **Framework**: Vue.js 3.5
- **Build Tool**: Vite 7.0
- **Routing**: Vue Router 4.5
- **HTTP Client**: Axios 1.11
- **Styling**: Tailwind CSS 4.1
- **Charts**: Chart.js 4.5
- **Notifications**: Vue Toastification 2.0
- **Date Handling**: date-fns 4.1

### Development Tools
- **Code Quality**: Laravel Pint, Prettier
- **Version Control**: Git
- **Package Management**: Composer, npm

## System Architecture

The application follows a modern, layered architecture:

### Backend Architecture
```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/V1/    # Versioned API controllers
│   │   ├── Requests/              # Form request validation
│   │   └── Resources/             # API resource transformers
│   ├── Models/                    # Eloquent models
│   ├── Policies/                  # Authorization policies
│   └── Services/                  # Business logic layer
├── database/
│   ├── migrations/                # Database migrations
│   ├── factories/                 # Model factories
│   └── seeders/                   # Database seeders
└── routes/
    └── api.php                    # API routes
```

### Frontend Architecture
```
frontend/
├── src/
│   ├── assets/                    # Static assets
│   ├── components/                # Reusable Vue components
│   ├── composables/               # Vue composition functions
│   ├── router/                    # Vue Router configuration
│   ├── views/                     # Page components
│   └── main.js                    # Application entry point
└── public/                        # Public assets
```

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer 2.x
- Node.js 20.19+ or 22.12+
- npm or yarn
- MySQL 8.0+ / PostgreSQL 13+ / SQLite 3.x

### Backend Setup

1. Clone the repository:
```bash
git clone https://github.com/yourusername/gym-system.git
cd gym-system/backend
```

2. Install PHP dependencies:
```bash
composer install
```

3. Create environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gym_system
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run database migrations:
```bash
php artisan migrate
```

7. Seed the database (optional):
```bash
php artisan db:seed
```

8. Start the development server:
```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

### Frontend Setup

1. Navigate to frontend directory:
```bash
cd ../frontend
```

2. Install dependencies:
```bash
npm install
```

3. Configure API endpoint in `src/main.js`:
```javascript
axios.defaults.baseURL = 'http://localhost:8000/api/v1';
```

4. Start the development server:
```bash
npm run dev
```

The application will be available at `http://localhost:5173`

## Configuration

### Backend Configuration

#### CORS Settings
Configure CORS in `config/cors.php`:
```php
'paths' => ['api/*'],
'allowed_origins' => ['http://localhost:5173'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

#### API Versioning
API routes are versioned under `/api/v1/`. Update `routes/api.php` to add new versions.

#### Authentication
Sanctum is configured for SPA authentication. Token expiration and other settings can be modified in `config/sanctum.php`.

### Frontend Configuration

#### Environment Variables
Create `.env.local` for local development:
```env
VITE_API_URL=http://localhost:8000/api/v1
```

#### Router Configuration
Base routes are defined in `src/router/index.js`. Protected routes require authentication.

## API Documentation

### Authentication Endpoints

#### Register
```http
POST /api/v1/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

#### Login
```http
POST /api/v1/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}
```

#### Logout
```http
POST /api/v1/logout
Authorization: Bearer {token}
```

### Member Endpoints

#### List Members
```http
GET /api/v1/members?page=1&search=john
Authorization: Bearer {token}
```

#### Create Member
```http
POST /api/v1/members
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "phone_number": "+1234567890",
  "address": "123 Main St",
  "date_of_birth": "1990-01-01",
  "gender": "male",
  "status": "allowed"
}
```

#### Update Member
```http
PUT /api/v1/members/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "John Updated",
  "status": "banned"
}
```

#### Delete Member
```http
DELETE /api/v1/members/{id}
Authorization: Bearer {token}
```

### Membership Endpoints

#### List Memberships
```http
GET /api/v1/memberships?page=1
Authorization: Bearer {token}
```

#### Create Membership
```http
POST /api/v1/memberships
Authorization: Bearer {token}
Content-Type: application/json

{
  "member_id": 1,
  "plan_id": 2,
  "start_date": "2024-01-01",
  "end_date": "2024-12-31",
  "status": "active"
}
```

### Plan Endpoints

#### List Plans
```http
GET /api/v1/plans
Authorization: Bearer {token}
```

#### Create Plan
```http
POST /api/v1/plans
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Premium Monthly",
  "description": "Full gym access",
  "price": 99.99,
  "duration_in_days": 30
}
```

### Dashboard Endpoint

#### Get Dashboard Data
```http
GET /api/v1/dashboard
Authorization: Bearer {token}
```

Returns comprehensive analytics including:
- Total members, memberships, payments
- Membership status breakdown
- Invoice statistics
- Monthly revenue charts
- Recent activity tables

## Database Schema

### Members Table
```sql
- id: bigint (primary key)
- name: varchar(255)
- email: varchar(255) unique
- phone_number: varchar(20)
- address: text
- date_of_birth: date
- gender: enum('male', 'female', 'other')
- status: enum('allowed', 'banned')
- created_at: timestamp
- updated_at: timestamp
```

### Plans Table
```sql
- id: bigint (primary key)
- name: varchar(255)
- description: text
- price: decimal(10,2)
- duration_in_days: integer
- created_at: timestamp
- updated_at: timestamp
```

### Memberships Table
```sql
- id: bigint (primary key)
- member_id: bigint (foreign key)
- plan_id: bigint (foreign key)
- start_date: date
- end_date: date
- status: enum('active', 'expired', 'frozen', 'canceled')
- created_at: timestamp
- updated_at: timestamp
```

### Payments Table
```sql
- id: bigint (primary key)
- membership_id: bigint (foreign key)
- amount: decimal(10,2)
- payment_date: date
- method: enum('cash', 'credit_card', 'bank_transfer')
- created_at: timestamp
- updated_at: timestamp
```

### Invoices Table
```sql
- id: bigint (primary key)
- membership_id: bigint (foreign key)
- number: varchar(255) unique
- total_amount: decimal(10,2)
- status: enum('paid', 'unpaid', 'partial')
- created_at: timestamp
- updated_at: timestamp
```

## Usage

### Running the Application

#### Development Mode
Start both backend and frontend servers:

```bash
# Terminal 1 - Backend
cd backend
php artisan serve

# Terminal 2 - Frontend
cd frontend
npm run dev
```

#### Production Build

Backend:
```bash
cd backend
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Frontend:
```bash
cd frontend
npm run build
```

The production build will be in `frontend/dist/`

### Common Tasks

#### Create a New Member
1. Navigate to Members page
2. Click "New Member" button
3. Fill in member details
4. Submit the form

#### Create a Subscription
1. Navigate to Memberships page
2. Click "New Membership" button
3. Select member and plan
4. Set start and end dates
5. Submit the form

#### View Analytics
1. Navigate to Dashboard
2. View real-time statistics
3. Analyze charts for trends
4. Review recent activity tables

## Testing

### Backend Tests

Run all tests:
```bash
cd backend
php artisan test
```

Run specific test suite:
```bash
php artisan test --testsuite=Feature
```

Run with coverage:
```bash
php artisan test --coverage
```

### Frontend Tests

```bash
cd frontend
npm run test
```

## Deployment

### Backend Deployment

1. Set up production environment variables
2. Configure web server (Apache/Nginx)
3. Point document root to `backend/public`
4. Set proper file permissions:
```bash
chmod -R 755 storage bootstrap/cache
```

5. Run optimization commands:
```bash
php artisan optimize
```

### Frontend Deployment

1. Build production assets:
```bash
npm run build
```

2. Deploy `dist/` directory to web server
3. Configure web server for SPA routing

### Recommended Production Stack
- Web Server: Nginx
- Process Manager: Supervisor (for queue workers)
- Cache: Redis
- Database: MySQL 8.0+
- SSL: Let's Encrypt

## Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Code Standards
- Follow PSR-12 for PHP code
- Use Laravel best practices
- Follow Vue.js style guide
- Write meaningful commit messages
- Add tests for new features

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contact

Project Link: [https://github.com/yourusername/gym-system](https://github.com/yourusername/gym-system)

## Acknowledgments

- Laravel Framework
- Vue.js Framework
- Tailwind CSS
- Chart.js
- All open-source contributors
