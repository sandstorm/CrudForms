<?php
namespace Sandstorm\CrudForms\ViewHelpers\Widget;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Exception\InfiniteLoopException;
use Neos\Flow\Mvc\Exception\StopActionException;
use Neos\FluidAdaptor\Core\Widget\AbstractWidgetViewHelper;
use Neos\FluidAdaptor\Core\Widget\Exception\InvalidControllerException;
use Neos\FluidAdaptor\Core\Widget\Exception\MissingControllerException;

/**
 * This ViewHelper renders a Filter for a list of objects.
 *
 * = Examples =
 *
 * <code title="simple configuration">
 * <crud:widget.filter objects="{blogs}" as="filteredBlogs" filterProperty="author">
 *   // use {filteredBlogs} as you used {blogs} before, most certainly inside
 *   // a <f:for> loop.
 * </crud:widget.filter>
 * </code>
 *
 * @api
 */
class FilterViewHelper extends AbstractWidgetViewHelper
{
    /**
     * @Flow\Inject
     * @var Controller\FilterController
     */
    protected $controller;

    public function initializeArguments():void
    {
        $this->registerArgument('objects', 'object', 'a QueryResultInterface of the objects to filter on', true);
        $this->registerArgument('as', 'string', 'variable as which the filtered list will be available', true);
        $this->registerArgument('filterProperty', 'string', 'which property to filter on', true);
        $this->registerArgument('filterPlaceholder', 'string', 'placeholder to display in the filter input field', false, null);
    }

    /**
     * @return string
     * @throws InfiniteLoopException
     * @throws InvalidControllerException
     * @throws MissingControllerException
     * @throws StopActionException
     */
    public function render(): string
    {
        return $this->initiateSubRequest();
    }
}
