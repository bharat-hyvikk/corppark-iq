# AGENT.md - Corporate IQ Dashboard

## Commands
- **Build/Test**: `php artisan test` or `vendor/bin/phpunit` for all tests
- **Single Test**: `php artisan test --filter=TestClassName` or `vendor/bin/phpunit tests/Feature/FeatureTest.php`
- **Lint**: `vendor/bin/pint` (Laravel Pint for code formatting)
- **Serve**: `php artisan serve` (dev server at http://localhost:8000)
- **Assets**: `npm run dev` (Vite dev), `npm run build` (production build)
- **Database**: `php artisan migrate`, `php artisan migrate --seed`, `php artisan migrate:fresh --seed`

## Architecture
- **Framework**: Laravel 10 with Bootstrap 5 frontend (Corporate UI Dashboard theme)
- **Database**: MySQL (default), supports PostgreSQL/SQLite 
- **Models**: User, Office, Vehicle, Building, QrCode, InvoiceMgmt (office/vehicle management system)
- **Auth**: Custom auth with role-based permissions (Admin/Building Manager roles)
- **Core Features**: Multi-building office management, vehicle tracking, QR code generation
- **User Types**: Admin (user_type=1, full access), Building Manager (user_type=2, building-scoped)

## Code Style
- **PSR-4 autoloading**: App\\ namespace, Controllers in app/Http/Controllers/
- **Validation**: Always validate requests with custom error messages, use unique constraints for emails/phones
- **Models**: Use Eloquent relationships, withCount() for counts, latest() for ordering
- **Controllers**: Return JSON for AJAX, use pagination with Bootstrap 5 pagination views
- **Routes**: Group by prefix with middleware, use route names for clarity
- **Auth**: Check Auth::user()->user_type for permissions, scope queries by building_id for non-admins
- **Error Handling**: Return structured JSON responses with meaningful error messages and HTTP status codes
