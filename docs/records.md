# Records Documentation

The `Agendum\Sdk\Records\RecordManager` class provides a powerful interface for managing records in the Agendum platform, including advanced features like bulk operations, archiving, and record duplication.

## Overview

Records are the core data entities in Agendum. They can represent documents, tasks, notes, or any structured data. The RecordManager class provides comprehensive CRUD operations along with advanced features for data management.

## Basic Usage

```php
use Agendum\Sdk\Records\RecordManager;

// Create a new record
RecordManager::create([
    'title' => 'Meeting Notes',
    'type' => 'document',
    'content' => 'Notes from the quarterly planning meeting...',
    'status' => 'draft'
]);
```

## Available Methods

### CRUD Operations

#### `create($recordData)`
Creates a new record.

**Parameters:**
- `$recordData` (array): Record data including title, type, content, etc.

**Example:**
```php
RecordManager::create([
    'title' => 'Product Requirements Document',
    'type' => 'document',
    'content' => 'Detailed specifications for the new feature...',
    'status' => 'active',
    'tags' => ['product', 'requirements', 'v2.0'],
    'metadata' => [
        'author_id' => 123,
        'project_id' => 456,
        'priority' => 'high'
    ]
]);
```

#### `update($recordId, $recordData)`
Updates an existing record.

**Parameters:**
- `$recordId` (int|string): The record identifier
- `$recordData` (array): Updated record data

**Example:**
```php
RecordManager::update(1, [
    'title' => 'Updated Product Requirements',
    'status' => 'published',
    'content' => 'Updated specifications with recent changes...'
]);
```

#### `delete($recordId)`
Deletes a record.

**Parameters:**
- `$recordId` (int|string): The record identifier

**Example:**
```php
RecordManager::delete(1);
```

#### `get($recordId)`
Retrieves a specific record by ID.

**Parameters:**
- `$recordId` (int|string): The record identifier

**Example:**
```php
$record = RecordManager::get(1);
```

### Listing and Searching

#### `list($options = [])`
Lists records with optional filtering, pagination, and sorting.

**Parameters:**
- `$options` (array, optional): Options for listing records

**Example:**
```php
// List all records
$records = RecordManager::list();

// List with filtering and pagination
$records = RecordManager::list([
    'limit' => 25,
    'offset' => 0,
    'type' => 'document',
    'status' => 'published',
    'sort' => 'updated_at',
    'order' => 'desc',
    'tags' => ['important'],
    'author_id' => 123
]);
```

#### `search($query, $options = [])`
Searches records by content and metadata.

**Parameters:**
- `$query` (string): Search query
- `$options` (array, optional): Search options and filters

**Example:**
```php
// Basic text search
$results = RecordManager::search('quarterly planning', [
    'limit' => 10,
    'type' => 'document'
]);

// Advanced search with filters
$results = RecordManager::search('API documentation', [
    'fields' => ['title', 'content', 'tags'],
    'filters' => [
        'status' => 'published',
        'type' => ['document', 'guide']
    ],
    'date_range' => [
        'field' => 'created_at',
        'start' => '2023-01-01',
        'end' => '2023-12-31'
    ]
]);
```

### Bulk Operations

#### `bulkCreate($records, $options = [])`
Creates multiple records in a single operation.

**Parameters:**
- `$records` (array): Array of record data
- `$options` (array, optional): Bulk operation options

**Example:**
```php
$records = [
    [
        'title' => 'Task 1',
        'type' => 'task',
        'content' => 'Complete feature A'
    ],
    [
        'title' => 'Task 2',
        'type' => 'task',
        'content' => 'Review feature B'
    ],
    [
        'title' => 'Task 3',
        'type' => 'task',
        'content' => 'Deploy feature C'
    ]
];

RecordManager::bulkCreate($records, [
    'validate' => true,
    'skip_duplicates' => true,
    'batch_size' => 100
]);
```

#### `bulkUpdate($updates, $options = [])`
Updates multiple records in a single operation.

**Parameters:**
- `$updates` (array): Array of record updates with IDs
- `$options` (array, optional): Bulk operation options

**Example:**
```php
$updates = [
    ['id' => 1, 'status' => 'completed'],
    ['id' => 2, 'status' => 'completed'],
    ['id' => 3, 'status' => 'in_progress']
];

RecordManager::bulkUpdate($updates, [
    'validate' => true,
    'ignore_missing' => false
]);
```

#### `bulkDelete($recordIds, $options = [])`
Deletes multiple records in a single operation.

**Parameters:**
- `$recordIds` (array): Array of record identifiers
- `$options` (array, optional): Bulk operation options

**Example:**
```php
$recordIds = [1, 2, 3, 4, 5];

RecordManager::bulkDelete($recordIds, [
    'soft_delete' => true,
    'archive_first' => true
]);
```

### Specialized Operations

#### `getByType($type, $options = [])`
Retrieves records of a specific type.

**Parameters:**
- `$type` (string): Record type
- `$options` (array, optional): Additional filtering options

**Example:**
```php
// Get all documents
$documents = RecordManager::getByType('document', [
    'status' => 'published',
    'limit' => 50
]);

// Get tasks assigned to a specific user
$userTasks = RecordManager::getByType('task', [
    'assignee_id' => 123,
    'status' => ['pending', 'in_progress']
]);
```

#### `getByStatus($status, $options = [])`
Retrieves records with a specific status.

**Parameters:**
- `$status` (string): Record status
- `$options` (array, optional): Additional filtering options

**Example:**
```php
// Get all draft records
$drafts = RecordManager::getByStatus('draft', [
    'author_id' => 123,
    'sort' => 'updated_at',
    'order' => 'desc'
]);
```

#### `archive($recordId)`
Archives a record (sets status to 'archived').

**Parameters:**
- `$recordId` (int|string): The record identifier

**Example:**
```php
RecordManager::archive(1);
```

#### `restore($recordId)`
Restores an archived record (sets status to 'active').

**Parameters:**
- `$recordId` (int|string): The record identifier

**Example:**
```php
RecordManager::restore(1);
```

#### `duplicate($recordId, $overrides = [])`
Creates a duplicate of an existing record.

**Parameters:**
- `$recordId` (int|string): The record identifier to duplicate
- `$overrides` (array, optional): Data to override in the duplicate

**Example:**
```php
// Simple duplication
$duplicateId = RecordManager::duplicate(1);

// Duplication with modifications
$duplicateId = RecordManager::duplicate(1, [
    'title' => 'Copy of Original Document',
    'status' => 'draft',
    'metadata' => [
        'original_id' => 1,
        'copy_created_at' => date('Y-m-d H:i:s')
    ]
]);
```

## Record Data Structure

### Required Fields
- `title` (string): Record title
- `type` (string): Record type (document, task, note, etc.)

### Optional Fields
- `content` (string): Record content or description
- `status` (string): Record status (draft, active, archived, etc.)
- `tags` (array): Array of tag strings
- `metadata` (array): Custom metadata fields
- `author_id` (int): ID of the record creator
- `assignee_id` (int): ID of the assigned user (for tasks)
- `parent_id` (int): ID of parent record (for hierarchical structures)
- `priority` (string): Priority level (low, medium, high, urgent)
- `due_date` (string): Due date in ISO format
- `attachments` (array): Array of attachment information

### Example Record Object
```php
$recordData = [
    'title' => 'Q4 Marketing Campaign',
    'type' => 'project',
    'content' => 'Launch the holiday marketing campaign...',
    'status' => 'active',
    'tags' => ['marketing', 'Q4', 'campaign', 'holiday'],
    'metadata' => [
        'budget' => 50000,
        'target_audience' => 'millennials',
        'channels' => ['social', 'email', 'display'],
        'kpis' => ['reach', 'engagement', 'conversions']
    ],
    'author_id' => 123,
    'assignee_id' => 456,
    'priority' => 'high',
    'due_date' => '2023-12-15',
    'attachments' => [
        [
            'name' => 'campaign-brief.pdf',
            'url' => 'https://example.com/files/campaign-brief.pdf',
            'size' => 1024000,
            'type' => 'application/pdf'
        ]
    ]
];
```

## Common Use Cases

### Document Management System
```php
// Create a new document
$documentId = RecordManager::create([
    'title' => 'Employee Handbook 2024',
    'type' => 'document',
    'content' => file_get_contents('handbook.md'),
    'status' => 'draft',
    'tags' => ['hr', 'policies', '2024'],
    'metadata' => [
        'department' => 'Human Resources',
        'version' => '1.0',
        'requires_approval' => true
    ]
]);

// Update document status after review
RecordManager::update($documentId, [
    'status' => 'published',
    'metadata' => [
        'approved_by' => 789,
        'approved_at' => date('Y-m-d H:i:s')
    ]
]);
```

### Task Management
```php
// Create project tasks
$projectTasks = [
    [
        'title' => 'Design UI mockups',
        'type' => 'task',
        'assignee_id' => 123,
        'priority' => 'high',
        'due_date' => '2023-11-15'
    ],
    [
        'title' => 'Implement backend API',
        'type' => 'task',
        'assignee_id' => 456,
        'priority' => 'medium',
        'due_date' => '2023-11-20'
    ],
    [
        'title' => 'Write unit tests',
        'type' => 'task',
        'assignee_id' => 789,
        'priority' => 'medium',
        'due_date' => '2023-11-25'
    ]
];

RecordManager::bulkCreate($projectTasks);

// Mark completed tasks
$completedTaskIds = [1, 3, 5];
$updates = array_map(function($id) {
    return ['id' => $id, 'status' => 'completed'];
}, $completedTaskIds);

RecordManager::bulkUpdate($updates);
```

### Content Versioning
```php
// Create a new version of an existing document
$originalRecord = RecordManager::get(1);

$newVersionId = RecordManager::duplicate(1, [
    'title' => $originalRecord['title'] . ' v2.0',
    'status' => 'draft',
    'metadata' => array_merge($originalRecord['metadata'], [
        'version' => '2.0',
        'previous_version_id' => 1,
        'changelog' => 'Updated pricing information and added new sections'
    ])
]);

// Archive the old version
RecordManager::archive(1);
```

### Data Migration
```php
// Migrate records from old system
$oldSystemRecords = fetchFromOldSystem();

$migratedRecords = array_map(function($oldRecord) {
    return [
        'title' => $oldRecord['name'],
        'type' => 'document',
        'content' => $oldRecord['body'],
        'status' => 'active',
        'metadata' => [
            'old_system_id' => $oldRecord['id'],
            'migrated_at' => date('Y-m-d H:i:s'),
            'original_created_at' => $oldRecord['created_date']
        ]
    ];
}, $oldSystemRecords);

// Bulk create with validation
RecordManager::bulkCreate($migratedRecords, [
    'validate' => true,
    'skip_duplicates' => true,
    'batch_size' => 50
]);
```

### Advanced Search and Reporting
```php
// Generate monthly report
$monthlyDocuments = RecordManager::search('', [
    'filters' => [
        'type' => 'document',
        'status' => 'published',
        'created_at' => [
            'gte' => '2023-10-01',
            'lt' => '2023-11-01'
        ]
    ],
    'sort' => 'created_at',
    'order' => 'desc'
]);

// Find records needing review
$staleRecords = RecordManager::search('', [
    'filters' => [
        'status' => 'active',
        'updated_at' => [
            'lt' => date('Y-m-d', strtotime('-90 days'))
        ]
    ]
]);

// Get popular content
$popularRecords = RecordManager::search('', [
    'filters' => [
        'type' => 'document',
        'status' => 'published'
    ],
    'sort' => 'metadata.view_count',
    'order' => 'desc',
    'limit' => 10
]);
```

## Error Handling

```php
try {
    // Attempt bulk operation
    RecordManager::bulkCreate($records);
    
} catch (ValidationException $e) {
    // Handle validation errors
    foreach ($e->getErrors() as $index => $errors) {
        echo "Record {$index} has errors: " . implode(', ', $errors) . "\n";
    }
    
} catch (BulkOperationException $e) {
    // Handle partial failures
    echo "Bulk operation partially failed. ";
    echo "Successful: " . count($e->getSuccessful()) . ", ";
    echo "Failed: " . count($e->getFailed());
    
} catch (Exception $e) {
    echo 'Operation failed: ' . $e->getMessage();
}
```

## Best Practices

1. **Use Types Consistently**: Establish clear record types and stick to them
2. **Validate Input**: Always validate record data before creation
3. **Use Metadata Wisely**: Store structured data in metadata for better querying
4. **Implement Soft Deletion**: Use archive functionality instead of hard deletion
5. **Batch Operations**: Use bulk operations for better performance with large datasets
6. **Version Control**: Implement versioning for important documents using duplication
7. **Tag Strategy**: Develop a consistent tagging strategy for better organization
8. **Monitor Performance**: Keep an eye on query performance, especially with large datasets