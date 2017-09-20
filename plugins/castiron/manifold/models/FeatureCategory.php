<?php namespace Castiron\Manifold\Models;

use Model;
use Castiron\Manifold\Models\UserType;

/**
 * feature_category Model
 */
class FeatureCategory extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'castiron_manifold_feature_categories';

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
      'features' => 'Castiron\Manifold\Models\Feature'
    ];
    public $belongsTo = [
      'user_type' => 'Castiron\Manifold\Models\UserType'
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getUserTypeOptions($value, $formData)
    {
      $userTypesArr = [];
      $userTypes = UserType::all();
      foreach($userTypes as $userType) {
        $userTypesArr[$userType->id] = $userType->name;
      }
      return $userTypesArr;
    }
}
