<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::updateOrCreate(
            [
                'name' => 'Super Admin',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'code'=>'SUP-ADM'
            ]
        );
        
        Role::updateOrCreate(
            [
                'name' => 'Admin',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Admin',
                'guard_name' => 'web',
                'code'=>'ADM'
            ]
        );

        Role::updateOrCreate(
            [
                'name' => 'Finance',
                'guard_name' => 'web'
            ],
            [
                'name' => 'Finance',
                'guard_name' => 'web',
                'code'=>'FIN'
            ]
        );
    }
}
