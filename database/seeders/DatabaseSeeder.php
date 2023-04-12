<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = ['edit', 'update', 'access', 'delete'];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => "$permission Products",
                'slug' => "$permission-products"
            ]);

            Permission::create([
                'name' => "$permission Sliders",
                'slug' => "$permission-sliders"
            ]);

            Permission::create([
                'name' => "$permission Categories",
                'slug' => "$permission-categories"
            ]);
        }

        $adminRole = Role::create(['name' => 'Admin', 'slug' => 'admin']);
        $userRole = Role::create(['name' => 'User', 'slug' => 'user']);

        $allPermissions = Permission::all();

        foreach ($allPermissions as $permission) {
            $adminRole->permissions()->attach($permission);
        }

        $userRole->permissions()->attach(Permission::where('slug', 'access-categories')->first());

        for ($x = 0; $x < 10; $x++) {
            $admin = User::create([
                'name' => "admin-$x",
                'email' => "email_$x@admin.com",
                'password' => "$x-$x-$x-$x",
            ]);

            $admin->assignRole('admin');

           $user =  User::create([
                'name' => "user-$x",
                'email' => "email_$x@email.com",
                'password' => "$x-$x-$x-$x",
            ]);

            $user->assignRole('user');
        }
    }
}
