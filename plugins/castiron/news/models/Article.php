<?php namespace Castiron\News\Models;

use Castiron\Lib\Traits\Visible;
use Castiron\Lib\Contracts\Visible as VisibleContract;
use Model;
use October\Rain\Database\Traits\Sluggable;

/**
 * Article Model
 */
class Article extends Model implements VisibleContract
{
    use Sluggable;
    use Visible;

    var $slugs = [
        'slug' => 'title'
    ];
    /**
     * @var string The database table used by the model.
     */
    public $table = 'castiron_news_articles';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    protected $keywordSearchableFields = [
        'id',
    ];

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

    /**
     * @return string
     */
    public function getCmsUrlAttribute() {
        return "/news/$this->slug";
    }

    /**
     *
     */
    protected function updateSlug() {
        $this->slug = \Str::slug($this->full_name);
    }

    /**
     * Generate a URL slug for this model
     */
    public function beforeCreate()
    {
        if (!$this->slug) {
            $this->updateSlug();
        }
    }

    /**
     *
     */
    public function beforeUpdate()
    {
        if (!$this->slug) {
            $this->updateSlug();
        }
    }

    /**
     *
     */
    public function afterFetch()
    {
        if (!$this->slug) {
            $this->updateSlug();
        }
    }
}
