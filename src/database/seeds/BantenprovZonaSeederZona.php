<?php

/* Require */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/* Models */
use Bantenprov\Zona\Models\Bantenprov\Zona\Zona;

class BantenprovZonaSeederZona extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
        Model::unguard();

        $zonas = (object) [
            (object) [
                'label' => 'Zona 1',
                'description' => 'Zona 1',
            ],
            (object) [
                'label' => 'Zona 2',
                'description' => 'Zona 2',
            ]
        ];

        foreach ($zonas as $zona) {
            $model = Zona::updateOrCreate(
                [
                    'label' => $zona->label,
                ],
                [
                    'description' => $zona->description,
                ]
            );
            $model->save();
        }
	}
}
