<?php

namespace Castiron\Contentment\Content;

use October\Rain\Database\Model;
use Castiron\Contentment\Content\Manager as ContentManager;

abstract class Element extends Model
{

    // our configurations


    // laravel settings for these types of models
    protected static $unguarded = true;
    protected $guarded = [];
    public $timestamps = false;


    /**
     * @return string
     */
    public function render()
    {
        return '';
    }


    /**
     * If possible, you can pre-render this element so no
     * processing needs to happen at run time.
     *
     * Return false if rendering is dependent on dynamic values
     * like dates or other content.
     *
     * @return bool|string
     */
    public function renderStatic()
    {
        return $this->render();
    }

    /**
     * Render this element as a preview in the backend.
     *
     * @return string
     */
    public function renderPreview()
    {
        return $this->typeLabel();
    }


    /**
     * Take data from the database and absorb it into this model.
     *
     * @param mixed $data
     */
    public function fromData($data = [], $id = null)
    {
        if ($id) {
            $data = array_merge(['id' => $id], $data);
        }
        $this->fill($data);
    }

    /**
     * Turn this model into a jsonable value that can be stored in the database.
     *
     * @return mixed
     */
    public function toData()
    {
        $attributes = $this->toArray();
        unset($attributes['id']);
        if (count($attributes)) {
            return $attributes;
        }
        return null;
    }

    /**
     * @return string
     */
    public function typeLabel()
    {
        $element = ContentManager::instance()->elements(static::class);
        if ($element) {
            return $element->label;
        }
        return class_basename($this);
    }

    /**
     * The Content model relays its events to this "model".
     *
     * @param $event
     * @param bool|true $halt
     * @return mixed
     */
    public function relayModelEvent($event, $halt = true)
    {
        return $this->fireModelEvent($event, $halt);
    }

    /**
     * @param $event
     * @param array $params
     * @param bool|false $halt
     * @return array
     */
    public function relayEvent($event, $params = [], $halt = false)
    {
        return $this->fireEvent($event, $params, $halt);
    }
}
