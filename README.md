# 🧾 PWD Record Management System

A web-based **PWD Record Management System** to manage records and services for Persons With Disabilities (PWDs). The application centralizes person profiles, assistance records, appointments, payments, and reporting for administrators and staff.

## 🚀 Project Overview

This project is built with **PHP** and **CodeIgniter 4**, following the MVC architecture, and uses **MySQL/MariaDB** for persistent storage. It provides CRUD tools for maintaining PWD profiles, logging assistance and services, scheduling appointments, recording payments, and generating administrative reports.

## 👥 User Roles

### 1. Administrator

Administrators can:

* View the system dashboard and summary statistics.
* Manage PWD profiles (create, edit, search, archive).
* Record assistance/services and appointments.
* Manage payments and receipts.
* Generate reports and export data.
* Manage user accounts and system settings.

### 2. Staff

Staff users can perform day-to-day tasks according to their permissions, such as registering PWDs, recording service delivery, scheduling appointments, and assisting with payments.

## 🧩 Key Features

| **Feature**                 | **Description**                                                       |
| --------------------------: | --------------------------------------------------------------------- |
| **PWD Management**          | Register, edit, search, and archive PWD profiles.                     |
| **Assistance Records**      | Log services, assistance details, and outcomes.                       |
| **Appointments**            | Schedule and manage appointments with reminders.                      |
| **Payment Tracking**        | Record payments, generate receipts, and view payment history.         |
| **Reporting**               | Generate reports for services, payments, and program metrics.         |
| **Authentication**          | Login with role-based access control and password protection.         |
| **Audit Logs**              | Track important user actions for accountability.                      |

## 🏗️ System Architecture

The project follows the **Model-View-Controller (MVC)** pattern provided by CodeIgniter 4.

* **Controllers** – Handle incoming requests and coordinate responses.
* **Models** – Encapsulate database operations and business logic.
* **Views** – Render HTML and front-end templates.
* **Routes** – Map URLs to controllers and actions.

## 🗄️ Database

The system uses **MySQL/MariaDB** to store core data, including:

* Users
* PWD profiles
* Assistance / service records
* Appointments
* Payments
* Audit logs

If a SQL dump is provided in the repository, it will usually be located in the `Database/` folder.

## 🔐 Demo Credentials

Use this account for demo/local access:

| **Account**  | **Credentials** |
| ------------ | --------------- |
| **Username** | `admin`         |
| **Password** | `password`      |
| **Role**     | Administrator   |

> **Note:** These credentials are for local/demo use only. Change them in production.

## 🛠️ Technologies Used

* **PHP 8.1+**
* **CodeIgniter 4**
* **MySQL / MariaDB**
* **HTML / CSS / JavaScript**
* **Composer**

## 💻 How to Install & Run

### 1. Requirements

Install the following on your development machine:

* **PHP 8.1+**
* **Composer**
* **MySQL / MariaDB**
* A local PHP environment such as **XAMPP**, **Laragon**, or similar

### 2. Download the Project

Clone the repository:

```bash
git clone https://github.com/chardoxx-3/PWD-Record-Management-System.git
cd PWD-Record-Management-System
```

### 3. Install Dependencies

Run Composer inside the project folder:

```bash
composer install
```

### 4. Configure Environment

Copy the environment example and update database settings:

```powershell
copy env .env
```

Open `.env` and set your database connection values, for example:

```env
database.default.hostname = localhost
database.default.database = pwd_records
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 5. Create / Import Database

Create a database (for example `pwd_records`) and import any SQL dump included in `Database/` if present.

### 6. Run the Development Server

Start CodeIgniter's built-in server:

```bash
php spark serve
```

Open your browser at:

```text
http://localhost:8080
```

### 7. Login

Use the demo administrator credentials above to sign in.

## 🔄 Typical Workflow

Login → Dashboard → Register PWD → Record Assistance → Schedule Appointment → Record Payment → Generate Report

## 🎯 Purpose

This project demonstrates practical skills in web development, data management, MVC architecture, CRUD operations, authentication, scheduling, and reporting for social service programs.

## 📸 Preview

An example screenshot is available in the `screenshots/` folder if included in the repository.

---

If you'd like, I can also add a project-specific database dump reference, update the demo credentials, or adjust any section to match your deployment environment.
