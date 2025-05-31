# 🌐 VILTURA

A modern full-stack skeleton project using **Laravel 12**, **Inertia.js**, **Vue 3**, and **Vue Notification** — the perfect starter kit for building scalable, reactive web applications with both frontend and backend in sync.

---

## 🚀 Features

-   Laravel 12 (PHP 8.2+)
-   Vue 3 via Inertia.js
-   RESTful API structure (basic)
-   Vue Notification system
-   Authentication scaffolding (Laravel Breeze)
-   Modular structure for clean separation of concerns
-   Pre-configured with Vite, ESLint, and Prettier (optional)

---

## 🧪 Quick Start

### 1. Clone the Repository & Rename Project

```bash
git clone https://github.com/kakapa/laravel-breeze-vilt-skeleton.git your-new-project-name
cd your-new-project-name
```

### 2. Initialize Your Git Repository

```bash
rm -rf .git
git init
git remote add origin git@github.com:your-username/your-new-project-name.git
git add .
git commit -m "Initial commit"
git push -u origin main
```

---

### 3. Configure Deployment (Optional)

> If you're setting up CI/CD with GitHub Actions to auto-deploy to an EC2 server:

-   Add your private SSH deployment key to `~/.ssh/github_deploy_key`
-   Upload the public key to your GitHub repo under **Settings → Deploy Keys**

Create the following **GitHub Secrets**:

-   `EC2_SSH_KEY` – Your private SSH deploy key (base64 encoded)
-   `EC2_ENDPOINT` – Your EC2 server IP or DNS (e.g., `ec2-user@x.x.x.x`)
-   `EC2_APP_DEPLOY_PATH` – Directory where the app will be deployed (e.g., `/var/www/viltura/deploy.sh`)

#### Update the following:

-   `.github/workflows/deploy.yml` with:

    -   Your actual `EC2_SSH_KEY`, `EC2_ENDPOINT`, `EC2_APP_DEPLOY_PATH`

-   `deploy.sh` script with:

    -   SSH login steps
    -   Git pull
    -   Composer install
    -   Laravel migrate & cache commands
    -   Restart app services (e.g., Docker, Supervisor, Nginx, etc.)

> **If not using GitHub Actions**, you may want to ignore the deployment files:

```
# .gitignore
deploy.sh
.github/workflows/deploy.yml
```

---

### 4. Set Up the Environment

```bash
cp .env.example .env
```

Edit `.env` to match your configuration:

-   App name, environment, and ports
-   Database connection settings
-   Redis/Mail settings as needed

Generate application key:

```bash
php artisan key:generate
```

---

### 5. Install Dependencies

```bash
composer install
npm install && npm run dev
```

---

### 6. Run the Application

#### If using Laravel Sail (Docker):

```bash
./vendor/bin/sail up -d
```

#### If using the native PHP server:

```bash
php artisan serve
```

---

## ✅ You’re Ready!

Start building your Laravel + Inertia.js + Vue 3 app on a modern, scalable foundation.

---

## 🛠 Bonus: Suggested Folder Structure

-   `app/Http/Controllers`: API and Web controllers
-   `resources/js/Pages`: Inertia.js Vue 3 page components
-   `resources/js/Components`: Shared Vue components
-   `routes/web.php`: Web routes for Inertia pages
-   `routes/api.php`: API endpoints for frontend consumption

---

## 📦 Optional Add-ons

-   Vue Router
-   Vuex or Pinia (if using complex state)
-   Tailwind CSS (preconfigured with Breeze)
-   Axios for API requests

---

Happy coding! 🚀
