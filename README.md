...existing code...
# Payment Management

A Laravel-based payment management application (front-end assets bundled in `public/`).  
Quick reference for setup, configuration, testing and useful files.

## Requirements
- PHP 8.x
- Composer
- Node.js & npm / Yarn
- MySQL (or other DB supported by Laravel)

## Quick install
1. Clone the repo.
2. Install PHP dependencies:
   ```sh
   composer install
   ```
3. Install JS dependencies and build assets:
   ```sh
   npm install
   npm run dev     # or npm run prod for production
   ```
4. Copy env and generate app key:
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```
5. Configure DB in `.env` and run migrations:
   ```sh
   php artisan migrate
   ```

## Useful configuration files
- Mailer: [config/mail.php](config/mail.php) (default set via `MAIL_MAILER`)
- Database: [config/database.php](config/database.php)
- Logging: [config/logging.php](config/logging.php)
- Composer: [composer.json](composer.json)
- Webpack / Mix: [webpack.mix.js](webpack.mix.js)
- PHPUnit config: [phpunit.xml](phpunit.xml) — note `MAIL_MAILER` is set to `array` for tests.

## Routes & entrypoints
- Web routes: [routes/web.php](routes/web.php)
- API routes: [routes/api.php](routes/api.php)
- Default post-auth redirect: constant [`App\Providers\RouteServiceProvider::HOME`](app/Providers/RouteServiceProvider.php)

## Key source files
- Payment library: [app/Lib/Payfort.php](app/Lib/Payfort.php) — primary Payfort integration class (`App\Lib\Payfort`).
- Route service provider: [app/Providers/RouteServiceProvider.php](app/Providers/RouteServiceProvider.php)
- Front-end bundle: [public/js/app.js](public/js/app.js)
- CSS assets: [public/assets/css/corporate-ui-dashboard.css](public/assets/css/corporate-ui-dashboard.css)
- Blade view examples: [resources/views/welcome.blade.php](resources/views/welcome.blade.php)

## Testing
- Base test case: [`Tests\TestCase`](tests/TestCase.php) — [tests/TestCase.php](tests/TestCase.php)
- Example tests:
  - Feature: [tests/Feature/ExampleTest.php](tests/Feature/ExampleTest.php)
  - Unit: [tests/Unit/ExampleTest.php](tests/Unit/ExampleTest.php)
- Run tests:
  ```sh
  ./vendor/bin/phpunit
  ```

## Common artisan commands
- Serve: `php artisan serve`
- Migrate: `php artisan migrate`
- Seed: `php artisan db:seed`
- Clear caches:
  ```sh
  php artisan config:clear
  php artisan cache:clear
  php artisan route:clear
  php artisan view:clear
  ```

## Notes & troubleshooting
- Ensure `storage/` and `bootstrap/cache/` are writable by web server.
- `.env` is excluded from git; use `.env.example` as template.
- Tests run with `MAIL_MAILER=array` (see [phpunit.xml](phpunit.xml)) to avoid sending emails.

## Contributing
- Follow PSR-12 coding style.
- Run tests and asset build before opening PRs.

## License
See repository root for license information.

...existing code...