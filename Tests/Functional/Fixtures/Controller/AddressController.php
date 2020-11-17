<?php
namespace Sandstorm\CrudForms\Tests\Functional\Fixtures\Controller;

use Neos\Flow\Annotations as Flow;
use Sandstorm\CrudForms\Controller\CrudControllerTrait;
use Sandstorm\CrudForms\Tests\Functional\Fixtures\Domain\Model\Address;
use Neos\Flow\Mvc\Controller\ActionController;

/**
 * Functional tests for the ActionController
 */
class AddressController extends ActionController
{
    use CrudControllerTrait;

    protected function getModelType()
    {
        return Address::class;
    }
}
