<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('users')->delete();

        $roles = array(
            ['name' => 'client'],
            ['name' => 'user']
        );

        // Loop through each user above and create the record for them in the database
        foreach ($roles as $role)
        {
            Role::create($role);
        }

        Model::reguard();
    }
}