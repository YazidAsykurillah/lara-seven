<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $create_user = Permission::updateOrCreate(
            ['name' => 'create user'],
            ['name' => 'create user']
        );
        $create_user->syncRoles(['Admin']);

        $manage_blog = Permission::updateOrCreate(
            ['name' => 'manage-blog'],
            ['name' => 'manage-blog']
        );
        $manage_blog->syncRoles(['Admin']);

        $manage_role = Permission::updateOrCreate(
            ['name' => 'manage-role'],
            ['name' => 'manage-role']
        );
        $manage_role->syncRoles(['Admin']);

        $manage_permission = Permission::updateOrCreate(
            ['name' => 'manage-permission'],
            ['name' => 'manage-permission']
        );
        $manage_permission->syncRoles(['Admin']);
    }
}
