<?php
namespace Sandstorm\CrudForms\Controller;

use Neos\FluidAdaptor\View\TemplateView;
use Neos\Fusion\View\FusionView;
use Neos\Utility\ObjectAccess;
use Sandstorm\CrudForms\Exception\MissingModelTypeException;
use Sandstorm\CrudForms\View\ExtendedTemplateView;

trait BaseControllerTrait
{

    protected function resolveView()
    {
        // DEFAULT case for Flow Applications using Fluid; or for usage inside Neos plugins.
        if ($this->defaultViewObjectName === TemplateView::class) {
            $this->defaultViewObjectName = 'Sandstorm\CrudForms\View\ExtendedTemplateView';
        }

        $result = parent::resolveView();

        // USE CASE: Fusion & Flow are used (standalone) AND no Fusion path exists for the controller/action, so the Fallback
        //           is triggered.
        //
        // in case the Fusion view is used *AND* the fallback view is a normal TemplateView, we replace it
        // with the extended TemplateView as well.
        if ($result instanceof FusionView) {
            $fallbackView = ObjectAccess::getProperty($result, 'fallbackView', true);
            if ($fallbackView instanceof TemplateView) {
                ObjectAccess::setProperty($result, 'fallbackView', new ExtendedTemplateView(), true);
            }
        }

        return $result;
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
