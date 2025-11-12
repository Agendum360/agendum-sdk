# Users Documentation

The `Agendum\Sdk\Users\UserManager` class provides a comprehensive interface for managing users in the Agendum platform.

## Overview

The UserManager class handles all user-related operations including user creation, authentication, profile management, and account administration. It provides convenient methods for common user management tasks.

## Basic Usage

```php
use Agendum\Sdk\Users\UserManager;

// Create a new user
UserManager::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => 'secure-password',
    'role' => 'user'
]);
```

## Available Methods

### CRUD Operations

#### `create($userData)`
Creates a new user account.

**Parameters:**
- `$userData` (array): User data including name, email, password, etc.

**Example:**
```php
UserManager::create([
    'name' => 'Jane Smith',
    'email' => 'jane@example.com',
    'password' => 'secure-password-123',
    'role' => 'admin',
    'profile' => [
        'phone' => '+1-555-0123',
        'department' => 'IT',
        'timezone' => 'America/New_York'
    ]
]);
```

#### `update($userId, $userData)`
Updates an existing user's information.

**Parameters:**
- `$userId` (int|string): The user identifier
- `$userData` (array): Updated user data

**Example:**
```php
UserManager::update(1, [
    'name' => 'Jane Doe Smith',
    'phone' => '+1-555-0124',
    'department' => 'Engineering'
]);
```

#### `delete($userId)`
Deletes a user account.

**Parameters:**
- `$userId` (int|string): The user identifier

**Example:**
```php
UserManager::delete(1);
```

#### `get($userId)`
Retrieves a specific user by ID.

**Parameters:**
- `$userId` (int|string): The user identifier

**Example:**
```php
$user = UserManager::get(1);
```

### Listing and Searching

#### `list($options = [])`
Lists users with optional pagination and filtering.

**Parameters:**
- `$options` (array, optional): Options for listing users

**Example:**
```php
// List all users
$users = UserManager::list();

// List with pagination and filtering
$users = UserManager::list([
    'limit' => 20,
    'offset' => 0,
    'role' => 'admin',
    'status' => 'active',
    'sort' => 'created_at',
    'order' => 'desc'
]);
```

#### `search($query, $options = [])`
Searches users by various criteria.

**Parameters:**
- `$query` (string): Search query
- `$options` (array, optional): Search options and filters

**Example:**
```php
// Search by name or email
$results = UserManager::search('john', [
    'limit' => 10,
    'fields' => ['name', 'email'],
    'role' => 'user'
]);

// Advanced search
$results = UserManager::search('engineer', [
    'fields' => ['name', 'email', 'profile.department'],
    'status' => 'active'
]);
```

### Specialized User Operations

#### `getByEmail($email)`
Retrieves a user by their email address.

**Parameters:**
- `$email` (string): User email address

**Example:**
```php
$user = UserManager::getByEmail('john@example.com');
```

#### `activate($userId)`
Activates a user account, allowing them to access the system.

**Parameters:**
- `$userId` (int|string): The user identifier

**Example:**
```php
UserManager::activate(1);
```

#### `deactivate($userId)`
Deactivates a user account, preventing system access.

**Parameters:**
- `$userId` (int|string): The user identifier

**Example:**
```php
UserManager::deactivate(1);
```

## User Data Structure

When creating or updating users, you can include the following fields:

### Required Fields
- `name` (string): User's full name
- `email` (string): User's email address
- `password` (string): User's password (for creation)

### Optional Fields
- `role` (string): User role (admin, user, moderator, etc.)
- `status` (string): Account status (active, inactive, pending)
- `profile` (array): Additional profile information
  - `phone` (string): Phone number
  - `department` (string): Department or team
  - `timezone` (string): User's timezone
  - `avatar_url` (string): Profile picture URL
  - `bio` (string): User biography
- `preferences` (array): User preferences and settings
- `metadata` (array): Custom metadata fields

### Example User Object
```php
$userData = [
    'name' => 'Alice Johnson',
    'email' => 'alice@company.com',
    'password' => 'SecurePass123!',
    'role' => 'manager',
    'status' => 'active',
    'profile' => [
        'phone' => '+1-555-0199',
        'department' => 'Marketing',
        'timezone' => 'America/Los_Angeles',
        'bio' => 'Marketing manager with 5 years of experience'
    ],
    'preferences' => [
        'language' => 'en',
        'notifications' => [
            'email' => true,
            'sms' => false,
            'push' => true
        ],
        'theme' => 'dark'
    ],
    'metadata' => [
        'employee_id' => 'EMP-2023-001',
        'start_date' => '2023-01-15',
        'manager_id' => 5
    ]
];
```

## Common Use Cases

### User Registration Workflow
```php
// Create a new user account
$userId = UserManager::create([
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
    'status' => 'pending' // Require email verification
]);

// Send verification email (handled by your application)
// ...

// After email verification, activate the user
UserManager::activate($userId);
```

### User Profile Management
```php
// Get current user
$user = UserManager::get($currentUserId);

// Update profile information
UserManager::update($currentUserId, [
    'profile' => array_merge($user['profile'], [
        'phone' => $_POST['phone'],
        'bio' => $_POST['bio'],
        'avatar_url' => $uploadedAvatarUrl
    ])
]);
```

### Admin User Management
```php
// Get all inactive users
$inactiveUsers = UserManager::list([
    'status' => 'inactive',
    'limit' => 50
]);

// Bulk activate users after review
foreach ($inactiveUsers as $user) {
    UserManager::activate($user['id']);
    echo "Activated user: {$user['email']}\n";
}
```

### User Search and Filtering
```php
// Search for users in a specific department
$engineeringUsers = UserManager::search('', [
    'filters' => [
        'profile.department' => 'Engineering',
        'status' => 'active'
    ],
    'sort' => 'name',
    'order' => 'asc'
]);

// Find users by partial email match
$gmailUsers = UserManager::search('@gmail.com', [
    'fields' => ['email'],
    'limit' => 100
]);
```

### Password Reset Workflow
```php
// Find user by email
$user = UserManager::getByEmail($_POST['email']);

if ($user) {
    // Generate reset token (handled by your application)
    $resetToken = generateResetToken();
    
    // Store token and send reset email
    UserManager::update($user['id'], [
        'metadata' => array_merge($user['metadata'] ?? [], [
            'reset_token' => $resetToken,
            'reset_expires' => time() + 3600 // 1 hour
        ])
    ]);
    
    // Send password reset email
    sendPasswordResetEmail($user['email'], $resetToken);
}
```

## Role-Based Access Control

### Checking User Permissions
```php
// Get user with role information
$user = UserManager::get($userId);

// Check if user has admin privileges
function isAdmin($user) {
    return in_array($user['role'], ['admin', 'super_admin']);
}

// Check if user can manage other users
function canManageUsers($user) {
    return in_array($user['role'], ['admin', 'manager', 'hr']);
}
```

### Role-Based User Listing
```php
// Get users that current user can manage
$currentUser = UserManager::get($currentUserId);

if (isAdmin($currentUser)) {
    // Admin can see all users
    $managedUsers = UserManager::list();
} elseif ($currentUser['role'] === 'manager') {
    // Manager can see users in their department
    $managedUsers = UserManager::search('', [
        'filters' => [
            'profile.department' => $currentUser['profile']['department']
        ]
    ]);
} else {
    // Regular users can only see themselves
    $managedUsers = [$currentUser];
}
```

## Error Handling

Common error scenarios and how to handle them:

```php
try {
    // Attempt to create user
    UserManager::create($userData);
    
} catch (DuplicateEmailException $e) {
    // Email already exists
    echo 'A user with this email already exists';
    
} catch (InvalidDataException $e) {
    // Invalid user data
    echo 'Invalid user data: ' . $e->getMessage();
    
} catch (Exception $e) {
    // General error
    echo 'Failed to create user: ' . $e->getMessage();
}
```

## Best Practices

1. **Email Validation**: Always validate email addresses before creating users
2. **Password Security**: Use proper password hashing (bcrypt, argon2)
3. **Data Validation**: Validate all user input before storing
4. **Privacy**: Be mindful of sensitive data in user profiles
5. **Audit Trail**: Log important user actions for security and compliance
6. **Soft Deletion**: Consider soft deletion instead of hard deletion for data integrity
7. **Rate Limiting**: Implement rate limiting for user operations to prevent abuse