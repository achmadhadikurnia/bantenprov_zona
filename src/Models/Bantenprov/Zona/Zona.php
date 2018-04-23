<?php

namespace Bantenprov\Zona\Models\Bantenprov\Zona;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zona extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'zonas';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'nomor_un',
        'sekolah_id',
        'zona_siswa',
        'zona_sekolah',
        'lokasi_siswa',
        'lokasi_sekolah',
        'nilai',
        'user_id',
    ];

    public function siswa()
    {
        return $this->belongsTo('Bantenprov\Siswa\Models\Bantenprov\Siswa\Siswa','nomor_un','nomor_un');
    }

    public function sekolah()
    {
        return $this->belongsTo('Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Sekolah','sekolah_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function nilai($lokasi_siswa, $lokasi_sekolah)
    {
        $nilai = 0;

        if ($lokasi_siswa == $lokasi_sekolah) {
            $nilai  = $nilai + config('bantenprov.zona.zona.satu_desa');
        }

        if (substr($lokasi_siswa, 0, 6) == substr($lokasi_sekolah, 0, 6)) {
            $nilai  = $nilai + config('bantenprov.zona.zona.satu_kecamatan');
        }

        return $nilai;
    }
}
