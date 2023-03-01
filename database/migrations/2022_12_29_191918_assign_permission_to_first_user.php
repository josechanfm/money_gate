<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

return new class extends Migration
{
    public function __construct()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    protected $permissions = [
        'admin',
        'admin.order.order',
        'admin.payment.payment',
        'admin.user',
    ];

    public function up()
    {
        
        $roleMaster=Role::create(['name'=>'Master']);

        $user=User::find(1);
    
        collect($this->permissions)->each(function ($permission) {
            Permission::create(['name' => $permission, 'module' => 'admin']);
        });
        
        Role::findOrCreate('Master')->givePermissionTo($this->permissions);
        $user->assignRole('Master');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $user=User::find(1);
        
        collect($this->permissions)->each(function ($permission) {
            Permission::where('name', $permission)->delete();
        });

        $user->removeRole('Master');
    }
};
