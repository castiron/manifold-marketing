<?php namespace Castiron\Manifold\Models;

use Model;
use Castiron\Manifold\Models\FeatureCategory;

/**
 * feature Model
 */
class Feature extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'castiron_manifold_features';

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
    public $belongsTo = [
      'feature_category' => 'Castiron\Manifold\Models\FeatureCategory'];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function getFeatureCategoryOptions($value, $formData)
    {
      $featureCategoriesArr = [];
      $featureCategories = FeatureCategory::all();
      foreach($featureCategories as $featureCategory) {
        $featureCategoriesArr[$featureCategory->id] = $featureCategory->name;
      }
      return $featureCategoriesArr;
    }
}
