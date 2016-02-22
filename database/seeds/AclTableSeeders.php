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
        $roleAdmin = Role::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
            'description' => 'Administrador geral do sistema'
            ]);
        
        $roleExecutive = Role::create([
            'name' => 'Executive',
            'slug' => 'executive',
            'description' => 'Usuario da categoria "Executive" do sistema'
        ]);

        $roleManager = Role::create([
            'name' => 'Manager',
            'slug' => 'manager',
            'description' => 'Usuario da categoria "Manager" do sistema'
        ]);
         
        $roleOperational = Role::create([
            'name' => 'Operational',
            'slug' => 'operational',
            'description' => 'Usuario da categoria "Operational" do sistema'
        ]);
        
        $roleStaff = Role::create([
            'name' => 'Staff',
            'slug' => 'staff',
            'description' => 'Usuario da categoria "Staff" do sistema'
        ]);
         

        //ModelMonitor
        //Permissions
        $permModelMonitorStaff = Permission::create([
            'name'        => 'modelmonitor',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do modelmonitor para o nivel staff de usuario'
        ]);
        
        $permModelMonitorOperational = Permission::create([
            'name'        => 'modelmonitor.operational',
            'slug'        => [],
            'inherit_id' => $permModelMonitorStaff->getKey(),
            'description' => 'Administra permissoes do modelmonitor para o nivel operational de usuario'
        ]);
        
        $permModelMonitorManager = Permission::create([
            'name'        => 'modelmonitor.manager',
            'slug'        => [],
            'inherit_id' => $permModelMonitorOperational->getKey(),
            'description' => 'Administra permissoes do modelmonitor para o nivel manager de usuario'
        ]);
        
        $permModelMonitorExecutive = Permission::create([
            'name'        => 'modelmonitor.executive',
            'slug'        => [],
            'inherit_id' => $permModelMonitorManager->getKey(),
            'description' => 'Administra permissoes do modelmonitor para o nivel executive de usuario'
        ]);
        
        $permModelMonitorAdmin = Permission::create([
            'name'        => 'modelmonitor.admin',
            'slug'        => [
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permModelMonitorExecutive->getKey(),
            'description' => 'Administra permissoes do modelmonitor para o nivel admin de usuario'
        ]);
        

        //Assign permissions to rules
        $roleStaff->assignPermission($permModelMonitorStaff);
        $roleOperational->assignPermission($permModelMonitorOperational);
        $roleManager->assignPermission($permModelMonitorManager);
        $roleExecutive->assignPermission($permModelMonitorExecutive);
        $roleAdmin->assignPermission($permModelMonitorAdmin);

        
        

        //ModelSensor
        //Permissions
        $permModelSensorStaff = Permission::create([
            'name'        => 'modelsensor',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do modelsensor para o nivel staff de usuario'
        ]);
        
        $permModelSensorOperational = Permission::create([
            'name'        => 'modelsensor.operational',
            'slug'        => [],
            'inherit_id' => $permModelSensorStaff->getKey(),
            'description' => 'Administra permissoes do modelsensor para o nivel operational de usuario'
        ]);
        
        $permModelSensorManager = Permission::create([
            'name'        => 'modelsensor.manager',
            'slug'        => [],
            'inherit_id' => $permModelSensorOperational->getKey(),
            'description' => 'Administra permissoes do modelsensor para o nivel manager de usuario'
        ]);
        
        $permModelSensorExecutive = Permission::create([
            'name'        => 'modelsensor.executive',
            'slug'        => [],
            'inherit_id' => $permModelSensorManager->getKey(),
            'description' => 'Administra permissoes do modelsensor para o nivel executive de usuario'
        ]);
        
        $permModelSensorAdmin = Permission::create([
            'name'        => 'modelsensor.admin',
            'slug'        => [
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permModelSensorExecutive->getKey(),
            'description' => 'Administra permissoes do modelsensor para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permModelSensorStaff);
        $roleOperational->assignPermission($permModelSensorOperational);
        $roleManager->assignPermission($permModelSensorManager);
        $roleExecutive->assignPermission($permModelSensorExecutive);
        $roleAdmin->assignPermission($permModelSensorAdmin);
        

        //ModelTire
        //Permissions
        $permModelTireStaff = Permission::create([
            'name'        => 'modeltire',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do modeltire para o nivel staff de usuario'
        ]);
        
        $permModelTireOperational = Permission::create([
            'name'        => 'modeltire.operational',
            'slug'        => [],
            'inherit_id' => $permModelTireStaff->getKey(),
            'description' => 'Administra permissoes do modeltire para o nivel operational de usuario'
        ]);
        
        $permModelTireManager = Permission::create([
            'name'        => 'modeltire.manager',
            'slug'        => [],
            'inherit_id' => $permModelTireOperational->getKey(),
            'description' => 'Administra permissoes do modeltire para o nivel manager de usuario'
        ]);
        
        $permModelTireExecutive = Permission::create([
            'name'        => 'modeltire.executive',
            'slug'        => [],
            'inherit_id' => $permModelTireManager->getKey(),
            'description' => 'Administra permissoes do modeltire para o nivel executive de usuario'
        ]);
        
        $permModelTireAdmin = Permission::create([
            'name'        => 'modeltire.admin',
            'slug'        => [
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permModelTireExecutive->getKey(),
            'description' => 'Administra permissoes do modeltire para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permModelTireStaff);
        $roleOperational->assignPermission($permModelTireOperational);
        $roleManager->assignPermission($permModelTireManager);
        $roleExecutive->assignPermission($permModelTireExecutive);
        $roleAdmin->assignPermission($permModelTireAdmin);
        

        //ModelVehicle
        //Permissions
        $permModelVehicleStaff = Permission::create([
            'name'        => 'modelvehicle',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do modelvehicle para o nivel staff de usuario'
        ]);
        
        $permModelVehicleOperational = Permission::create([
            'name'        => 'modelvehicle.operational',
            'slug'        => [],
            'inherit_id' => $permModelVehicleStaff->getKey(),
            'description' => 'Administra permissoes do modelvehicle para o nivel operational de usuario'
        ]);
        
        $permModelVehicleManager = Permission::create([
            'name'        => 'modelvehicle.manager',
            'slug'        => [],
            'inherit_id' => $permModelVehicleOperational->getKey(),
            'description' => 'Administra permissoes do modelvehicle para o nivel manager de usuario'
        ]);
        
        $permModelVehicleExecutive = Permission::create([
            'name'        => 'modelvehicle.executive',
            'slug'        => [],
            'inherit_id' => $permModelVehicleManager->getKey(),
            'description' => 'Administra permissoes do modelvehicle para o nivel executive de usuario'
        ]);
        
        $permModelVehicleAdmin = Permission::create([
            'name'        => 'modelvehicle.admin',
            'slug'        => [
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permModelVehicleExecutive->getKey(),
            'description' => 'Administra permissoes do modelvehicle para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permModelVehicleStaff);
        $roleOperational->assignPermission($permModelVehicleOperational);
        $roleManager->assignPermission($permModelVehicleManager);
        $roleExecutive->assignPermission($permModelVehicleExecutive);
        $roleAdmin->assignPermission($permModelVehicleAdmin);
        

        //TypeVehicle
        //Permissions
        $permTypeVehicleStaff = Permission::create([
            'name'        => 'typevehicle',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do typevehicle para o nivel staff de usuario'
        ]);
        
        $permTypeVehicleOperational = Permission::create([
            'name'        => 'typevehicle.operational',
            'slug'        => [],
            'inherit_id' => $permTypeVehicleStaff->getKey(),
            'description' => 'Administra permissoes do typevehicle para o nivel operational de usuario'
        ]);
        
        $permTypeVehicleManager = Permission::create([
            'name'        => 'typevehicle.manager',
            'slug'        => [],
            'inherit_id' => $permTypeVehicleOperational->getKey(),
            'description' => 'Administra permissoes do typevehicle para o nivel manager de usuario'
        ]);
        
        $permTypeVehicleExecutive = Permission::create([
            'name'        => 'typevehicle.executive',
            'slug'        => [],
            'inherit_id' => $permTypeVehicleManager->getKey(),
            'description' => 'Administra permissoes do typevehicle para o nivel executive de usuario'
        ]);
        
        $permTypeVehicleAdmin = Permission::create([
            'name'        => 'typevehicle.admin',
            'slug'        => [
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permTypeVehicleExecutive->getKey(),
            'description' => 'Administra permissoes do typevehicle para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permTypeVehicleStaff);
        $roleOperational->assignPermission($permTypeVehicleOperational);
        $roleManager->assignPermission($permTypeVehicleManager);
        $roleExecutive->assignPermission($permTypeVehicleExecutive);
        $roleAdmin->assignPermission($permTypeVehicleAdmin);
        

        //User
        //Permissions
        $permUserStaff = Permission::create([
            'name'        => 'user',
            'slug'        => [
                'create' => true,
                'view'   => true,
                'update' => false,
                'delete' => false
            ],
            'description' => 'Administra permissoes do user para o nivel staff de usuario'
        ]);
        
        $permUserOperational = Permission::create([
            'name'        => 'user.operational',
            'slug'        => [],
            'inherit_id' => $permUserStaff->getKey(),
            'description' => 'Administra permissoes do user para o nivel operational de usuario'
        ]);
        
        $permUserManager = Permission::create([
            'name'        => 'user.manager',
            'slug'        => [],
            'inherit_id' => $permUserOperational->getKey(),
            'description' => 'Administra permissoes do user para o nivel manager de usuario'
        ]);
        
        $permUserExecutive = Permission::create([
            'name'        => 'user.executive',
            'slug'        => [],
            'inherit_id' => $permUserManager->getKey(),
            'description' => 'Administra permissoes do user para o nivel executive de usuario'
        ]);
        
        $permUserAdmin = Permission::create([
            'name'        => 'user.admin',
            'slug'        => [
                'update' => true,
                'delete' => true
            ],
            'inherit_id' => $permUserExecutive->getKey(),
            'description' => 'Administra permissoes do user para o nivel admin de usuario'
        ]);
        
        
        //Assign permissions to rules
        $roleStaff->assignPermission($permUserStaff);
        $roleOperational->assignPermission($permUserOperational);
        $roleManager->assignPermission($permUserManager);
        $roleExecutive->assignPermission($permUserExecutive);
        $roleAdmin->assignPermission($permUserAdmin);
        
        
        
        //Assign role to user
    	$user = User::first();
    	if ($user) {
    	    $user->assignRole($roleAdmin);
    	}

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
