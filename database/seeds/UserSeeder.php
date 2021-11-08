<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::updateOrCreate(
            [
                'name' => 'Yazid Asykurillah',
                'email' => 'yazid@pos-ez.co.id',
            ],
            [
                'name' => 'Yazid Asykurillah',
                'email' => 'yazid@pos-ez.co.id',
                'password' => bcrypt('12345678'),
            ]
        );
        $superadmin->assignRole('Super Admin');

        $admin = User::updateOrCreate(
            [
                'name' => 'Admin',
                'email' => 'admin@pos-ez.co.id',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@pos-ez.co.id',
                'password' => bcrypt('12345678'),
            ]
        );
        $admin->assignRole('Admin');

        $finance = User::updateOrCreate(
            [
                'name' => 'Finance',
                'email' => 'finance@pos-ez.co.id',
            ],
            [
                'name' => 'Finance',
                'email' => 'finance@pos-ez.co.id',
                'password' => bcrypt('12345678'),
            ]
        );
        $finance->assignRole('Finance');
    }
}
