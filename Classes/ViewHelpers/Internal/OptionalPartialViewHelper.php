<?php

namespace Sandstorm\CrudForms\ViewHelpers\Internal;

use Neos\Flow\Annotations as Flow;
use Neos\FluidAdaptor\Core\ViewHelper\AbstractViewHelper;
use Neos\FluidAdaptor\View\Exception\InvalidTemplateResourceException;

class OptionalPartialViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = FALSE;

    public function render()
    {
        try {
            return $this->renderChildren();
        } catch (InvalidTemplateResourceException $e) {
            // silently swallow
        }
    }
}
