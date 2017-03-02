<?php

namespace Sandstorm\CrudForms\Controller;

trait IndexControllerTrait
{
    public function indexAction()
    {
        $objects = $this->getRepository()
            ? $this->getRepository()->findAll() : $this->persistenceManager->createQueryForType($this->getModelType())->execute();

        $this->view->assign('objects', $objects);
    }
}
