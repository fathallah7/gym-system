# Gym Management System

A full-stack **Gym Management System** built with **Laravel 12** (API backend) and **Vue 3** (frontend), styled with **Tailwind CSS** and secured using **Laravel Sanctum**.

---

## Features

### Member & Plan Management
- Complete CRUD for **Members**: add, edit, delete, and view detailed profiles.
- CRUD for **Subscription Plans** (monthly, yearly, or custom).

### Memberships & Invoices
- Automatic invoice generation when a membership is created.
- Support for **partial payments / installments** with real-time balance tracking.
- Email notifications for:
  - New invoices  
  - Payment updates (amount paid, remaining balance)  

### Dashboard & Analytics
- Interactive charts and KPIs:
  - Total members, active subscriptions, expired plans
  - Paid vs. unpaid vs. installment statistics

### Authentication & Security
- Login, Logout, and Password Reset flows.
- SPA-friendly API authentication via **Laravel Sanctum**.
- CSRF protection and input validation.

---

## 🛠 Tech Stack

| Layer        | Technology                        |
|--------------|------------------------------------|
| **Backend**  | Laravel 12, MySQL |
| **Frontend** | Vue 3, Vite, Tailwind CSS         |
| **Auth**     | Laravel Sanctum                   |

---

## 🚀 Demo

- **Live Demo:** [https://gymsystem.abdullah.top](https://gymsystem.abdullah.top)  

Test Credentials:  
email: admin@admin.com
password: 12345678
