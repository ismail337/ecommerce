# AI Coding Agent Guidelines for Laravel E-commerce Project

## Project Overview

This is a Laravel-based e-commerce platform with a modular structure. It includes features like product management, user authentication, and admin dashboards. The project uses Laravel's MVC architecture, Eloquent ORM, and integrates third-party libraries for specific functionalities.

## Key Components

- **Models**: Located in `app/Models/`, these represent the database tables. Examples include `Product`, `Category`, and `User`.
- **Controllers**: Found in `app/Http/Controllers/`, these handle HTTP requests and business logic.
- **Views**: Stored in `resources/views/`, these contain Blade templates for rendering HTML.
- **Routes**: Defined in `routes/`, with separate files for `web.php`, `api.php`, and `admin.php`.
- **DataTables**: Custom DataTables for admin panels are in `app/DataTables/`.
- **Traits**: Shared functionality is implemented in traits like `imageUploadTrait` in `app/Traits/`.

## Developer Workflows

### Running the Application

1. Install dependencies: `composer install` and `npm install`.
2. Set up the environment: Copy `.env.example` to `.env` and configure database credentials.
3. Run migrations: `php artisan migrate`.
4. Start the development server: `php artisan serve`.

### Testing

- Feature and unit tests are located in `tests/Feature/` and `tests/Unit/`.
- Run tests using: `php artisan test`.

### Debugging

- Use Laravel's built-in debugging tools like `dd()` and `Log`.
- Check logs in `storage/logs/`.

## Project-Specific Conventions

- **Blade Templates**: Use `@extends` and `@section` for layout inheritance.
- **Eloquent Relationships**: Follow Laravel's naming conventions for relationships (e.g., `hasMany`, `belongsTo`).
- **Validation**: Use Form Request classes in `app/Http/Requests/` for input validation.
- **DataTables**: Extend `Yajra\DataTables\DataTable` for custom admin tables.

## External Dependencies

- **Yajra DataTables**: For server-side processing of tables.
- **Spatie Packages**: For roles and permissions.
- **Tailwind CSS**: For styling, configured in `tailwind.config.js`.
- **jQuery Plugins**: For features like image upload preview and carousels.

## Integration Points

- **APIs**: Defined in `routes/api.php`, with controllers in `app/Http/Controllers/Api/`.
- **Admin Panel**: Routes in `routes/admin.php`, views in `resources/views/admin/`.
- **Frontend**: Public assets are in `public/frontend/`.

## Examples

### Adding a New Model

1. Create the model: `php artisan make:model ModelName`.
2. Add migration: `php artisan make:migration create_model_name_table`.
3. Define relationships in the model.
4. Create a controller: `php artisan make:controller ModelNameController`.
5. Add routes in the appropriate file.

### Creating a DataTable

1. Generate the DataTable: `php artisan datatables:make DataTableName`.
2. Define the query and columns in the generated class.
3. Use the DataTable in the controller.

## Notes

- Follow Laravel's coding standards and PSR-4 autoloading.
- Document any new features or changes in the `README.md`.

For more details, refer to the Laravel documentation: https://laravel.com/docs.
