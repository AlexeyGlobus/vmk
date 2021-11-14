<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('places')->insert(
            [
                'name' => '30-24',
                'coords' => 'point(56.573761698094046 36.42708835889252)',
                'type' => Place::TYPE_PRIVATE,
                'ownersName' => 'Name',
                'ownersSurname' => 'Surname',
                'ownersPatronymic' => 'Patronymic',
                'ownersEmail' => 'email@yandex.ru',
                'ownersPhone' => '+74952222222'
            ]
        );
    }
}
