<?php
namespace Sandstorm\CrudForms\Annotations;
/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 */
final class FormField
{

    public $label;
    public $editor;
    public $listingType;

    public $position; // position string as understood by positional array sorter

    public $visible = TRUE;
    public $visibleInOverview = TRUE;
    public $visibleInForm = TRUE;

    // only makes sense if editor == SingleSelect
    public $repository;

    // Only makes sense if editor == Radio
    public $options;

    public $readonly = FALSE;

    // generic "configuration" block to be used for specific templates
    public $configuration;
}
