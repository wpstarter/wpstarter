# WpStarter
<p align="center">
<a href="https://github.com/wpstarter/framework/actions"><img src="https://github.com/wpstarter/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/wpstarter/framework"><img src="https://img.shields.io/packagist/dt/wpstarter/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/wpstarter/framework"><img src="https://img.shields.io/packagist/v/wpstarter/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/wpstarter/framework"><img src="https://img.shields.io/packagist/l/wpstarter/framework" alt="License"></a>
</p>

A starter application for building WordPress features with Laravel-style architecture, powered by `wpstarter/framework` ^2.1. It runs as a WordPress plugin and provides a structured starting point for custom pages, APIs, shortcodes, and admin screens.

## Core features

- **Routing and controllers:** web and API routes with middleware, validation, and rate limiting.
- **Blade views:** standalone responses, content inside WordPress pages, and reusable view components.
- **Shortcodes:** controller-based shortcode routes and class-based shortcode rendering.
- **Admin screens:** menu/submenu routes, controllers, views, and admin notices.
- **WordPress integration:** WordPress user authentication, database configuration, mail via `wp_mail`, settings, and translations.
- **Development tools:** service providers, dependency injection, Artisan commands, and Vite for CSS/JavaScript assets.

## Getting started

Requires an installed, configured WordPress site, PHP 8.2+ with OpenSSL, JSON, and PDO, and Composer. Node.js and npm are needed only for frontend assets.

1. Place this project in `wp-content/plugins/wpstarter`.
2. Copy `.env.example` to `.env` and set `APP_URL` to your WordPress site URL. The default `DB_CONNECTION=wpdb` uses the WordPress database configuration.
3. Run from the project directory:

   ```sh
   composer install
   php artisan key:generate
   ```

4. Activate **WpStarter** in the WordPress Plugins screen.

To work on frontend assets:

```sh
npm install
npm run dev     # Development server
npm run build   # Production assets
```

## Project layout

| Path | Purpose |
| --- | --- |
| `main.php`, `WordpressStarter.php` | Plugin entry point and WordPress lifecycle integration |
| `app/Http/` | Controllers and middleware |
| `routes/web.php`, `routes/api.php` | HTTP routes |
| `routes/wp.php`, `app/View/Shortcodes/` | Shortcode routes and classes |
| `app/Admin/` | Admin routes, controllers, middleware, and views |
| `app/Providers/`, `config/` | Service registration and configuration |
| `resources/` | Blade views, translations, CSS, and JavaScript |
| `app/Console/`, `database/` | Commands, scheduling hooks, factories, and seeders |

## Included examples

Visit `/welcome` or `/welcome-page`, or add `[welcome-shortcode]` or `[sample-shortcode]` to WordPress content. A sample admin menu is also registered. The welcome controllers create demo WordPress pages when they do not already exist.
