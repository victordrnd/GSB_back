<?php

use App\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Salarié
        RolePermission::create([
            'permission_id' => 3,
             'role_id' => 1
        ]);
        RolePermission::create([
            'permission_id' => 4,
             'role_id' => 1
        ]);
        RolePermission::create([
            'permission_id' => 5,
             'role_id' => 1
        ]);
        RolePermission::create([
            'permission_id' => 10,
             'role_id' => 1
        ]);


        //Assistant RH
        $role_permission_salarie = RolePermission::all();
        $role_permission_salarie->each(function($item){
            $newRolePermission = new RolePermission();
            $item->role_id = 2;
            unset($item->id);
            $newRolePermission->fill($item->toArray());
            $newRolePermission->save();
        });

        RolePermission::create([
            'permission_id' => 1,
            'role_id' => 2
        ]);

        //Chargé des ressources humaines
        $role_permission_assistant = RolePermission::where('role_id', 2)->get();
        $role_permission_assistant->each(function($item){
            $newRolePermission = new RolePermission();
            $item->role_id = 3;
            unset($item->id);
            $newRolePermission->fill($item->toArray());
            $newRolePermission->save();
        });
        RolePermission::create([
            'permission_id' => 2,
            'role_id' => 3
        ]);
        RolePermission::create([
            'permission_id' => 6,
            'role_id' => 3
        ]);


        //Responsable RH
        $role_permission_rh = RolePermission::where('role_id', 3)->get();
        $role_permission_rh->each(function($item){
            $newRolePermission = new RolePermission();
            $item->role_id = 4;
            unset($item->id);
            $newRolePermission->fill($item->toArray());
            $newRolePermission->save();
        });
        RolePermission::create([
            'permission_id' => 7,
            'role_id' => 4
        ]);
        RolePermission::create([
            'permission_id' => 8,
            'role_id' => 4
        ]);


        //Directeur
        $role_permission_rh = RolePermission::where('role_id', 4)->get();
        $role_permission_rh->each(function($item){
            $newRolePermission = new RolePermission();
            $item->role_id = 5;
            unset($item->id);
            $newRolePermission->fill($item->toArray());
            $newRolePermission->save();
        });
        RolePermission::create([
            'permission_id' => 9,
            'role_id' => 5
        ]);
        RolePermission::create([
            'permission_id' => 11,
            'role_id' => 5
        ]);

    }
}
