<?php

namespace Castiron\Manifold\Content;

use Castiron\Contentment\Content\Element;
use Castiron\Contentment\Content\Traits\Twiggable;

/**
 * DocumentationNav Element
 */
class DocumentationNav extends Element
{

    use Twiggable;

    public function links()
    {
      return [
        array(
          "text" => "Publishers",
          "url" => "#",
          "icon" => "bookpile-small"
        ),
        array(
          "text" => "Developers",
          "url" => "#",
          "icon" => "laptop-dev"
        ),
        array(
          "text" => "Readers",
          "url" => "#",
          "icon" => "book-page-turn"
        ),
        array(
          "text" => "Authors",
          "url" => "#",
          "icon" => "laptop"
        ),
      ];
    }
}
