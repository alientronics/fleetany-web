<?php

use Illuminate\Database\Seeder;
use Kodeine\Acl\Models\Eloquent\Role;
use App\User;

class AclTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Rules
        $role = new Role();
        $roleAdmin = $role->create([
            'name' => 'Administrador',
            'slug' => 'administrator',
            'description' => 'Administrador geral do sistema'
            ]);
        
        $user = User::first();
        if ($user) {
        	$user->assignRole($roleAdmin);
    	}

    }
}
