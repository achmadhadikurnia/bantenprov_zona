<?php namespace Bantenprov\Zona\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The ZonaModel class.
 *
 * @package Bantenprov\Zona
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ZonaModel extends Model
{
    /**
    * Table name.
    *
    * @var string
    */
    protected $table = 'zona';

    /**
    * The attributes that are mass assignable.
    *
    * @var mixed
    */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
