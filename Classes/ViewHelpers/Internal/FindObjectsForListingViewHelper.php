<?php

namespace Sandstorm\CrudForms\ViewHelpers\Internal;

use Neos\FluidAdaptor\Core\ViewHelper\AbstractViewHelper;

class FindObjectsForListingViewHelper extends AbstractViewHelper
{

    /**
     * @param string $repository Name of repository to use
     */
    public function render($repository)
    {
        return $this->objectManager->get($repository)->findAll();
    }
}
