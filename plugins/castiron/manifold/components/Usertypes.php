<?php namespace Castiron\Manifold\Components;

use Cms\Classes\ComponentBase;
use Castiron\Manifold\Models\FeatureCategory;
use Castiron\Manifold\Models\UserType;
use Castiron\Manifold\Models\Feature;

class Usertypes extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'usertypes Component',
            'description' => 'User Types and all child data'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function all()
    {
        return UserType::all();
    }
}
