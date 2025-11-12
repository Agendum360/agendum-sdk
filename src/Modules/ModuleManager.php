<?php

declare(strict_types=1);

namespace Agendum\Sdk\Modules;

use Agendum\Api\Modules\CreateModule;
use Agendum\Api\Modules\UpdateModule;
use Agendum\Api\Modules\DeleteModule;
use Agendum\Api\Modules\GetModule;
use Agendum\Api\Modules\ListModules;
use Agendum\Api\Modules\SearchModules;
use Agendum\Api\Modules\InstallModule;
use Agendum\Api\Modules\UninstallModule;
use Agendum\Api\Modules\EnableModule;
use Agendum\Api\Modules\DisableModule;

/**
 * Module Manager for handling module operations
 * 
 * This class provides a convenient interface to interact with the Agendum API
 * for module-related operations including installation, configuration, and management.
 */
class ModuleManager
{
    /**
     * Create a new module
     * 
     * @param string $moduleName The name of the module to create
     * @param array $moduleData Optional module configuration data
     * @return mixed
     */
    public static function create($moduleName, array $moduleData = [])
    {
        return CreateModule::run($moduleName, $moduleData);
    }

    /**
     * Update an existing module
     * 
     * @param int|string $moduleId The module identifier
     * @param array $moduleData Updated module data
     * @return mixed
     */
    public static function update($moduleId, array $moduleData)
    {
        return UpdateModule::run($moduleId, $moduleData);
    }

    /**
     * Delete a module
     * 
     * @param int|string $moduleId The module identifier
     * @return mixed
     */
    public static function delete($moduleId)
    {
        return DeleteModule::run($moduleId);
    }

    /**
     * Get a specific module by ID
     * 
     * @param int|string $moduleId The module identifier
     * @return mixed
     */
    public static function get($moduleId)
    {
        return GetModule::run($moduleId);
    }

    /**
     * List all modules with optional filtering
     * 
     * @param array $options Options for listing modules (filters, pagination)
     * @return mixed
     */
    public static function list(array $options = [])
    {
        return ListModules::run($options);
    }

    /**
     * Search modules by criteria
     * 
     * @param string $query Search query
     * @param array $options Search options and filters
     * @return mixed
     */
    public static function search(string $query, array $options = [])
    {
        return SearchModules::run($query, $options);
    }

    /**
     * Install a module
     * 
     * @param string $moduleName The name of the module to install
     * @param array $config Installation configuration
     * @return mixed
     */
    public static function install(string $moduleName, array $config = [])
    {
        return InstallModule::run($moduleName, $config);
    }

    /**
     * Uninstall a module
     * 
     * @param int|string $moduleId The module identifier
     * @param array $options Uninstall options
     * @return mixed
     */
    public static function uninstall($moduleId, array $options = [])
    {
        return UninstallModule::run($moduleId, $options);
    }

    /**
     * Enable a module
     * 
     * @param int|string $moduleId The module identifier
     * @return mixed
     */
    public static function enable($moduleId)
    {
        return EnableModule::run($moduleId);
    }

    /**
     * Disable a module
     * 
     * @param int|string $moduleId The module identifier
     * @return mixed
     */
    public static function disable($moduleId)
    {
        return DisableModule::run($moduleId);
    }

    /**
     * Get module by name
     * 
     * @param string $moduleName The module name
     * @return mixed
     */
    public static function getByName(string $moduleName)
    {
        return GetModule::run(['name' => $moduleName]);
    }

    /**
     * Get enabled modules
     * 
     * @return mixed
     */
    public static function getEnabled()
    {
        return ListModules::run(['status' => 'enabled']);
    }

    /**
     * Get disabled modules
     * 
     * @return mixed
     */
    public static function getDisabled()
    {
        return ListModules::run(['status' => 'disabled']);
    }

    /**
     * Check if a module is installed
     * 
     * @param string $moduleName The module name
     * @return bool
     */
    public static function isInstalled(string $moduleName): bool
    {
        $module = static::getByName($moduleName);
        return $module !== null;
    }

    /**
     * Check if a module is enabled
     * 
     * @param string $moduleName The module name
     * @return bool
     */
    public static function isEnabled(string $moduleName): bool
    {
        $module = static::getByName($moduleName);
        return $module !== null && $module['status'] === 'enabled';
    }
}
