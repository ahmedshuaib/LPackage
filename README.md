# LPackage

LPackage is a Laravel package that simplifies the process of creating and managing Laravel packages. It automatically generates all necessary files and folders for package development, including views, routes, controllers, migrations, models, providers, events, resources, configuration files, middleware, and exception handling.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Installation

To install LPackage, run the following command:

```
composer require ahmedshuaib/lpackage
```

After installation, register the service provider in your `config/app.php` file:

```php
'providers' => [
    // ...
    AhmedShuaib\LPackage\LPackageServiceProvider::class,
],
```

## Usage

To generate a new Laravel package, run the following Artisan command:

```
php artisan make:package <Package Name>
```

Replace `<Package Name>` with the desired name for your package.

This command will generate all necessary files and folders for your package, including:

- Views
- Routes
- Controllers
- Migrations
- Models
- Providers
- Events
- Resources
- Configuration files
- Middleware
- Exception handling

## Contributing

We welcome contributions to improve LPackage and add new features. To contribute, please follow these steps:

1. Fork the repository on GitHub.
2. Clone your fork locally.
3. Create a new branch for your feature or bugfix.
4. Make your changes and commit them to your branch.
5. Push your changes to your fork on GitHub.
6. Open a pull request on the original repository.

Please ensure that your code is formatted according to the PSR-12 coding standard and that your tests pass before submitting a pull request.

## License

LPackage is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
