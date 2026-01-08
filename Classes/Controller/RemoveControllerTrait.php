<?php

namespace Sandstorm\CrudForms\Controller;

trait RemoveControllerTrait
{
    protected function initializeRemoveAction()
    {
        $this->registerObjectParameter();
    }

    public function removeAction()
    {
        $object = $this->arguments['object']->getValue();

        $repository = $this->getRepository();
        if (!is_null($repository)) {
            $repository->remove($object);
        }

        if (method_exists($this, 'afterRemoveAction')) {
            $this->afterRemoveAction($object);
        }

        $this->redirect('index');
    }
}
