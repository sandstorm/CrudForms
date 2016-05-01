<?php

namespace Sandstorm\CrudForms\Controller;

trait IndexControllerTrait
{
    public function indexAction()
    {
        $this->view->assign('objects', $this->persistenceManager->createQueryForType($this->getModelType())->execute());
    }
}
