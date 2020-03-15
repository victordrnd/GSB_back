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
            'color' => 'orange'
        ]);


        Status::create([
            'libelle' => 'Validé',
            'color' => 'purple'
        ]);

        Status::create([
            'libelle' => 'Refusé',
            'color' => 'volcano'
        ]);
    }
}
