<?php

namespace Sandstorm\CrudForms\ViewHelpers\Internal\Form;

use Neos\FluidAdaptor\Core\ViewHelper\Exception;
use Neos\FluidAdaptor\ViewHelpers\Form\TextfieldViewHelper;

class DateViewHelper extends TextfieldViewHelper
{

    /**
     * Initialize the arguments.
     *
     * @return void
     * @throws Exception
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
     * @return string
     * @api
     */
    public function render()
    {
        $this->tag->addAttribute('type', 'date');

        $content = parent::render();

        $content .= '<input type="hidden" name="' . $this->prefixFieldName(parent::getNameWithoutPrefix()) . '[dateFormat]" value="' . htmlspecialchars($this->arguments['format']) . '" />';

        return $content;
    }

    protected function getNameWithoutPrefix(): string
    {
        return parent::getNameWithoutPrefix() . '[date]';
    }

    /**
     * @param bool $ignoreSubmittedFormData
     * @return mixed|null
     */
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
