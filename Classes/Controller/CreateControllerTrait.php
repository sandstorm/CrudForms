<?php

namespace Sandstorm\CrudForms\Controller;

trait CreateControllerTrait
{
    /**
     * @return void
     */
    public function newAction()
    {
    }

    protected function initializeCreateAction()
    {
        $this->registerObjectParameter();
    }

    public function createAction()
    {
        $object = $this->arguments['object']->getValue();

        $this->persistenceManager->add($object);

        if (method_exists($this, 'afterCreateAction')) {
            $this->afterCreateAction($object);
        }

        $this->redirect('index');
    }
}
