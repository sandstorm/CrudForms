<?php

namespace Sandstorm\CrudForms\ViewHelpers;

use TYPO3\Flow\Annotations as Flow;

class ListDefinitionViewHelper extends AbstractDefinitionViewHelper
{

    /**
     * @param mixed $objects
     * @param string $model the model class name
     * @param object $context an arbitrary object which is available in all actions and nested functionality
     */
    public function render($objects, $model, $context = null)
    {
        $fields = $this->getProperties($model, $context);


        $fields = array_filter($fields, function ($element) {
            return $element['visible'] && $element['visibleInOverview'];
        });

        return [
            'objects' => $objects,
            'fields' => $fields,
            'context' => $context
        ];
    }
}
