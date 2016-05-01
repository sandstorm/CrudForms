<?php

namespace Sandstorm\CrudForms\ViewHelpers\Internal;

use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;

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
