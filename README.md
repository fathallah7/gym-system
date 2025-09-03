<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" height="100"  alt="Laravel Logo">
  </a>
  
  <a href="https://vuejs.org" target="_blank">
    <img src="https://upload.wikimedia.org/wikipedia/commons/9/95/Vue.js_Logo_2.svg" height="80" alt="Vue.js Logo">
  </a>
</p>


# Gym Management System

A full-stack **Gym Management System** built with **Laravel** (API backend) and **Vue.js** (frontend).  
It helps gym owners manage members, plans, memberships, payments, invoices, and attendance efficiently.

---

## Features

### Authentication & Authorization

- Secure **login** and **reset password** system.
- Role-based access control.

### Members Management

- Full **CRUD** operations.
- Store contact details and membership status.

### Plans Management

- Create and manage subscription plans.
- Set duration and pricing.

### Memberships

- Assign plans to members.
- Track active and expired memberships.
- Relational data between **members** and **plans**.

### Payments & Invoices

- Add payments for memberships.
- **Partial payment support**.
- Automatically send **invoice via email** after each payment.
- View all payment history.

### Dashboard 

- KPIs & statistics for quick insights.
- Revenue charts, popular plans, active members count, and more.

### Attendance

- Record member check-ins.
- Search by name, ID, or QR code.
- View daily attendance reports.

---

## 🛠️ Tech Stack

**Backend:**

- [Laravel](https://laravel.com/) – RESTful API backend
- [Laravel Sanctum](https://laravel.com/docs/sanctum) – API authentication
- [Laravel Breeze](https://laravel.com/docs/starter-kits#breeze) – Auth scaffolding with Vue.js
- MySQL – Database
- Laravel Mail – Email invoices

**Frontend:**

- [Vue.js](https://vuejs.org/) – SPA frontend
- [Vue Router](https://router.vuejs.org/) – Client-side routing
- Axios – API requests
- Vue Toast Notifications – Alerts and toasts
- Tailwind CSS – Styling



---

