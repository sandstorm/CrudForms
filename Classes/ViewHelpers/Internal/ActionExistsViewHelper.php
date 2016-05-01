<?php

namespace Sandstorm\CrudForms\ViewHelpers\Internal;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Reflection\ReflectionService;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;

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
