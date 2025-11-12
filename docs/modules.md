# Modules Documentation

The `Agendum\Sdk\Modules\ModuleManager` class provides a convenient interface for managing modules in the Agendum platform.

## Overview

Modules are reusable components that extend the functionality of your Agendum application. The ModuleManager class allows you to perform various operations such as creating, installing, enabling, and managing modules.

## Basic Usage

```php
use Agendum\Sdk\Modules\ModuleManager;

// Create a new module
ModuleManager::create('my-module', [
    'description' => 'My custom module',
    'version' => '1.0.0',
    'author' => 'John Doe'
]);
```

## Available Methods

### CRUD Operations

#### `create($moduleName, $moduleData = [])`
Creates a new module with the specified name and optional configuration data.

**Parameters:**
- `$moduleName` (string): The name of the module
- `$moduleData` (array, optional): Module configuration data

**Example:**
```php
ModuleManager::create('user-auth', [
    'description' => 'User authentication module',
    'version' => '1.0.0',
    'dependencies' => ['base-module']
]);
```

#### `update($moduleId, $moduleData)`
Updates an existing module with new data.

**Parameters:**
- `$moduleId` (int|string): The module identifier
- `$moduleData` (array): Updated module data

**Example:**
```php
ModuleManager::update(1, [
    'description' => 'Updated description',
    'version' => '1.1.0'
]);
```

#### `delete($moduleId)`
Deletes a module.

**Parameters:**
- `$moduleId` (int|string): The module identifier

**Example:**
```php
ModuleManager::delete(1);
```

#### `get($moduleId)`
Retrieves a specific module by ID.

**Parameters:**
- `$moduleId` (int|string): The module identifier

**Example:**
```php
$module = ModuleManager::get(1);
```

### Listing and Searching

#### `list($options = [])`
Lists all modules with optional filtering and pagination.

**Parameters:**
- `$options` (array, optional): Filtering and pagination options

**Example:**
```php
// List all modules
$modules = ModuleManager::list();

// List with pagination
$modules = ModuleManager::list([
    'limit' => 10,
    'offset' => 20,
    'status' => 'enabled'
]);
```

#### `search($query, $options = [])`
Searches modules by criteria.

**Parameters:**
- `$query` (string): Search query
- `$options` (array, optional): Search options and filters

**Example:**
```php
$results = ModuleManager::search('authentication', [
    'limit' => 5,
    'type' => 'security'
]);
```

### Module Lifecycle Management

#### `install($moduleName, $config = [])`
Installs a module from the module repository.

**Parameters:**
- `$moduleName` (string): The name of the module to install
- `$config` (array, optional): Installation configuration

**Example:**
```php
ModuleManager::install('payment-gateway', [
    'auto_enable' => true,
    'environment' => 'production'
]);
```

#### `uninstall($moduleId, $options = [])`
Uninstalls a module.

**Parameters:**
- `$moduleId` (int|string): The module identifier
- `$options` (array, optional): Uninstall options

**Example:**
```php
ModuleManager::uninstall(1, [
    'remove_data' => true,
    'force' => false
]);
```

#### `enable($moduleId)`
Enables a module, making it active in the system.

**Parameters:**
- `$moduleId` (int|string): The module identifier

**Example:**
```php
ModuleManager::enable(1);
```

#### `disable($moduleId)`
Disables a module, making it inactive.

**Parameters:**
- `$moduleId` (int|string): The module identifier

**Example:**
```php
ModuleManager::disable(1);
```

### Utility Methods

#### `getByName($moduleName)`
Retrieves a module by its name.

**Parameters:**
- `$moduleName` (string): The module name

**Example:**
```php
$module = ModuleManager::getByName('user-auth');
```

#### `getEnabled()`
Returns all enabled modules.

**Example:**
```php
$enabledModules = ModuleManager::getEnabled();
```

#### `getDisabled()`
Returns all disabled modules.

**Example:**
```php
$disabledModules = ModuleManager::getDisabled();
```

#### `isInstalled($moduleName)`
Checks if a module is installed.

**Parameters:**
- `$moduleName` (string): The module name

**Returns:** `bool`

**Example:**
```php
if (ModuleManager::isInstalled('payment-gateway')) {
    echo 'Payment gateway module is installed';
}
```

#### `isEnabled($moduleName)`
Checks if a module is enabled.

**Parameters:**
- `$moduleName` (string): The module name

**Returns:** `bool`

**Example:**
```php
if (ModuleManager::isEnabled('user-auth')) {
    echo 'User authentication is enabled';
}
```

## Common Use Cases

### Installing and Configuring a Module
```php
// Install a module
ModuleManager::install('e-commerce', [
    'payment_provider' => 'stripe',
    'currency' => 'USD'
]);

// Enable the module
$module = ModuleManager::getByName('e-commerce');
ModuleManager::enable($module['id']);

// Verify it's working
if (ModuleManager::isEnabled('e-commerce')) {
    echo 'E-commerce module is ready!';
}
```

### Managing Module Dependencies
```php
// Check if required modules are installed
$requiredModules = ['base-auth', 'user-management'];
$missingModules = [];

foreach ($requiredModules as $moduleName) {
    if (!ModuleManager::isInstalled($moduleName)) {
        $missingModules[] = $moduleName;
    }
}

if (empty($missingModules)) {
    // Install your module
    ModuleManager::install('my-custom-module');
} else {
    echo 'Missing required modules: ' . implode(', ', $missingModules);
}
```

### Bulk Module Operations
```php
// Get all disabled modules
$disabledModules = ModuleManager::getDisabled();

// Enable all disabled modules
foreach ($disabledModules as $module) {
    ModuleManager::enable($module['id']);
    echo "Enabled module: {$module['name']}\n";
}
```

## Error Handling

The ModuleManager methods may throw exceptions for various error conditions:

- Invalid module name or ID
- Module not found
- Dependency conflicts
- Permission issues
- Network errors (for remote module operations)

It's recommended to wrap module operations in try-catch blocks:

```php
try {
    ModuleManager::install('complex-module');
    echo 'Module installed successfully';
} catch (Exception $e) {
    echo 'Failed to install module: ' . $e->getMessage();
}
```

## Best Practices

1. **Check Dependencies**: Always verify that required modules are installed before installing dependent modules
2. **Use Transactions**: For complex operations involving multiple modules, consider using database transactions
3. **Validate Input**: Validate module names and IDs before performing operations
4. **Handle Errors Gracefully**: Implement proper error handling for all module operations
5. **Monitor Status**: Regularly check module status, especially in production environments