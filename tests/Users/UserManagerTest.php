<?php

use Agendum\Sdk\Users\UserManager;

describe('UserManager', function () {
    
    it('can create a user', function () {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123'
        ];
        
        expect(function () use ($userData) {
            UserManager::create($userData);
        })->not->toThrow(Exception::class);
    });

    it('can update a user', function () {
        $userId = 1;
        $userData = ['name' => 'Jane Doe'];
        
        expect(function () use ($userId, $userData) {
            UserManager::update($userId, $userData);
        })->not->toThrow(Exception::class);
    });

    it('can delete a user', function () {
        $userId = 1;
        
        expect(function () use ($userId) {
            UserManager::delete($userId);
        })->not->toThrow(Exception::class);
    });

    it('can get a user', function () {
        $userId = 1;
        
        expect(function () use ($userId) {
            UserManager::get($userId);
        })->not->toThrow(Exception::class);
    });

    it('can list users', function () {
        $options = ['limit' => 10, 'offset' => 0];
        
        expect(function () use ($options) {
            UserManager::list($options);
        })->not->toThrow(Exception::class);
    });

    it('can search users', function () {
        $query = 'john';
        $options = ['limit' => 5];
        
        expect(function () use ($query, $options) {
            UserManager::search($query, $options);
        })->not->toThrow(Exception::class);
    });

    it('can get user by email', function () {
        $email = 'john@example.com';
        
        expect(function () use ($email) {
            UserManager::getByEmail($email);
        })->not->toThrow(Exception::class);
    });

    it('can activate a user', function () {
        $userId = 1;
        
        expect(function () use ($userId) {
            UserManager::activate($userId);
        })->not->toThrow(Exception::class);
    });

    it('can deactivate a user', function () {
        $userId = 1;
        
        expect(function () use ($userId) {
            UserManager::deactivate($userId);
        })->not->toThrow(Exception::class);
    });

    it('handles edge cases for user operations', function () {
        // Test with empty user data
        expect(function () {
            UserManager::create([]);
        })->not->toThrow(Exception::class);

        // Test with invalid user ID
        expect(function () {
            UserManager::get('invalid-id');
        })->not->toThrow(Exception::class);

        // Test search with empty query
        expect(function () {
            UserManager::search('');
        })->not->toThrow(Exception::class);
    });

    it('validates required parameters', function () {
        // Test that create method accepts array parameter
        expect(function () {
            UserManager::create(['name' => 'Test User']);
        })->not->toThrow(TypeError::class);

        // Test that update method accepts proper parameters
        expect(function () {
            UserManager::update(1, ['name' => 'Updated User']);
        })->not->toThrow(TypeError::class);
    });
});