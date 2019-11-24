<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'libelle' => 'En attente',
            'color' => '#fbc02d'
        ]);


        Status::create([
            'libelle' => 'Validé',
            'color' => '#00e676'
        ]);

        Status::create([
            'libelle' => 'Refusé',
            'color' => '#f44336'
        ]);
    }
}
