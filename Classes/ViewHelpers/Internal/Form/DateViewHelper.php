<?php

namespace Sandstorm\CrudForms\ViewHelpers\Internal\Form;

use Neos\Utility\ObjectAccess;
use Neos\Utility\TypeHandling;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Fluid\ViewHelpers\Form\TextfieldViewHelper;

class DateViewHelper extends TextfieldViewHelper
{

    /**
     * Initialize the arguments.
     *
     * @return void
     * @api
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        // HINT: we use a format compatible with the input type Date
        $this->registerArgument('format', 'string', 'A Format string compatible with the DateTimeConverter.', FALSE, 'MULTIPLE');
    }

    /**
     * Renders the textfield.
     *
     * @param boolean $required If the field is required or not
     * @param string $type
     * @return string
     * @api
     */
    public function render($required = FALSE, $type = 'text')
    {

        $content = parent::render($required, 'date');

        $content .= '<input type="hidden" name="' . $this->prefixFieldName(parent::getNameWithoutPrefix()) . '[dateFormat]" value="' . htmlspecialchars($this->arguments['format']) . '" />';

        return $content;
    }


    protected function getNameWithoutPrefix()
    {
        return parent::getNameWithoutPrefix() . '[date]';
    }

    protected function getValueAttribute($ignoreSubmittedFormData = FALSE)
    {
        $value = parent::getValueAttribute($ignoreSubmittedFormData);

        if ($value === NULL) {
            return NULL;
        }

        if (is_array($value)) {
            return $value['date'];
        }

        return $value->format($this->arguments['format']);
    }
}
