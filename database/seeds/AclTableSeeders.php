<?php

use Illuminate\Database\Seeder;
use Kodeine\Acl\Models\Eloquent\Role;
use App\User;
use Kodeine\Acl\Models\Eloquent\Permission;

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
        
    	$permission = new Permission();
    	$permAdmin = $permission->create([
    	    'name'        => 'admin',
    	    'slug'        => [
    	        'create' => true,
    	        'view'   => true,
    	        'update' => true,
    	        'delete' => true
    	    ],
    	    'description' => 'Administra permissões do administrador do sistema'
    	]);
    	
    	$roleAdmin->assignPermission('admin');

    	$user = User::first();
    	if ($user) {
    	    $user->assignRole($roleAdmin);
    	}
    	

    	$role = new Role();
    	$roleGestor = $role->create([
    	    'name' => 'Gestor',
    	    'slug' => 'gestor',
    	    'description' => 'Usuário da categoria "Gestor" do sistema'
    	]);
    	
    	$permission = new Permission();
    	$permGestor = $permission->create([
    	    'name'        => 'not_admin',
    	    'slug'        => [
    	        'create' => true,
    	        'view'   => true,
    	        'update' => true,
    	        'delete' => false
    	    ],
    	    'description' => 'Administra permissões das categorias de usuários diferentes de administrador'
    	]);
    	
    	$roleGestor->assignPermission('not_admin');
    	
    	
    	
    	
//     	$user->assignRole($roleTeacher);
    	
//     	Administrador
//         	Modelo Veículo
//         	Modelo Monitor
//         	Modelo Sensor
//         	Modelo Pneu
//     	Gestor
//         	Usuários (somente da empresa)
//         	Filiais (lista empresas)
//         	Frotas (grupo de veículos)
//     	Gerente
//         	Motorista
//         	Empresa
//         	Pressão Padrão (para empresa / modelo veículo)
//     	Comum
//     	   Perfil do Usuário

    }
}
