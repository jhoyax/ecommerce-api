<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findByName('admin', 'api');

        $permissions = [
            ['name' => 'create products', 'guard_name' => 'api'],
            ['name' => 'edit products', 'guard_name' => 'api'],
            ['name' => 'delete products', 'guard_name' => 'api'],

            ['name' => 'create product categories', 'guard_name' => 'api'],
            ['name' => 'edit product categories', 'guard_name' => 'api'],
            ['name' => 'delete product categories', 'guard_name' => 'api'],
        ];
        
        foreach ($permissions as $permission) {
            $role->givePermissionTo(Permission::create($permission));
        }
    }
}
