# Agendum SDK

A PHP SDK for interacting with the Agendum API. This library provides convenient wrapper classes for modules, users, and records management.

## Installation

```bash
composer require agendum/agendum-sdk
```

## Quick Start

```php
<?php

require_once 'vendor/autoload.php';

use Agendum\Sdk\Modules\ModuleManager;
use Agendum\Sdk\Users\UserManager;
use Agendum\Sdk\Records\RecordManager;

// Create a new module
ModuleManager::create('my-module');

// Create a user
UserManager::create([
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);

// Create a record
RecordManager::create([
    'title' => 'My Document',
    'type' => 'document',
    'content' => 'Document content'
]);
```

## Features

### Module Management
- Create, update, delete modules
- Install, uninstall, enable, disable modules
- Search and list modules
- Check module status

### User Management
- CRUD operations for users
- User search and filtering
- Account activation/deactivation
- Email-based user lookup

### Record Management
- Full CRUD operations
- Bulk operations (create, update, delete)
- Record archiving and restoration
- Record duplication
- Type and status-based filtering

## Documentation

For detailed documentation and examples, see the [docs/](./docs/) directory:

- [Modules Documentation](./docs/modules.md)
- [Users Documentation](./docs/users.md)
- [Records Documentation](./docs/records.md)

## API Reference

### Modules

```php
use Agendum\Sdk\Modules\ModuleManager;

// Basic operations
ModuleManager::create($moduleName, $moduleData);
ModuleManager::update($moduleId, $moduleData);
ModuleManager::delete($moduleId);
ModuleManager::get($moduleId);
ModuleManager::list($options);
ModuleManager::search($query, $options);

// Module lifecycle
ModuleManager::install($moduleName, $config);
ModuleManager::uninstall($moduleId, $options);
ModuleManager::enable($moduleId);
ModuleManager::disable($moduleId);

// Utilities
ModuleManager::getByName($moduleName);
ModuleManager::getEnabled();
ModuleManager::getDisabled();
ModuleManager::isInstalled($moduleName);
ModuleManager::isEnabled($moduleName);
```

### Users

```php
use Agendum\Sdk\Users\UserManager;

// Basic operations
UserManager::create($userData);
UserManager::update($userId, $userData);
UserManager::delete($userId);
UserManager::get($userId);
UserManager::list($options);
UserManager::search($query, $options);

// User management
UserManager::getByEmail($email);
UserManager::activate($userId);
UserManager::deactivate($userId);
```

### Records

```php
use Agendum\Sdk\Records\RecordManager;

// Basic operations
RecordManager::create($recordData);
RecordManager::update($recordId, $recordData);
RecordManager::delete($recordId);
RecordManager::get($recordId);
RecordManager::list($options);
RecordManager::search($query, $options);

// Bulk operations
RecordManager::bulkCreate($records, $options);
RecordManager::bulkUpdate($updates, $options);
RecordManager::bulkDelete($recordIds, $options);

// Advanced operations
RecordManager::getByType($type, $options);
RecordManager::getByStatus($status, $options);
RecordManager::archive($recordId);
RecordManager::restore($recordId);
RecordManager::duplicate($recordId, $overrides);
```

## Testing

This project uses PestPHP for testing:

```bash
# Run all tests
./vendor/bin/pest

# Run specific test suite
./vendor/bin/pest tests/Modules
./vendor/bin/pest tests/Users
./vendor/bin/pest tests/Records

# Run with coverage
./vendor/bin/pest --coverage
```

## Development

### Requirements
- PHP 8.0 or higher
- Composer

### Setup
1. Clone the repository
2. Install dependencies: `composer install`
3. Run tests: `./vendor/bin/pest`

### Code Quality
- PHPStan for static analysis
- PSR-4 autoloading
- Comprehensive PHPDoc documentation

## Contributing

1. Fork the project
2. Create a feature branch
3. Add tests for new functionality
4. Ensure all tests pass
5. Submit a pull request

## License

MIT License. See [LICENSE](LICENSE) for details.

## Support

For issues and questions:
- Create an issue on GitHub
- Check the [documentation](./docs/)
- Review the [CLAUDE.md](CLAUDE.md) file for development details