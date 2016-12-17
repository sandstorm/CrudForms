<?php
namespace Sandstorm\CrudForms\Controller;

use Sandstorm\CrudForms\Exception\MissingModelTypeException;

trait BaseControllerTrait
{

    protected function resolveView()
    {
        $this->defaultViewObjectName = 'Sandstorm\CrudForms\View\ExtendedTemplateView';
        return parent::resolveView();
    }

    protected function registerObjectParameter()
    {
        $this->arguments->addNewArgument('object', $this->getModelType());
        $this->arguments['object']->setValidator($this->validatorResolver->getBaseValidatorConjunction($this->getModelType(), array('Default', 'Controller')));
        $this->mvcPropertyMappingConfigurationService->initializePropertyMappingConfigurationFromRequest($this->request, $this->arguments);
    }

    /**
     * The method "getModelType" must be implemented in subclasses, returning the class-name of the objects which shall be edited.
     *
     * Example:
     * ```
     * protected function getModelType()
     * {
     *   return Address::class;
     * }
     * ```
     */
    protected function getModelType()
    {
        throw new MissingModelTypeException('Method getModelType() must be implemented in class ' . get_class($this) . '.', 1452714184);
    }


    protected function initializeView(\Neos\Flow\Mvc\View\ViewInterface $view)
    {
        $view->assign('model', $this->getModelType());
    }

}
