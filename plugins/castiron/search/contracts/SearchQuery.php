<?php

namespace Castiron\Search\Contracts;

interface SearchQuery extends \JsonSerializable
{

    /**
     * @return string
     */
    public function getEndpoint();

    /**
     * @param string $type
     */
    public function setType($type);

    /**
     * @param string $boostType
     */
    public function setBoostType($boostType);

    /**
     * @param string $index
     */
    public function setIndex($index);

    /**
     * @param string $keyword
     */
    public function setKeyword($keyword);

    /**
     * @param integer $pageOffset
     */
    public function setFrom($pageOffset);

    /**
     * @return integer
     */
    public function getFrom();

    /**
     * @param integer $pageSize
     */
    public function setSize($pageSize);
}
