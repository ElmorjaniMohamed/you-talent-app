<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define roles with their associated permissions
        $roles = [
            [
                'name' => 'admin',
                'permissions' => [
                    'advert-list',
                    'create-advert',
                    'update-advert',
                    'delete-advert',
                    'company-list',
                    'create-company',
                    'update-company',
                    'delete-company',
                    'role-list',
                    'skill-list',
                    'create-skill',
                    'edit-skill',
                    'delete-skill'
                ]
            ],
            [
                'name' => 'superAdmin',
                'permissions' => [
                    'advert-list',
                    'create-advert',
                    'update-advert',
                    'delete-advert',
                    'company-list',
                    'create-company',
                    'update-company',
                    'delete-company',
                    'role-list',
                    'create-role',
                    'edit-role',
                    'delete-role',
                    'skill-list',
                    'create-skill',
                    'edit-skill',
                    'delete-skill'

                ]
            ],
            [
                'name' => 'learner',
                'permissions' => [
                    'skill-list',
                    'create-skill',
                    'edit-skill',
                    'delete-skill'
                ]
            ],
        ];

        // Create roles and assign permissions
        foreach ($roles as $roleData) {
            $role = Role::firstOrCreate(['name' => $roleData['name']]);

            // Assign permissions to role
            foreach ($roleData['permissions'] as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $role->givePermissionTo($permission);
            }
        }
    }
}