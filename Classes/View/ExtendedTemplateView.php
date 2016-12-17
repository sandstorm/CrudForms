<?php

namespace Sandstorm\CrudForms\View;


use Neos\FluidAdaptor\View\TemplateView;

class ExtendedTemplateView extends TemplateView
{
    public function __construct(array $options)
    {
        parent::__construct($options);
        $partialRootPaths = $this->getRenderingContext()->getTemplatePaths()->getPartialRootPaths();
        $partialRootPaths[] = 'resource://Sandstorm.CrudForms/Private/Partials/';
        $this->getRenderingContext()->getTemplatePaths()->setPartialRootPaths($partialRootPaths);
    }
}
