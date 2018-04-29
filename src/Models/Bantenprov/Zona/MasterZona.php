<?php

namespace Bantenprov\Zona\Models\Bantenprov\Zona;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterZona extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'master_zonas';
    protected $fillable = [
        'user_id',
        'tingkat',
        'kode',
        'label',
    ];
    protected $hidden = [
    ];
    protected $appends = [
    ];
    protected $dates = [
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
