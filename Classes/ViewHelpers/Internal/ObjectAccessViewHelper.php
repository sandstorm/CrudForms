<?php

namespace Sandstorm\CrudForms\ViewHelpers\Internal;

use Neos\Utility\ObjectAccess;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class ObjectAccessViewHelper
 * @package Sandstorm\CrudForms\ViewHelpers
 */
class ObjectAccessViewHelper extends AbstractViewHelper
{

    /**
     * @param string $property
     */
    public function render($property)
    {
        $object = $this->renderChildren();
        return ObjectAccess::getPropertyPath($object, $property);
    }
}
