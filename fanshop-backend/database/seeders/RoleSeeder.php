<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        if(Role::where("id", 1)->count() == 0){
            $role = new Role;
            $role->id = 1;
            $role->name = "Admin";
            $role->save();
        }

        else if(Role::where("id", 2)->count() == 0){
            $role = new Role;
            $role->id = 2;
            $role->name = "Usuario";
            $role->save();
        }

    }
}
