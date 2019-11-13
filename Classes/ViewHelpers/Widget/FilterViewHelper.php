<?php
namespace Sandstorm\CrudForms\ViewHelpers\Widget;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Exception\InfiniteLoopException;
use Neos\Flow\Mvc\Exception\StopActionException;
use Neos\Flow\Persistence\QueryResultInterface;
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
 * </f:widget.paginate>
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

    /**
     * Render this view helper
     *
     * @param QueryResultInterface $objects the objects to filter on
     * @param string $as variable as which the filtered list will be available
     * @param string $filterProperty which property to filter on
     * @param string $filterPlaceholder placeholder to display in the filter input field
     * @return string
     * @throws InfiniteLoopException
     * @throws StopActionException
     * @throws InvalidControllerException
     * @throws MissingControllerException
     */
    public function render(QueryResultInterface $objects, $as, $filterProperty, $filterPlaceholder = NULL)
    {
        $response = $this->initiateSubRequest();
        return $response->getContent();
    }
}
