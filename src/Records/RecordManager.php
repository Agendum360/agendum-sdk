<?php

declare(strict_types=1);

namespace Agendum\Sdk\Records;

use Agendum\Api\Records\CreateRecord;
use Agendum\Api\Records\UpdateRecord;
use Agendum\Api\Records\DeleteRecord;
use Agendum\Api\Records\GetRecord;
use Agendum\Api\Records\ListRecords;
use Agendum\Api\Records\SearchRecords;
use Agendum\Api\Records\BulkCreateRecords;
use Agendum\Api\Records\BulkUpdateRecords;
use Agendum\Api\Records\BulkDeleteRecords;

/**
 * Record Manager for handling record operations
 * 
 * This class provides a convenient interface to interact with the Agendum API
 * for record-related operations including CRUD operations, bulk operations,
 * and advanced querying capabilities.
 */
class RecordManager
{
    /**
     * Create a new record
     * 
     * @param array $recordData Record data including fields and metadata
     * @return mixed
     */
    public static function create(array $recordData)
    {
        return CreateRecord::run($recordData);
    }

    /**
     * Update an existing record
     * 
     * @param int|string $recordId The record identifier
     * @param array $recordData Updated record data
     * @return mixed
     */
    public static function update($recordId, array $recordData)
    {
        return UpdateRecord::run($recordId, $recordData);
    }

    /**
     * Delete a record
     * 
     * @param int|string $recordId The record identifier
     * @return mixed
     */
    public static function delete($recordId)
    {
        return DeleteRecord::run($recordId);
    }

    /**
     * Get a specific record by ID
     * 
     * @param int|string $recordId The record identifier
     * @return mixed
     */
    public static function get($recordId)
    {
        return GetRecord::run($recordId);
    }

    /**
     * List records with optional filtering and pagination
     * 
     * @param array $options Options for listing records (filters, pagination, sorting)
     * @return mixed
     */
    public static function list(array $options = [])
    {
        return ListRecords::run($options);
    }

    /**
     * Search records by criteria
     * 
     * @param string $query Search query
     * @param array $options Search options and filters
     * @return mixed
     */
    public static function search(string $query, array $options = [])
    {
        return SearchRecords::run($query, $options);
    }

    /**
     * Create multiple records in bulk
     * 
     * @param array $records Array of record data
     * @param array $options Bulk operation options
     * @return mixed
     */
    public static function bulkCreate(array $records, array $options = [])
    {
        return BulkCreateRecords::run($records, $options);
    }

    /**
     * Update multiple records in bulk
     * 
     * @param array $updates Array of record updates with IDs
     * @param array $options Bulk operation options
     * @return mixed
     */
    public static function bulkUpdate(array $updates, array $options = [])
    {
        return BulkUpdateRecords::run($updates, $options);
    }

    /**
     * Delete multiple records in bulk
     * 
     * @param array $recordIds Array of record identifiers
     * @param array $options Bulk operation options
     * @return mixed
     */
    public static function bulkDelete(array $recordIds, array $options = [])
    {
        return BulkDeleteRecords::run($recordIds, $options);
    }

    /**
     * Get records by type
     * 
     * @param string $type Record type
     * @param array $options Additional options
     * @return mixed
     */
    public static function getByType(string $type, array $options = [])
    {
        return ListRecords::run(array_merge($options, ['type' => $type]));
    }

    /**
     * Get records by status
     * 
     * @param string $status Record status
     * @param array $options Additional options
     * @return mixed
     */
    public static function getByStatus(string $status, array $options = [])
    {
        return ListRecords::run(array_merge($options, ['status' => $status]));
    }

    /**
     * Archive a record
     * 
     * @param int|string $recordId The record identifier
     * @return mixed
     */
    public static function archive($recordId)
    {
        return UpdateRecord::run($recordId, ['status' => 'archived']);
    }

    /**
     * Restore an archived record
     * 
     * @param int|string $recordId The record identifier
     * @return mixed
     */
    public static function restore($recordId)
    {
        return UpdateRecord::run($recordId, ['status' => 'active']);
    }

    /**
     * Duplicate a record
     * 
     * @param int|string $recordId The record identifier to duplicate
     * @param array $overrides Optional data to override in the duplicate
     * @return mixed
     */
    public static function duplicate($recordId, array $overrides = [])
    {
        $originalRecord = static::get($recordId);
        $duplicateData = array_merge($originalRecord, $overrides);
        unset($duplicateData['id']); // Remove ID to create new record
        
        return static::create($duplicateData);
    }
}