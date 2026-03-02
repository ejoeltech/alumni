# Dore Numa College Warri Alumni Platform (Beginner MVP)

This project is a beginner-friendly implementation of a custom PHP MVC (Model-View-Controller) architecture based on `project_awareness.md`.

## 📂 Architecture Overview

The application separates logic from presentation:
- **Models (`models/`)**: Handle database interaction (e.g., `User.php`).
- **Views (`views/`)**: Handle the HTML output and presentation.
- **Controllers (`controllers/`)**: Act as the middleman. They receive user requests, fetch data from a Model, and send it to a View.
- **Core Engine (`core/`)**: Contains the `App.php` (Router) and `Controller.php` (Base Controller).
- **Public (`public/`)**: The only folder accessible to the browser, containing `index.php` and assets.

## 🚀 How to Run Locally

1. **Start XAMPP**: Ensure Apache and MySQL are running.
2. **Setup Database**:
   - Go to `http://localhost/phpmyadmin`
   - Create a database called `doncosa_alumni`.
3. **Configuration**:
   - Open the `.env` file in the root directory.
   - Adjust `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASS` to match your XAMPP MySQL credentials.
4. **Access the Application**:
   - URL: `http://localhost/doncosa/public/`

## 📚 Coding Standards Used

- **PDO & Prepared Statements**: Prevent SQL injection.
- **`.env` File Parsing**: Keeps sensitive configuration out of version control.
- **Bootstrap 5**: Included via CDN for beginner-friendly, rapid UI styling.
- **Clean URLs**: `public/.htaccess` routes all traffic through `index.php`.
