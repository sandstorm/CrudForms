<?php

namespace Sandstorm\CrudForms\ViewHelpers\Internal;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Fluid\View\Exception\InvalidTemplateResourceException;

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
