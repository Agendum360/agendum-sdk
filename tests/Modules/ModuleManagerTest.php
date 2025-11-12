<?php

use Agendum\Sdk\Modules\ModuleManager;

describe('ModuleManager', function () {
    
    it('can create a module', function () {
        $moduleName = 'test-module';
        $moduleData = ['description' => 'Test module'];
        
        // Mock the API call
        expect(function () use ($moduleName, $moduleData) {
            ModuleManager::create($moduleName, $moduleData);
        })->not->toThrow(Exception::class);
    });

    it('can update a module', function () {
        $moduleId = 1;
        $moduleData = ['description' => 'Updated test module'];
        
        expect(function () use ($moduleId, $moduleData) {
            ModuleManager::update($moduleId, $moduleData);
        })->not->toThrow(Exception::class);
    });

    it('can delete a module', function () {
        $moduleId = 1;
        
        expect(function () use ($moduleId) {
            ModuleManager::delete($moduleId);
        })->not->toThrow(Exception::class);
    });

    it('can get a module', function () {
        $moduleId = 1;
        
        expect(function () use ($moduleId) {
            ModuleManager::get($moduleId);
        })->not->toThrow(Exception::class);
    });

    it('can list modules', function () {
        $options = ['limit' => 10];
        
        expect(function () use ($options) {
            ModuleManager::list($options);
        })->not->toThrow(Exception::class);
    });

    it('can search modules', function () {
        $query = 'test';
        $options = ['limit' => 5];
        
        expect(function () use ($query, $options) {
            ModuleManager::search($query, $options);
        })->not->toThrow(Exception::class);
    });

    it('can install a module', function () {
        $moduleName = 'test-module';
        $config = ['auto_enable' => true];
        
        expect(function () use ($moduleName, $config) {
            ModuleManager::install($moduleName, $config);
        })->not->toThrow(Exception::class);
    });

    it('can uninstall a module', function () {
        $moduleId = 1;
        $options = ['force' => true];
        
        expect(function () use ($moduleId, $options) {
            ModuleManager::uninstall($moduleId, $options);
        })->not->toThrow(Exception::class);
    });

    it('can enable a module', function () {
        $moduleId = 1;
        
        expect(function () use ($moduleId) {
            ModuleManager::enable($moduleId);
        })->not->toThrow(Exception::class);
    });

    it('can disable a module', function () {
        $moduleId = 1;
        
        expect(function () use ($moduleId) {
            ModuleManager::disable($moduleId);
        })->not->toThrow(Exception::class);
    });

    it('can get module by name', function () {
        $moduleName = 'test-module';
        
        expect(function () use ($moduleName) {
            ModuleManager::getByName($moduleName);
        })->not->toThrow(Exception::class);
    });

    it('can get enabled modules', function () {
        expect(function () {
            ModuleManager::getEnabled();
        })->not->toThrow(Exception::class);
    });

    it('can get disabled modules', function () {
        expect(function () {
            ModuleManager::getDisabled();
        })->not->toThrow(Exception::class);
    });

    it('can check if module is installed', function () {
        $moduleName = 'test-module';
        
        expect(function () use ($moduleName) {
            $result = ModuleManager::isInstalled($moduleName);
            expect($result)->toBeIn([true, false]);
        })->not->toThrow(Exception::class);
    });

    it('can check if module is enabled', function () {
        $moduleName = 'test-module';
        
        expect(function () use ($moduleName) {
            $result = ModuleManager::isEnabled($moduleName);
            expect($result)->toBeIn([true, false]);
        })->not->toThrow(Exception::class);
    });
});