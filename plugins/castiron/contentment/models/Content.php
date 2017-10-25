<?php namespace Castiron\Contentment\Models;

use Castiron\Contentment\Content\Element;
use Castiron\Contentment\Content\Elements\InvalidElement;
use Castiron\Lib\Traits\Visible;
use Castiron\Peaches\Support\Arr;
use Illuminate\Database\Eloquent\SoftDeletes;
use October\Rain\Database\Model;
use Castiron\Contentment\Errors\InvalidElementException;
use October\Rain\Database\Traits\Sortable;
use October\Rain\Database\Traits\Validation;
use Castiron\Lib\Contracts\Visible as VisibleContract;

/**
 * Class Content
 * @package Castiron\Contentment\Models
 */
class Content extends Model implements VisibleContract
{
    use Validation;
    use SoftDeletes;
    use Sortable;
    use Visible;

    /** @var string  */
    public $table = 'castiron_contentment_contents';

    /** @var array */
    protected $guarded = ['*'];

    /** @var array Nothing here, since validation happens on element mostly */
    protected $rules = [];

    /** @var array */
    protected $fillable = ['page_id','data','element_type'];

    /** @var Element This is the tangential class managing the real value.  */
    protected $element = null;

    /** @var array  */
    protected $jsonable = ['data'];

    /** @var array */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    /** @var array Which events (fired here first) are relayed to the model. */
    protected static $relayableLaravelEvents = [
        'saving','saved',
        'deleting','deleted'
    ];

    /** @var array Which events (fired here first) are relayed to the model. */
    protected static $relayableOctoberEvents = [
        'model.beforeSave', 'model.afterSave', 'model.saveInternal'
    ];

    /**
     * @var array
     */
    public $morphTo = [
        'contentable' => []
    ];

    /**
     * @return \October\Rain\Database\Relations\BelongsTo
     */
    public function contentable()
    {
        return $this->morphTo();
    }

    /**
     * Content constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        if ($this->canMakeElement()) {
            $this->element = $this->makeElement($this->data);
        }

        $this->bindEvent('model.saveInternal', function ($attributes, $options) {
            $this->beforeSaveInternal();
        });
    }

    /**
     * @param $query
     */
    public function scopeOrdered($query)
    {
        $query->orderBy('sort_order', 'asc');
    }

    /**
     *
     */
    public function beforeSaveInternal()
    {
        $element = $this->element();
        $this->data = $element->toData();
        $rendered = $element->renderStatic();
        if ($rendered !== false) {
             $this->rendered = $rendered;
        }
    }

    /**
     * @return mixed|string
     */
    public function render()
    {
        if ($this->rendered) {
            return $this->rendered;
        }
        return $this->element()->render();
    }

    /**
     * @return string
     */
    public function renderPreview()
    {
        return $this->element()->renderPreview();
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->element()->fromData($data);
    }

    /**
     *
     */
    public function toggleHidden()
    {
        $this->is_hidden = ! $this->is_hidden;
    }

    /**
     * @return Element
     */
    public function element()
    {
        if (!$this->element) {
            $this->element = $this->makeElement($this->data);
        }
        return $this->element;
    }

    /**
     * @return bool
     */
    public function canMakeElement()
    {
        return (bool) $this->element_type;
    }

    /**
     * @param string $event
     * @param bool $halt
     * @return bool|mixed
     */
    protected function fireModelEvent($event, $halt = true)
    {
        $res = true;

        if (in_array($event, static::$relayableLaravelEvents) && $this->canMakeElement()) {
            $res = $this->element()->relayModelEvent($event, $halt);
        }
        if ($halt && $res === false) {
            if (in_array(Validation::class, class_uses($this->element))) {
                $this->validationErrors = $this->element->errors();
            }
            return false;
        }
        return parent::fireModelEvent($event, $halt);
    }

    /**
     * @param string $event
     * @param array $params
     * @param bool $halt
     * @return array|bool
     */
    public function fireEvent($event, $params = [], $halt = false)
    {
        $res = true;

        if (in_array($event, static::$relayableOctoberEvents) && $this->canMakeElement()) {
            $data = Arr::safePath($params, '0.data');
            if ($data) {
                $res = $this->element()->relayEvent($event, [json_decode($data, true), []], $halt);
            }

        }
        if ($halt && $res === false) {
            if (in_array(Validation::class, class_uses($this->element))) {
                $this->validationErrors = $this->element->errors();
            }
            return false;
        }
        return parent::fireEvent($event, $params, $halt);
    }

    /**
     * @param mixed $data
     * @return Element
     * @throws InvalidElementException
     * @throws \Exception
     */
    protected function makeElement($data = null)
    {
        try {
            $t = $this->type();
        } catch (InvalidElementException $e) {
            $el = new InvalidElement(['error' => $e->getMessage()]);
            $el->exists = true;
            $this->is_hidden = true;
            return $el;
        }

        $e = new $t();
        if ($data) {
            $e->fromData($data, $this->id);
        }
        $e->exists = true;
        return $e;
    }

    /**
     * @return string
     * @throws InvalidElementException
     * @throws \Exception
     */
    protected function type()
    {
        $type = $this->element_type;
        if (!$type) {
            throw new InvalidElementException("Cannot determine content type for ContentElement. Is `content_type` specified?");
        }
        if (!class_exists($type)) {
            throw new InvalidElementException("Cannot instantiate content type for ContentElement. Class '$type' does not exist");
        }
        return $type;
    }
}
