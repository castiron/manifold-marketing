<?php

namespace Castiron\Search\Models;

use Castiron\Search\Contracts\SearchQuery;

/**
 * Simple query model
 */
class Query implements SearchQuery
{
    /**
     * @var callable elasticsearch endpoint
     */
    protected $endpointMaker;

    /**
     * @var integer result offset to start fetching from
     */
    protected $from;

    /**
     * @var integer number of results to fetch at once
     */
    protected $size;

    /**
     * @var string the current queequeg type
     */
    protected $type;

    /**
     * @var string the current keyword
     */
    protected $keyword;

    /**
     * @var string the type to boost to the top of results
     */
    protected $boostType;

    /**
     * @var string the current queequeg index
     */
    protected $index;

    /**
     * @param callable $endpointMaker
     */
    public function __construct($endpointMaker)
    {
        $this->size = 10;
        $this->from = 0;
        $this->endpointMaker = $endpointMaker;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param string $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * @param string $boostType
     */
    public function setBoostType($boostType) {
        $this->boostType = $boostType;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getEndpoint()
    {
        $func = $this->endpointMaker;
        if (is_callable($func)) {
            return $func($this->index, $this->type);
        }

        throw new \Exception("No function has been defined to make the search endpoint.");
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setFrom($from)
    {
        $this->from = intval($from);
    }

    /**
     * @param $size
     */
    public function setSize($size)
    {
        $this->size = intval($size);
    }

    /**
     * @param $keyword string
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * The default query returns all results
     * The empty stdclass gets us an empty object on json_encode
     *
     * @return array
     */
    protected function emptyQuery() {
        return [ 'bool' => [
            'must' => ['match_all' => new \stdClass()],
        ]];
    }

    /**
     * @return array
     */
    protected function getQuery() {
        if ($this->keyword) {
            $out = [ 'bool' => [
                'must' => ['match' => ['_all' => [
                    'query' => $this->keyword,
                    'operator' => 'and'
                ]]]
            ]];
        } else {
            $out = $this->emptyQuery();
        }

        if ($terms = $this->getBoostQueryParams()) {
            $out['bool']['should'] = $terms;
        }
        return $out;
    }

    /**
     * @param $value
     * @param $boost
     * @param string $property
     * @return array
     */
    protected static function boostTerm($value, $boost, $property = '_type')
    {
        return [
            'term' => [
                $property => [
                    'value' => $value,
                    'boost' => $boost,
                ]
            ]
        ];
    }

    /**
     * @return array|null
     */
    protected function getBoostQueryParams() {
        $out = null;

        if (!$this->boostType) {
            return $out;
        }

        if (is_string($this->boostType)) {
            $out = static::boostTerm($this->boostType, '200');
        }

        if (is_array($this->boostType)) {
            $out = [];
            foreach ($this->boostType as $type => $boost) {
                $out[] = static::boostTerm($type, $boost);
            }
        }

        return $out;
    }

    /**
     * @return string
     */
    function jsonSerialize()
    {
        $out = [
            'from' => $this->from,
            'size' => $this->size,
            'query' => $this->getQuery(),
        ];
        return json_encode($out);
    }
}
