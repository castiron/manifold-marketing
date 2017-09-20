<?php namespace Castiron\Manifold\Models;

use Model;

/**
 * user_type Model
 */
class UserType extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'castiron_manifold_user_types';

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
    public $hasMany = [
      'feature_categories' => 'Castiron\Manifold\Models\FeatureCategory'
    ];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
