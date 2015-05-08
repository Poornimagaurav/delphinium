<?php namespace Delphinium\Blossom\Models;

use Model;

/**
 * leaderboard Model
 */
class Leaderboard extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'delphinium_blossom_leaderboards';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}