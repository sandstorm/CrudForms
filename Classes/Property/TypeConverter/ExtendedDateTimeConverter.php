<?php
namespace Sandstorm\CrudForms\Property\TypeConverter;


use Neos\Flow\Annotations as Flow;
use Neos\Error\Messages\Error;
use Neos\Flow\Property\TypeConverter\DateTimeConverter;

/**
 * @Flow\Scope("singleton")
 */
class ExtendedDateTimeConverter extends DateTimeConverter
{

    /**
     * @var integer
     */
    protected $priority = 50;

    public function convertFrom($source, $targetType, array $convertedChildProperties = array(), \Neos\Flow\Property\PropertyMappingConfigurationInterface $configuration = null)
    {
        if (isset($source['dateFormat']) && $source['dateFormat'] === 'MULTIPLE') {
            $source['dateFormat'] = 'Y-m-d';
            $result = parent::convertFrom($source, $targetType, $convertedChildProperties, $configuration);
            if ($result instanceof Error) {
                $source['dateFormat'] = 'd.m.Y';
                $result = parent::convertFrom($source, $targetType, $convertedChildProperties, $configuration);
            }

            return $result;
        }

        return parent::convertFrom($source, $targetType, $convertedChildProperties, $configuration);
    }
}
