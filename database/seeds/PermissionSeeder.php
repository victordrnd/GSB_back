<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'libelle' => 'Afficher tous les frais',
            'slug' => 'frais.view'
        ]);

        Permission::create([
            'libelle' => "Modifier le status d'un frais",
            'slug' => 'frais.edit-status'
        ]);



        // Frais personnel
        Permission::create([
            'libelle' => 'Afficher mes frais personnels',
            'slug' => 'my.frais.view'
        ]);

        Permission::create([
            'libelle' => 'Modifier un frais personnel',
            'slug' => 'my.frais.edit'
        ]);

        Permission::create([
            'libelle' => 'Supprimer un frais personnel',
            'slug' => 'my.frais.delete'
        ]);

        


        //Gestion utilisateur

        Permission::create([
            'libelle' => 'Afficher la liste des utilisateurs',
            'slug' => 'users.view'
        ]);

        Permission::create([
            'libelle' => 'Modifier un utilisateur',
            'slug' => 'users.edit'
        ]);

        Permission::create([
            'libelle' => 'Supprimer un utilisateur',
            'slug' => 'users.delete'
        ]);

        Permission::create([
            'libelle' => "Modifier le role d'un utilisateur",
            'slug' => 'users.edit-role'
        ]);

        
        Permission::create([
            'libelle' => 'Créer un frais personnel',
            'slug' => 'my.frais.create'
        ]);

    }
}
