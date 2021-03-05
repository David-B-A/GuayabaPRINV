<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'products.index']);
        Permission::create(['name' => 'products.show']);
        Permission::create(['name' => 'products.create']);
        Permission::create(['name' => 'products.update']);
        Permission::create(['name' => 'products.destroy']);
        
        Permission::create(['name' => 'purchases.index']);
        Permission::create(['name' => 'purchases.show']);
        Permission::create(['name' => 'purchases.create']);
        Permission::create(['name' => 'purchases.update']);
        Permission::create(['name' => 'purchases.destroy']);
        
        Permission::create(['name' => 'sales.index']);
        Permission::create(['name' => 'sales.show']);
        Permission::create(['name' => 'sales.create']);
        Permission::create(['name' => 'sales.update']);
        Permission::create(['name' => 'sales.destroy']);
        
        Permission::create(['name' => 'processes.index']);
        Permission::create(['name' => 'processes.show']);
        Permission::create(['name' => 'processes.create']);
        Permission::create(['name' => 'processes.update']);
        Permission::create(['name' => 'processes.destroy']);
        
        Permission::create(['name' => 'process_templates.index']);
        Permission::create(['name' => 'process_templates.show']);
        Permission::create(['name' => 'process_templates.create']);
        Permission::create(['name' => 'process_templates.update']);
        Permission::create(['name' => 'process_templates.destroy']);
        
        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.show']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.update']);
        Permission::create(['name' => 'users.destroy']);
        
        Permission::create(['name' => 'customers.index']);
        Permission::create(['name' => 'customers.show']);
        Permission::create(['name' => 'customers.create']);
        Permission::create(['name' => 'customers.update']);
        Permission::create(['name' => 'customers.destroy']);

        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo(Permission::all());
    }
}
