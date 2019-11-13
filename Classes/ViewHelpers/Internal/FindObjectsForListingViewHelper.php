<?php

namespace Sandstorm\CrudForms\ViewHelpers\Internal;

use Neos\FluidAdaptor\Core\ViewHelper\AbstractViewHelper;
use Neos\FluidAdaptor\Core\ViewHelper\Exception;

class FindObjectsForListingViewHelper extends AbstractViewHelper
{
    /**
     * @return void
     * @throws Exception
     */
    public function initializeArguments()
    {
        $this->registerArgument('repository', 'string', 'Name of repository to use', true);
    }

    /**
     * @return string
     */
    public function render()
    {
        $repository = $this->arguments['repository'];
        if (strpos($repository, '::') === false) {
            $repositoryName = $repository;
            $methodName = 'findAll';
        } else {
            list($repositoryName, $methodName) = explode('::', $repository);
        }

        return $this->objectManager->get($repositoryName)->$methodName();
    }
}
