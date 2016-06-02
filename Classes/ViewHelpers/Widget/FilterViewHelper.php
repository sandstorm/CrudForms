<?php
namespace Sandstorm\CrudForms\ViewHelpers\Widget;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\QueryResultInterface;
use TYPO3\Fluid\Core\Widget\AbstractWidgetViewHelper;

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
     */
    public function render(QueryResultInterface $objects, $as, $filterProperty, $filterPlaceholder = NULL)
    {
        $response = $this->initiateSubRequest();
        return $response->getContent();
    }
}
