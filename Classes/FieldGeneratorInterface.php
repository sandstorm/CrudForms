<?php
namespace Sandstorm\CrudForms;

interface FieldGeneratorInterface
{
    /**
     * @param object $context an arbitrary object which is available in all actions and nested functionality
     * @return array<FormField> each key is a property name, each value a FormField object
     */
    public function generate($context);
}
