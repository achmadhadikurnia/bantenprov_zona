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
                'user_id' => '1',
                'kegiatan_id' => '1',
                'label' => 'Kegiatan 1',
                'description' => 'Kegiatan satu'
            ],
            (object) [
                'user_id' => '2',
                'kegiatan_id' => '2',
                'label' => 'Kegiatan 2',
                'description' => 'Kegiatan dua',
            ]
        ];

        foreach ($zonas as $zona) {
            $model = Zona::updateOrCreate(
                [
                    'user_id' => $zona->user_id,
                    'kegiatan_id' => $zona->kegiatan_id,
                    'label' => $zona->label,
                    'description' => $zona->description,
                ]
            );
            $model->save();
        }
	}
}
