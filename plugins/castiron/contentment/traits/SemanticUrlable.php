<?php namespace Castiron\Contentment\Traits;

use Doctrine\DBAL\Query\QueryBuilder;
use Exception;
use October\Rain\Database\Builder;
use October\Rain\Router\Helper as RouterHelper;
use Str;
use Request;

trait SemanticUrlable
{

    /**
     * Boot the aliasable trait for a model.
     * @return void
     */
    public static function bootSemanticUrlable()
    {
        if (!property_exists(get_called_class(), 'segmentField')) {
            throw new Exception(sprintf('You must define an $segmentField property in %s to use the SemanticUrlable trait.', get_called_class()));
        }
        if (!property_exists(get_called_class(), 'parentIdField')) {
            throw new Exception(sprintf('You must define an $parentIdField property in %s to use the SemanticUrlable trait.', get_called_class()));
        }
    }

    /**
     * A scope based on the defined segment field
     * @param $query
     * @param $segment
     * @return mixed
     */
    public function scopeWithSegment($query, $segment)
    {
        return $query->where($this->segmentField, $segment);
    }

    /**
     * A scope based on the parent model object
     * @param $query
     * @param $parentId
     * @return mixed
     */
    public function scopeWithParent($query, $parentId)
    {
        return $query->where($this->parentIdField, $parentId);
    }

    /**
     * Given a rootline, makes it into a URL
     * @param $rootline
     * @return string
     */
    protected static function urlForRootline($rootline)
    {
        $parts = $rootline->map(function($model) {
            return $model->{$model->segmentField};
        });
        return '/'.implode('/',$parts->toArray());
    }

    /**
     * Given a segment from a URL and a parent to start from, finds a model matching the segment. Accepts
     * an array of scope methods to call.
     * @param $segment
     * @param $parent
     * @param array $scopes
     * @return mixed
     */
    protected static function modelFromUrlSegment($segment, $parent, $scopes = [])
    {
        $parentId = $parent ? $parent->id : null;

        $query = self::withSegment($segment)->withParent($parentId);
        foreach($scopes as $scope) {
            $query = $query->{$scope}();
        }
        return $query->first();
    }

    /**
     * Wrapper method; turns a URL string into an array of segments
     * @param $url
     * @return array
     */
    protected static function segmentsFromUrl($url)
    {
        return RouterHelper::segmentizeUrl(Str::lower($url));
    }

    /**
     * Uses NestedTree to traverse back up the rootline
     * @param $id
     * @return null
     */
    protected static function rootlineForPid($id)
    {
        $model = self::find($id);
        return $model ? $model->getParentsAndSelf() : null;
    }

    /**
     * Given a URL and an option array of scopes, determines an array of models that walk back up
     * to the root.
     * @param $url
     * @param array $scopes
     * @return null
     */
    protected static function rootlineForUrl($url, $scopes = [])
    {
        $urlSegments = self::segmentsFromUrl($url);
        $rootline = [];
        $parentModel = null;
        foreach($urlSegments as $segment) {
            $model = self::modelFromUrlSegment($segment, $parentModel, $scopes);
            if($model == null) {
                return null;
            }
            $rootline[] = $model;
            $parentModel = $model;
        }
        $lastModel = array_pop($rootline);
        return $lastModel ? $lastModel->getParentsAndSelf() : null;
    }

    /**
     * Given a URL and an array of relevant scopes, finds the referred to model.
     * @param $url
     * @return null
     */
    public static function findByUrl($url, $scopes = [])
    {
        $rootline = self::rootlineForUrl($url, $scopes);
        return $rootline ? $rootline->last() : null;
    }

    /**
     * Generates a URL for a model id
     * @param $id
     * @return null|string
     */
    public static function urlForModelId($id)
    {
        $rootline = self::rootlineForPid($id);
        if($rootline) {
            return self::urlForRootline($rootline);
        }
        return null;
    }

    /**
     * Helper method for getting the URL
     * @return null|string
     */
    public function getUrl() {
        if (array_key_exists('url', $this->attributes) && $this->attributes['url']) {
            return $this->attributes['url'];
        }
        return self::urlForModelId($this->id);
    }

    /**
     * @return string
     */
    public function getAbsoluteUrl() {
        if ($url = $this->getUrl()) {
            return rtrim(Request::root() . $url, '/');
        }
        return null;
    }
}
