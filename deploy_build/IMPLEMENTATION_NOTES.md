# Implementation Notes

To ensure continuity based on `project_awareness.md`, the following files and folders have been created to implement a beginner-friendly MVC architecture.

### Directories Created:
- `/config` - Holds database configuration.
- `/core` - Holds core logical engine elements (router, base controller).
- `/controllers` - Contains application logic (e.g., Home).
- `/models` - Contains database interaction scripts (e.g., User).
- `/views` - Contains layout and module-based HTML views.
- `/public` - Serving point, containing CSS, JS, and `index.php`.

### Files Created:
1. `.env` - Environment configurations for secure DB access.
2. `config/Database.php` - PDO implementation.
3. `core/App.php` - Router to parse URLs into Controller/Method calls.
4. `core/Controller.php` - Base controller to load models and views.
5. `public/index.php` - Front controller that loads everything.
6. `public/.htaccess` - Mod_rewrite instructions for clean URLs.
7. `controllers/HomeController.php` - Example controller.
8. `models/User.php` - Example model using prepared statements.
9. `views/layout/header.php` and `footer.php` - Base UI templates using Bootstrap 5.
10. `views/home/index.php` and `about.php` - Sample functional views.
11. `README.md` - Documentation tailored for beginner programmers exploring the system.

This foundation adheres to the architecture specified in `project_awareness.md` while remaining simple enough for a beginner to extend and structure further.
