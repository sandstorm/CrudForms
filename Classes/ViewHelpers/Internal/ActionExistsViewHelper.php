<?php

namespace Sandstorm\CrudForms\ViewHelpers\Internal;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Reflection\ReflectionService;
use Neos\FluidAdaptor\Core\ViewHelper\AbstractViewHelper;

class ActionExistsViewHelper extends AbstractViewHelper
{

    /**
     * @Flow\Inject
     * @var ReflectionService
     */
    protected $reflectionService;

    /**
     * @param string $action
     */
    public function render($action)
    {
        $controllerObjectName = $this->controllerContext->getRequest()->getControllerObjectName();
        return $this->reflectionService->hasMethod($controllerObjectName, $action . 'Action');
    }
}
