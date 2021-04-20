<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        if(User::where("role_id", 1)->count() == 0){

            $user = new User;
            $user->name = "Admin";
            $user->lastname = "Admin";
            $user->password = bcrypt("12345678");
            $user->email = "admin@gmail.com";
            $user->role_id = 1;
            $user->email_verified_at = Carbon::now();
            $user->save();

        }

    }
}
