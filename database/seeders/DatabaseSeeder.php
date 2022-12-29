<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $roleMaster=Role::create(['name'=>'Master']);
        $roleAdmin=Role::create(['name'=>'Admin']);
        $roleMember=Role::create(['name'=>'Member']);

        $permissionCreate=Permission::create(['name'=>'Create Member']);
        $permissionDelete=Permission::create(['name'=>'Delete Member']);
        $permissionEdit=Permission::create(['name'=>'Edit Member']);
        $permissionView=Permission::create(['name'=>'View Member']);

        $roleMaster->givePermissionTo($permissionCreate);
        $roleMaster->givePermissionTo($permissionDelete);
        $roleMaster->givePermissionTo($permissionEdit);
        $roleMaster->givePermissionTo($permissionView);

        $roleAdmin->givePermissionTo($permissionCreate);
        $roleAdmin->givePermissionTo($permissionView);

        $user=User::find(2);
        $user->assignRole('Master');

        
        
    }
}
