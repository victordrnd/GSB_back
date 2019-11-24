<?php

use Illuminate\Database\Seeder;
use App\Type;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'libelle' => 'Restauration'
        ]);

        Type::create([
            'libelle' => 'Grand déplacement'
        ]);

        Type::create([
            'libelle' => 'Télétravail'
        ]);

        Type::create([
            'libelle' => 'Transport'
        ]);
        Type::create([
            'libelle' => 'Logement'
        ]);
    }
}
