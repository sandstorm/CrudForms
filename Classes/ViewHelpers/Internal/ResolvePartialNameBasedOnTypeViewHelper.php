<?php

namespace Sandstorm\CrudForms\ViewHelpers\Internal;

use TYPO3\Flow\Utility\TypeHandling;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;

class ResolvePartialNameBasedOnTypeViewHelper extends AbstractViewHelper
{

    public function render()
    {
        $value = $this->renderChildren();
        $type = str_replace('\\', '_', TypeHandling::getTypeForValue($value));
        $type = ($type == "NULL" ? "Null" : $type);
        return $type;
    }
}
