<?php

namespace Sandstorm\CrudForms\View;


use Neos\Flow\Mvc\Controller\ControllerContext;
use Neos\FluidAdaptor\View\TemplateView;

class ExtendedTemplateView extends TemplateView
{
    public function setControllerContext(ControllerContext $controllerContext)
    {
        parent::setControllerContext($controllerContext);

        // We can only override the partial root paths once the controller context is set; as otherwise the @packageResourcesPath
        // placeholder cannot be replaced. That's why we have to add the partialRootPaths in setControllerContext; and not anymore in
        // the constructor.
        $partialRootPaths = $this->getRenderingContext()->getTemplatePaths()->getPartialRootPaths();
        $partialRootPaths[] = 'resource://Sandstorm.CrudForms/Private/Partials/';
        $this->getRenderingContext()->getTemplatePaths()->setPartialRootPaths($partialRootPaths);
    }
}
