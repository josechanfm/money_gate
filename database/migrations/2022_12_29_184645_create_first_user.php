<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    
    
    public function up()
    {
        
        if (User::where('email','fong@gmail.com')->count() == 0) {
            $user = new User();
            $user->name = 'fong@gmail.com';
            $user->password = Hash::make('28341765');
            $user->email = 'fong@gmail.com';
            $user->save();
        }
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        $user=User::find(1);   

        $user->delete();
    }
};
