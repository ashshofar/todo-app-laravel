<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user               = new User();
        $user->name         = 'client';
        $user->username     = 'client';
        $user->password     = Hash::make('secret');
        $user->save();
        
        $role = Role::where('name', '=', 'client')->first();
        $user->roles()->attach($role->id);

        $user               = new User();
        $user->name         = 'user';
        $user->username     = 'user';
        $user->password     = Hash::make('secret');
        $user->save();
        
        $role = Role::where('name', '=', 'user')->first();
        $user->roles()->attach($role->id);
    }
}
