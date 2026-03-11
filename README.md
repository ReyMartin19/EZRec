# EZRec: Medal tally

**EZRec** is a streamlined dashboard built with **Laravel 11**, **Inertia.js**, and **Vue 3**. It features a modern "Modal-first" workflow and real-time data updates using **Shadcn UI**.

---

## 🛠 Prerequisites

Before starting, ensure you have the following installed:
* **PHP 8.2+**
* **Composer**
* **Node.js (v18+) & npm**
* **XAMPP** (for Local MySQL Database)

---

## Installation Steps

### 1. Clone & Enter the Repo
Open your terminal and run:
```bash
git clone https://github.com/yourusername/ezrec.git
cd ezrec
```

---

### 2. Database Setup (XAMPP)
1. Open the **XAMPP Control Panel**.
2. Start **Apache** and **MySQL**.
3. Click the **Admin** button next to MySQL (or go to `http://localhost/phpmyadmin`).
4. Create a new database named exactly: `ezrec`

---

### 3. Environment Configuration
Copy the example environment file and generate your unique app key.
```bash
# Copy the env file
cp .env.example .env

# Generate the Laravel security key
php artisan key:generate
```

Now, open the `.env` file in your editor (VS Code) and ensure your database settings match XAMPP:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ezrec
DB_USERNAME=root
DB_PASSWORD=
```

---

### 4. Install Dependencies
You need to install both the PHP (backend) and Node (frontend) packages.
```bash
# Install PHP dependencies
composer install

# Install JS dependencies
npm install
```

---

### 5. Migration & Tables
Run the migration command to build the `athletes` and `events` tables in your MySQL database.
```bash
php artisan migrate
```

---

## Running the Development Environment

To run this app, you must keep **two terminals open simultaneously**:

**Terminal 1: The Backend (PHP)**

This serves the Laravel application.
```bash
php artisan serve
```
 Link: http://127.0.0.1:8000

**Terminal 2: The Frontend (Vite)**

This compiles your Vue components and styles in real-time.
```bash
npm run dev
```

---

## 📖 User Quick Start Guide

### 1. Creating Events
Go to the **Events** page first. The Athlete form uses a dropdown that pulls data directly from your events. If you have no events, the athlete's "Sport" dropdown will be empty.

### 2. Managing Athletes
* **Add:** Click the **Add Athlete** button to open the centered Dialog.
* **Edit:** Click **Edit** on any row to load that athlete's data back into the modal for updating.
* **Dynamic Sports:** The "Sport" field is a Select menu synced with your `events` table.

---

## Building for Production

When you are ready to deploy, run the build command to minify all assets for maximum speed:
```bash
npm run build
```

---

## Troubleshooting

| Issue | Solution |
|---|---|
| **Blank Page** | Ensure `npm run dev` is running in your second terminal. |
| **SQL Table Not Found** | Ensure you ran `php artisan migrate` and that XAMPP MySQL is active. |
| **Route [route.name] not defined** | Run `php artisan route:clear` and check your `web.php`. |
