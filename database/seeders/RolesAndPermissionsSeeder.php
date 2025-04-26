<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Resetting cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();


        /**************************************
         * Creating Roles
         **************************************/
        $admin_role = Role::create(['name' => 'admin']);
        $manager_role = Role::create(['name' => 'manager']);
        $engineer_role = Role::create(['name' => 'super_admin']);



        /**************************************
         * Creating persmissions
         **************************************/

        // medicinces
        $create_medicines = Permission::create(['name' => 'create_medicines']);
        $read_medicines = Permission::create(['name' => 'read_medicines']);
        $delete_medicines = Permission::create(['name' => 'delete_medicines']);
        $update_medicines = Permission::create(['name' => 'update_medicines']);
        $restore_medicines = Permission::create(['name' => 'restore_medicines']);

        // manufacturers
        $create_manufacturers = Permission::create(['name' => 'create_manufacturers']);
        $read_manufacturers = Permission::create(['name' => 'read_manufacturers']);
        $delete_manufacturers = Permission::create(['name' => 'delete_manufacturers']);
        $update_manufacturers = Permission::create(['name' => 'update_manufacturers']);
        $restore_manufacturers = Permission::create(['name' => 'restore_manufacturers']);

        // sales
        $create_sales = Permission::create(['name' => 'create_sales']);
        $read_sales = Permission::create(['name' => 'read_sales']);
        $delete_sales = Permission::create(['name' => 'delete_sales']);
        $update_sales = Permission::create(['name' => 'update_sales']);
        $restore_sales = Permission::create(['name' => 'restore_sales']);

        // purchases
        $create_purchases = Permission::create(['name' => 'create_purchases']);
        $read_purchases = Permission::create(['name' => 'read_purchases']);
        $delete_purchases = Permission::create(['name' => 'delete_purchases']);
        $update_purchases = Permission::create(['name' => 'update_purchases']);
        $restore_purchases = Permission::create(['name' => 'restore_purchases']);


        /**************************************
         * Assigning persmissions
         **************************************/

        $manager_role->givePermissionTo([
            $create_manufacturers, $read_manufacturers, $delete_manufacturers, $update_manufacturers,            $restore_manufacturers,
            $create_medicines, $read_medicines, $delete_medicines, $update_medicines, $restore_medicines,
            $create_sales, $read_sales, $delete_sales, $update_sales, $restore_sales,
            $create_purchases, $read_purchases, $delete_purchases, $update_purchases, $restore_purchases
        ]);



        /**************************************
         * Seeding with demo users TODO: RM
         **************************************/

        // Creating a manger
        $manager = \App\Models\User::factory()->create([
            'name' => 'Mr Manager',
            'email' => 'manager@openpharma.com',
        ]);
        $manager->assignRole($manager_role);

        // creating an admin user
        $admin = \App\Models\User::factory()->create([
            'name' => 'Mr. Administrator',
            'email' => 'admin@openpharma.com',

        ]);
        $admin->assignRole($admin_role);

        // Creating a super user
        $engineer = \App\Models\User::factory()->create([
            'name' => 'Mr Engineer',
            'email' => 'superadmin@openpharma.com',

        ]);
        $engineer->assignRole($engineer_role);


        // create mass admin
        $users = \App\Models\User::factory(5)->create()->each(function ($user) {
            $user->assignRole('manager');
        });
    }
}
