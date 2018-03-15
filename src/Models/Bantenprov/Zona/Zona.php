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
        'label',
        'description'
    ];
}
