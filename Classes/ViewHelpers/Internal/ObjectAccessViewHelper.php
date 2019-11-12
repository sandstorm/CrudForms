<?php

namespace Sandstorm\CrudForms\ViewHelpers\Internal;

use Neos\Utility\ObjectAccess;
use Neos\FluidAdaptor\Core\ViewHelper\AbstractViewHelper;

/**
 * Class ObjectAccessViewHelper
 * @package Sandstorm\CrudForms\ViewHelpers
 */
class ObjectAccessViewHelper extends AbstractViewHelper
{

    /**
     * @return void
     * @throws \Neos\FluidAdaptor\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        $this->registerArgument('property', 'string', 'property', true);
    }

    /**
     * @return mixed
     */
    public function render()
    {
        $property = $this->arguments['property'];
        $object = $this->renderChildren();
        return ObjectAccess::getPropertyPath($object, $property);
    }
}
