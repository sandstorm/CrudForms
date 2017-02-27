<?php

namespace Sandstorm\CrudForms\ViewHelpers;

use Sandstorm\CrudForms\Annotations\FieldGenerator;
use Sandstorm\CrudForms\Annotations\FormField;
use Sandstorm\CrudForms\Exception\MissingModelTypeException;
use Sandstorm\CrudForms\FieldGeneratorInterface;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Reflection\ReflectionService;
use Neos\Utility\PositionalArraySorter;
use Neos\FluidAdaptor\Core\ViewHelper\AbstractViewHelper;

abstract class AbstractDefinitionViewHelper extends AbstractViewHelper
{

    /**
     * @Flow\Inject
     * @var ReflectionService
     */
    protected $reflectionService;


    /**
     * @param string $model
     * @param object $context an arbitrary object which is available in all actions and nested functionality
     * @return array
     * @throws MissingModelTypeException
     * @throws \Exception
     */
    protected function getProperties($model, $context = null)
    {
        if ($model === NULL) {
            throw new MissingModelTypeException('The "model" property has not been specified as parameter to the ViewHelper ' . get_class($this) . '.', 1452715128);
        }
        $propertyNames = $this->reflectionService->getClassPropertyNames($model);
        if ($propertyNames === NULL) {
            throw new MissingModelTypeException('No class schema could be resolved for model ' . $model . '.', 1452715183);
        }

        $fields = [];

        foreach ($propertyNames as $propertyName) {
            if ($propertyName === 'Persistence_Object_Identifier') {
                continue;
            }

            /* @var $formFieldAnnotation FormField */
            $formFieldAnnotation = $this->reflectionService->getPropertyAnnotation($model, $propertyName, FormField::class);

            $fields[$propertyName] = [];
            if ($formFieldAnnotation) {
                $fields[$propertyName] = get_object_vars($formFieldAnnotation);
            }

            $this->addDefaultsToFields($fields, $propertyName);
        }

        foreach (get_class_methods($model) as $methodName) {
            if (substr($methodName, 0, 3) === 'get') {
                $methodAnnotation = $this->reflectionService->getMethodAnnotation($model, $methodName, FormField::class);

                if ($methodAnnotation) {
                    $propertyName = lcfirst(substr($methodName, 3));
                    $fields[$propertyName] = get_object_vars($methodAnnotation);
                    $this->addDefaultsToFields($fields, $propertyName);
                }
            }
        }

        $generatorAnnotation = $this->reflectionService->getClassAnnotation($model, FieldGenerator::class);
        if ($generatorAnnotation !== NULL) {
            $generator = $this->objectManager->get($generatorAnnotation->className);
            if (!($generator instanceof FieldGeneratorInterface)) {
                throw new \Exception('TODO: generator must implement FieldGeneratorInterface, ' . get_class($generator) . ' given.');
            }
            foreach ($generator->generate($context) as $propertyName => $annotation) {
                $fields[$propertyName] = get_object_vars($annotation);
                $this->addDefaultsToFields($fields, $propertyName);
            }
        }

        return (new PositionalArraySorter($fields))->toArray();
    }

    private function addDefaultsToFields(&$fields, $propertyName)
    {
        if (!isset($fields[$propertyName]['property'])) {
            $fields[$propertyName]['property'] = $propertyName;
        }

        if (!isset($fields[$propertyName]['label'])) {
            $fields[$propertyName]['label'] = $propertyName;
        }

        if (!array_key_exists('visible', $fields[$propertyName])) {
            $fields[$propertyName]['visible'] = TRUE;
        }

        if (!array_key_exists('visibleInOverview', $fields[$propertyName])) {
            $fields[$propertyName]['visibleInOverview'] = TRUE;
        }

        if (!array_key_exists('visibleInForm', $fields[$propertyName])) {
            $fields[$propertyName]['visibleInForm'] = TRUE;
        }
    }
}
