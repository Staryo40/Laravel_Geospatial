# Laravel Geospatial Web App (Intern Case Study)

This repository contains the scaffolded skeleton for a "frontend-heavy" Laravel 11 geospatial web application. The project is pre-configured to be stateless, requires no database management, and is fully ready for a serverless Vercel deployment.

---

## 🛠️ Project Features

- **Laravel 11 Skeleton**: Clean, lightweight architecture with default configuration tailored for high-speed serverless executions.
- **Tailwind CSS v4 & Vite**: Blazing fast compilation and styling directly integrated into Vite.
- **Vercel Serverless Ready**: Root `vercel.json` and `api/index.php` routing bridge.
- **Stateless Configuration**: Database operations are disabled, session drivers are cookie-based, and cache is set to in-memory/temporary directories.
- **MapLibre GL JS Integration**: Clean interactive map skeleton loaded from CDN, pre-configured with a premium dark-matter style and real-time coordinate tracking.
- **Fallback 404 Page**: Custom, responsive error page for unmatched endpoints.

---

## 🚀 Setup & Installation

Follow these steps to set up the project on your local machine:

### 1. Install Dependencies
Run the following commands to install backend (Composer) and frontend (npm) dependencies:

```bash
# Install PHP Composer dependencies
composer install

# Install Node.js dependencies
npm install
```

### 2. Configure Environment
A default `.env` file is generated during initial creation. If it does not exist, copy `.env.example` to `.env`:

```bash
copy .env.example .env
```

### 3. Generate Application Key
If the application key is not set, generate one using:

```bash
php artisan key:generate
```

---

## 💻 Local Development

To run the application locally, start both the PHP development server and Vite asset compiler:

### 1. Start Laravel Server
In one terminal window, run:

```bash
php artisan serve
```
*The app will be accessible at `http://127.0.0.1:8000`.*

### 2. Start Vite Dev Server (for Hot Reloading)
In another terminal window, run:

```bash
npm run dev
```

---

## 📦 Production & Deployment

### Build Assets
Before deploying or compiling for production, build the static assets:

```bash
npm run build
```

### Deploying to Vercel
This project includes pre-configured routing for Vercel. 

To deploy:
1. Install the Vercel CLI: `npm install -g vercel`
2. Run the deployment command from the project root:
   ```bash
   vercel
   ```
3. Set your environment variables in Vercel settings (e.g., copy your `.env` variables like `APP_KEY`, `APP_ENV=production`, etc.).

---

## 📂 Directory Layout

```text
├── api/
│   └── index.php             # Vercel serverless function entry bridge
├── bootstrap/
│   └── app.php               # Laravel bootstrap configuration
├── config/                   # Custom settings (session, cache, etc.)
├── public/                   # Static public assets
├── resources/
│   ├── css/
│   │   └── app.css           # Global CSS with Tailwind v4 imports
│   ├── js/
│   │   └── app.js            # Main application JS script
│   └── views/
│       ├── errors/
│       │   └── 404.blade.php # Custom responsive 404 Page
│       ├── layouts/
│       │   └── app.blade.php # Master HTML5 responsive layout
│       ├── landing.blade.php # Landing & Case Study Page
│       └── map.blade.php     # Live Map viewer with MapLibre GL JS
├── routes/
│   └── web.php               # Web routing definition
├── tailwind.config.js        # Legacy template scanning mappings
├── vercel.json               # Vercel serverless routing config
└── README.md                 # Project instructions and documentation
```

## Laravel Template Dir
Here is a list of the directories in the project that remain **completely unmodified** and are exactly as they were created by the default Laravel 11 template:

- `app/`: Contains the core application code (Models, HTTP Controllers, Middleware, and Providers).
- `bootstrap/`: Handles application bootstrapping (`app.php` and `providers.php`).
- `config/`:(file:///c:/Users/Aryo/PersonalMade/SoftwareProjects/MAPID_Internship/Selection_Laravel%20Geospatial/config)**: Holds all standard Laravel configuration files (e.g., `app.php`, `database.php`, `session.php`).
- `database/`(file:///c:/Users/Aryo/PersonalMade/SoftwareProjects/MAPID_Internship/Selection_Laravel%20Geospatial/database)**: Stores migrations, seeders, and factories (only `database.sqlite` was automatically generated during installation).
- `storage/`(file:///c:/Users/Aryo/PersonalMade/SoftwareProjects/MAPID_Internship/Selection_Laravel%20Geospatial/storage)**: Used for compiled Blade views, sessions, cache, and logs.
- `tests/`(file:///c:/Users/Aryo/PersonalMade/SoftwareProjects/MAPID_Internship/Selection_Laravel%20Geospatial/tests)**: Contains default PHPUnit/Pest testing classes.