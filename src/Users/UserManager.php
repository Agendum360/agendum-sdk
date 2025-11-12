<?php

declare(strict_types=1);

namespace Agendum\Sdk\Users;

use Agendum\Api\Users\CreateUser;
use Agendum\Api\Users\UpdateUser;
use Agendum\Api\Users\DeleteUser;
use Agendum\Api\Users\GetUser;
use Agendum\Api\Users\ListUsers;
use Agendum\Api\Users\SearchUsers;

/**
 * User Manager for handling user operations
 * 
 * This class provides a convenient interface to interact with the Agendum API
 * for user-related operations such as creating, updating, deleting, and retrieving users.
 */
class UserManager
{
    /**
     * Create a new user
     * 
     * @param array $userData User data including name, email, etc.
     * @return mixed
     */
    public static function create(array $userData)
    {
        return CreateUser::run($userData);
    }

    /**
     * Update an existing user
     * 
     * @param int|string $userId The user identifier
     * @param array $userData Updated user data
     * @return mixed
     */
    public static function update($userId, array $userData)
    {
        return UpdateUser::run($userId, $userData);
    }

    /**
     * Delete a user
     * 
     * @param int|string $userId The user identifier
     * @return mixed
     */
    public static function delete($userId)
    {
        return DeleteUser::run($userId);
    }

    /**
     * Get a specific user by ID
     * 
     * @param int|string $userId The user identifier
     * @return mixed
     */
    public static function get($userId)
    {
        return GetUser::run($userId);
    }

    /**
     * List all users with optional pagination
     * 
     * @param array $options Options for listing users (pagination, filters, etc.)
     * @return mixed
     */
    public static function list(array $options = [])
    {
        return ListUsers::run($options);
    }

    /**
     * Search users by criteria
     * 
     * @param string $query Search query
     * @param array $options Search options and filters
     * @return mixed
     */
    public static function search(string $query, array $options = [])
    {
        return SearchUsers::run($query, $options);
    }

    /**
     * Get user by email
     * 
     * @param string $email User email address
     * @return mixed
     */
    public static function getByEmail(string $email)
    {
        return GetUser::run(['email' => $email]);
    }

    /**
     * Activate a user account
     * 
     * @param int|string $userId The user identifier
     * @return mixed
     */
    public static function activate($userId)
    {
        return UpdateUser::run($userId, ['status' => 'active']);
    }

    /**
     * Deactivate a user account
     * 
     * @param int|string $userId The user identifier
     * @return mixed
     */
    public static function deactivate($userId)
    {
        return UpdateUser::run($userId, ['status' => 'inactive']);
    }
}