<?php namespace Castiron\Contentment\Traits;

use Exception;

trait Aliasable
{
    /**
     * Boot the aliasable trait for a model.
     * @return void
     */
    public static function bootAliasable()
    {
        if (!property_exists(get_called_class(), 'aliasField')) {
            throw new Exception(sprintf('You must define an $aliasField property in %s to use the Aliasable trait.', get_called_class()));
        }
    }

    /**
     * Overrides the find method and uses the alias field for the look up if we're dealing with a non-integer. Note:
     * classes that use this trait can't have aliases that are numbers, or this won't work.
     * @param $idOrAlias mixed
     * @param array $columns
     * @return mixed
     */
    public static function find($idOrAlias, $columns = array('*'))
    {
        $instance = new static;
        $aliasField = $instance->aliasField;
        if(is_int($idOrAlias) || ctype_digit($idOrAlias) || empty($idOrAlias)) {
            return parent::where($instance->getKeyName(), '=', $idOrAlias)->first($columns);
        } else {
            return parent::where($aliasField,'=', $idOrAlias)->first();
        }
    }
}
