<?php

namespace Sandstorm\CrudForms\ViewHelpers;

use Neos\Flow\Annotations as Flow;

class FormDefinitionViewHelper extends AbstractDefinitionViewHelper
{

    /**
     * @return void
     * @throws \Neos\FluidAdaptor\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        $this->registerArgument('object', 'object', 'object', true);
        $this->registerArgument('model', 'string', 'the model class name', true);
        $this->registerArgument('context', 'object', 'n arbitrary object which is available in all actions and nested functionality', false, null);
    }

    /**
     * @return array
     * @throws \Sandstorm\CrudForms\Exception\MissingModelTypeException
     */
    public function render()
    {
        $object = $this->arguments['object'];
        $model = $this->arguments['model'];
        $context = $this->arguments['context'];

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
