# Agendum SDK - Claude Code Documentation

## Overview

This is the Agendum SDK for PHP applications. It provides a convenient interface to interact with the Agendum API through easy-to-use manager classes.

## Project Structure

```
src/
├── Modules/
│   └── ModuleManager.php    # Module management operations
├── Users/
│   └── UserManager.php      # User management operations
└── Records/
    └── RecordManager.php    # Record management operations

tests/
├── Modules/
│   └── ModuleManagerTest.php
├── Users/
│   └── UserManagerTest.php
├── Records/
│   └── RecordManagerTest.php
├── Pest.php
└── TestCase.php

docs/
├── modules.md
├── users.md
└── records.md
```

## Namespaces

- **Agendum\Sdk\Modules**: Module operations (install, enable, disable, etc.)
- **Agendum\Sdk\Users**: User operations (CRUD, activation, search, etc.)
- **Agendum\Sdk\Records**: Record operations (CRUD, bulk operations, archiving, etc.)

## API Integration

The SDK acts as a wrapper around the Agendum\Api namespace, providing convenient static methods for common operations. Each manager class corresponds to API endpoints:

- `Agendum\Api\Modules\*` → `Agendum\Sdk\Modules\ModuleManager`
- `Agendum\Api\Users\*` → `Agendum\Sdk\Users\UserManager`
- `Agendum\Api\Records\*` → `Agendum\Sdk\Records\RecordManager`

## Development Commands

### Testing
```bash
# Run all tests with PestPHP
./vendor/bin/pest

# Run specific test suite
./vendor/bin/pest tests/Modules
./vendor/bin/pest tests/Users
./vendor/bin/pest tests/Records

# Run with coverage
./vendor/bin/pest --coverage
```

### Code Quality
```bash
# Static analysis with PHPStan
./vendor/bin/phpstan analyse

# Code style checking
composer run-script cs-check

# Code style fixing
composer run-script cs-fix
```

### Installation
```bash
# Install dependencies
composer install

# Install dev dependencies
composer install --dev
```

## Usage Examples

### Module Operations
```php
use Agendum\Sdk\Modules\ModuleManager;

// Create a new module
ModuleManager::create('my-module', ['description' => 'My custom module']);

// Install and enable a module
ModuleManager::install('module-name');
ModuleManager::enable($moduleId);

// Check module status
if (ModuleManager::isEnabled('module-name')) {
    // Module is enabled
}
```

### User Operations
```php
use Agendum\Sdk\Users\UserManager;

// Create a new user
UserManager::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => 'secure-password'
]);

// Search users
$users = UserManager::search('john');

// Activate/deactivate user
UserManager::activate($userId);
UserManager::deactivate($userId);
```

### Record Operations
```php
use Agendum\Sdk\Records\RecordManager;

// Create a record
RecordManager::create([
    'title' => 'My Document',
    'type' => 'document',
    'content' => 'Document content here'
]);

// Bulk operations
RecordManager::bulkCreate($recordsArray);
RecordManager::bulkUpdate($updatesArray);

// Archive/restore
RecordManager::archive($recordId);
RecordManager::restore($recordId);

// Duplicate record
RecordManager::duplicate($recordId, ['title' => 'Copy of original']);
```

## Contributing

1. All new features should include PHPDoc documentation
2. Add corresponding PestPHP tests for new methods
3. Follow PSR-4 autoloading standards
4. Maintain consistency with existing API patterns

## Architecture Notes

- All manager classes use static methods for simplicity
- Each method corresponds to a specific API endpoint
- Error handling is delegated to the underlying API classes
- The SDK follows the facade pattern for ease of use