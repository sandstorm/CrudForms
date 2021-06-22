<?php

namespace Sandstorm\CrudForms\ViewHelpers\Internal;

use Neos\Utility\TypeHandling;
use Neos\FluidAdaptor\Core\ViewHelper\AbstractViewHelper;

class ResolvePartialNameBasedOnTypeViewHelper extends AbstractViewHelper
{

    public function render()
    {
        $value = $this->renderChildren();




        $type = str_replace('\\', '_', TypeHandling::getTypeForValue($value));
        $type = ($type === 'NULL' ? 'Null' : $type);
        return $type;
    }
}
