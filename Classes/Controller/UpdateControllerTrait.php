<?php

namespace Sandstorm\CrudForms\Controller;

trait UpdateControllerTrait
{
    protected function initializeEditAction()
    {
        $this->registerObjectParameter();
    }

    public function editAction()
    {
        $this->view->assign('object', $this->arguments['object']->getValue());
    }

    protected function initializeUpdateAction()
    {
        $this->registerObjectParameter();
    }

    public function updateAction()
    {
        $object = $this->arguments['object']->getValue();
        $this->persistenceManager->update($object);

        if (method_exists($this, 'afterUpdateAction')) {
            $this->afterUpdateAction($object);
        }

        $this->redirect('index');
    }
}
