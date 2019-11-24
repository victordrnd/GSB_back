<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'libelle' => 'Salarié',
            'niveau' => '1'
        ]);

        Role::create([
            'libelle' => 'Assistant RH',
            'niveau' => '2'
        ]);

        Role::create([
            'libelle' => 'Chargé des Ressources Humaines',
            'niveau' => '3'
        ]);
        Role::create([
            'libelle' => 'Responsable RH',
            'niveau' => '4'
        ]);
        Role::create([
            'libelle' => 'Directeur',
            'niveau' => '5'
        ]);
    }
}
