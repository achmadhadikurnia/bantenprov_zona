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
        'user_id',
        'master_zona_id',
        'nomor_un',
        'sekolah_id',
        'zona_siswa',
        'zona_sekolah',
        'lokasi_siswa',
        'lokasi_sekolah',
        'nilai_zona'
    ];

    public function siswa()
    {
        return $this->belongsTo('Bantenprov\Siswa\Models\Bantenprov\Siswa\Siswa','nomor_un','nomor_un');
    }

    public function master_zona()
    {
        return $this->belongsTo('Bantenprov\Zona\Models\Bantenprov\Zona\MasterZona','master_zona_id');
    }

    public function sekolah()
    {
        return $this->belongsTo('Bantenprov\Sekolah\Models\Bantenprov\Sekolah\Sekolah','sekolah_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
