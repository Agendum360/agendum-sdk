<?php

use Agendum\Sdk\Records\RecordManager;

describe('RecordManager', function () {
    
    it('can create a record', function () {
        $recordData = [
            'title' => 'Test Record',
            'type' => 'document',
            'content' => 'This is a test record'
        ];
        
        expect(function () use ($recordData) {
            RecordManager::create($recordData);
        })->not->toThrow(Exception::class);
    });

    it('can update a record', function () {
        $recordId = 1;
        $recordData = ['title' => 'Updated Test Record'];
        
        expect(function () use ($recordId, $recordData) {
            RecordManager::update($recordId, $recordData);
        })->not->toThrow(Exception::class);
    });

    it('can delete a record', function () {
        $recordId = 1;
        
        expect(function () use ($recordId) {
            RecordManager::delete($recordId);
        })->not->toThrow(Exception::class);
    });

    it('can get a record', function () {
        $recordId = 1;
        
        expect(function () use ($recordId) {
            RecordManager::get($recordId);
        })->not->toThrow(Exception::class);
    });

    it('can list records', function () {
        $options = ['limit' => 20, 'type' => 'document'];
        
        expect(function () use ($options) {
            RecordManager::list($options);
        })->not->toThrow(Exception::class);
    });

    it('can search records', function () {
        $query = 'test content';
        $options = ['limit' => 10];
        
        expect(function () use ($query, $options) {
            RecordManager::search($query, $options);
        })->not->toThrow(Exception::class);
    });

    it('can bulk create records', function () {
        $records = [
            ['title' => 'Record 1', 'type' => 'document'],
            ['title' => 'Record 2', 'type' => 'document'],
            ['title' => 'Record 3', 'type' => 'note']
        ];
        $options = ['validate' => true];
        
        expect(function () use ($records, $options) {
            RecordManager::bulkCreate($records, $options);
        })->not->toThrow(Exception::class);
    });

    it('can bulk update records', function () {
        $updates = [
            ['id' => 1, 'title' => 'Updated Record 1'],
            ['id' => 2, 'title' => 'Updated Record 2']
        ];
        $options = ['validate' => true];
        
        expect(function () use ($updates, $options) {
            RecordManager::bulkUpdate($updates, $options);
        })->not->toThrow(Exception::class);
    });

    it('can bulk delete records', function () {
        $recordIds = [1, 2, 3];
        $options = ['soft_delete' => true];
        
        expect(function () use ($recordIds, $options) {
            RecordManager::bulkDelete($recordIds, $options);
        })->not->toThrow(Exception::class);
    });

    it('can get records by type', function () {
        $type = 'document';
        $options = ['limit' => 5];
        
        expect(function () use ($type, $options) {
            RecordManager::getByType($type, $options);
        })->not->toThrow(Exception::class);
    });

    it('can get records by status', function () {
        $status = 'active';
        $options = ['sort' => 'created_at'];
        
        expect(function () use ($status, $options) {
            RecordManager::getByStatus($status, $options);
        })->not->toThrow(Exception::class);
    });

    it('can archive a record', function () {
        $recordId = 1;
        
        expect(function () use ($recordId) {
            RecordManager::archive($recordId);
        })->not->toThrow(Exception::class);
    });

    it('can restore a record', function () {
        $recordId = 1;
        
        expect(function () use ($recordId) {
            RecordManager::restore($recordId);
        })->not->toThrow(Exception::class);
    });

    it('can duplicate a record', function () {
        $recordId = 1;
        $overrides = ['title' => 'Duplicated Record'];
        
        expect(function () use ($recordId, $overrides) {
            RecordManager::duplicate($recordId, $overrides);
        })->not->toThrow(Exception::class);
    });

    it('handles edge cases for record operations', function () {
        // Test with empty record data
        expect(function () {
            RecordManager::create([]);
        })->not->toThrow(Exception::class);

        // Test bulk operations with empty arrays
        expect(function () {
            RecordManager::bulkCreate([]);
        })->not->toThrow(Exception::class);

        expect(function () {
            RecordManager::bulkDelete([]);
        })->not->toThrow(Exception::class);
    });

    it('validates method parameters', function () {
        // Test that create method accepts array parameter
        expect(function () {
            RecordManager::create(['title' => 'Test']);
        })->not->toThrow(TypeError::class);

        // Test that bulk methods accept array parameters
        expect(function () {
            RecordManager::bulkCreate([['title' => 'Test']]);
        })->not->toThrow(TypeError::class);

        expect(function () {
            RecordManager::bulkDelete([1, 2, 3]);
        })->not->toThrow(TypeError::class);
    });
});