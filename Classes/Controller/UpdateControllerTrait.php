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

        $repository = $this->getRepository();
        if (!is_null($repository)) {
            $repository->update($object);
        }

        if (method_exists($this, 'afterUpdateAction')) {
            $this->afterUpdateAction($object);
        }

        $this->redirect('index');
    }
}
