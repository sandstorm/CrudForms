<?php

namespace Sandstorm\CrudForms\ViewHelpers\Internal;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Reflection\ReflectionService;
use Neos\FluidAdaptor\Core\ViewHelper\AbstractViewHelper;
use Neos\FluidAdaptor\Core\ViewHelper\Exception;

class ActionExistsViewHelper extends AbstractViewHelper
{

    /**
     * @return void
     * @throws Exception
     */
    public function initializeArguments()
    {
        $this->registerArgument('action', 'string', 'action', true);
    }

    /**
     * @Flow\Inject
     * @var ReflectionService
     */
    protected $reflectionService;

    /**
     * @return bool
     */
    public function render()
    {
        $action = $this->arguments['action'];
        $controllerObjectName = $this->controllerContext->getRequest()->getControllerObjectName();
        return $this->reflectionService->hasMethod($controllerObjectName, $action . 'Action');
    }
}
