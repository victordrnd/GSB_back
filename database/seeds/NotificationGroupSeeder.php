<?php

use Illuminate\Database\Seeder;
use App\NotificationGroup;

class NotificationGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            //$notification_key = \FCMGroup::createGroup("gestion", ['dENwNPtahd5skzpGSg_FYa:APA91bFHloNwLQHDkFc5Wcn1p32jLvlRq0u_qSN2mAFLTQ7vR6XNl6af2407PU2ocQFkL_xwPbrxppXCSp3HQMCyjzTHnwWuBDdCI_06ezVRlgu901dRiiwhVAFqptpa0cdcX3kNpEaK']);
            NotificationGroup::create([
                "libelle" => "Comptabilité",
                'slug' => "gestion",
                "notification_key" => "APA91bHKj5bpB1Z2kvq5PaXBlIG9Oi8JOXYH8fs7ColJA5LByRzIPbo7EdhIW8pjVqJiMody5YR0CBfZfJSuvS27mXwVzoORMWb-AACH8CLFDqEGhtvqS9g"
            ]);
    }
}
