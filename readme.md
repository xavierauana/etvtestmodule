# README

## Laravel Test and Lesson Module

This Laravel package is designed to facilitate the creation and grading of tests and lessons. It provides a robust and
flexible way to manage educational content within your Laravel application.

### Features

- Create, update, and delete tests.
- Grade tests based on user input.
- Manage lessons associated with tests.

### Installation

To install this package, you need to have Composer and Laravel installed on your system. If you haven't installed them
yet, you can download them from their official websites.

Once you have Composer and Laravel installed, you can install the package via Composer:

```bash
composer require anacreation/etvtest
```

### Usage

After installing the package, you can use it in your Laravel application. Here's a basic usage example:

```php
use Anacreation\Etvtest\Services\TestServices;

$testService = new TestServices();
$test = $testService->createTest($testableObject, ['title' => 'My Test']);
```

### Configuration

This package uses Laravel's default database connection. Make sure to configure your database connection in your `.env`
file.

### Contributing

Contributions are welcome. Please make sure to read the [CONTRIBUTING](CONTRIBUTING.md) guide before making a pull
request.

### License

This package is open-sourced software licensed under the [MIT license](LICENSE.md).

### Support

If you encounter any problems or have any suggestions, please open an issue on the GitHub repository.

### Credits

- Xavier Au (Author)
