<?php

namespace Castiron\Manifold\Content;

use Castiron\Contentment\Content\Element;
use Castiron\Contentment\Content\Traits\Twiggable;
use Castiron\Manifold\Models\UserType;

/**
 * ActionsListing Element
 */
class ActionsListing extends Element
{

    use Twiggable;

    public function allUserTypes()
    {
        return UserType::all();
    }
}
