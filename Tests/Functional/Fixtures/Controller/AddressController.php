<?php
namespace Sandstorm\CrudForms\Tests\Functional\Fixtures\Controller;


use Sandstorm\CrudForms\Controller\CrudControllerTrait;
use Sandstorm\CrudForms\Tests\Functional\Fixtures\Domain\Model\Address;
use TYPO3\Flow\Mvc\Controller\ActionController;

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
