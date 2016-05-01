<?php

namespace Sandstorm\CrudForms\Controller;


trait CrudControllerTrait
{
    use BaseControllerTrait;

    use IndexControllerTrait;
    use CreateControllerTrait;
    use UpdateControllerTrait;
    use RemoveControllerTrait;
}
