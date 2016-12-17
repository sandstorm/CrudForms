<?php

namespace Sandstorm\CrudForms\ViewHelpers;

use Neos\Flow\Annotations as Flow;

class FormDefinitionViewHelper extends AbstractDefinitionViewHelper
{

    /**
     * @param mixed $objects
     * @param string $model the model class name
     * @param object $context an arbitrary object which is available in all actions and nested functionality
     */
    public function render($object, $model, $context = null)
    {
        $fields = $this->getProperties($model, $context);

        $fields = array_filter($fields, function ($element) {
            return $element['visible'] && $element['visibleInForm'];
        });

        return [
            'object' => $object,
            'fields' => $fields,
            'context' => $context
        ];
    }
}
