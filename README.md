# Sandstorm CrudForms

Create easy and extensible CRUD (Create, Read, Update, Delete) forms for Domain Models in Flow and Neos CMS. Customize them through domain model annotations.

Features:
- Listing Views as Table
- New- and Update-Forms
- Kickstarter for creating the controller and templates automatically
- Support for various templating frameworks:
  - Zurb Foundation 6
  - Neos UI backend
- Extensible through conventions and partials
- extensible for other frameworks

# Compatibility and Maintenance

This package is currently being maintained for Neos 2.3 LTS and Neos 3.x. It is stable, we use it in our projects.

| Neos / Flow Version        | Sandstorm.CrudForms Version | Maintained |
|----------------------------|-----------------------------|------------|
| Neos 3.x, Flow 4.x         | 2.x                         | Yes        |
| Neos 2.3 LTS, Flow 3.3 LTS | 1.x                         | Yes        |


# Usage (Kickstart)

You can use the `./flow crudkickstart:crudcontroller` command to create a new CRUD controller and Fluid template. You basically only need to specify the model class name which you want to list/edit.

The rendering in the overview and the forms is by default done by introspecting the model class (using reflection); and then depending on the annotated property type the corresponding editor and listing partial is triggered.

# Customization

CrudForms is meant to be very heavily customizable; that's why it provides several independent parts for you to use; and you can change and extend every part:

- Some traits to include into your controller, which implement CRUD actions

- A ViewHelper which inspects your model using reflection and generates a meta-model (so a list of all properties, with meta-information like labels)

- A set of partials which provide the default rendering for the listing, the editing forms and the individual parts of each screen. Contrary to standard Flow, the partials can be overridden just by placing a partial with he same name in your local package.

Note that you will *still* have a controller and a very bare-bones Fluid template in place; so there is a clear extension point which you can use to add custom functionality.

## Adjust individual fields

In your Model, annotate the field using the `@Crud\FormField` annotation, which supports the following options:

- `label`: property label being used in the header of the listing table and the field in the edit screen
- `position`: positioning for the listing table and form field. Most often, you will set it to a numeric sort index, although also syntax like `before otherField` is supported because internally, the PositionalArraySorter is used https://github.com/neos/flow-development-collection/blob/master/Neos.Utility.Arrays/Classes/PositionalArraySorter.php#L31
- `visible`: if FALSE, hides the field from both the listing and the forms
- `visibleInOverview`: if FALSE, hides the field from the listing.
- `visibleInForm`: if FALSE, hides the field from the create and update forms.
- `readonly`: if TRUE, only show the values, but do not make them editable.
- `editor`: configure a different editor for the forms; see below for a more detailed description.
- `listingType`:  override the type-name which is used to render this property in listings
- `options`: specify option values for e.g. radio-buttons or drop-down lists
- `repository`: specify a repository to retrieve option values from (format: full\repository\class\name[::methodName])
- `configuration`: a generic array of configuration options, available everywhere for customizations. By the base classes, the following configuration options are supported:
- `formFieldWrapperClassName`: CSS class name to be applied to the wrapping element for each form field (to have field-specific classes)
 

## hiding properties from listing and forms, sorting them, labeling them

Just use the `@CrudForms\FormField` annotation as follows:

```
@CrudForms\FormField(label="my label", visibleInOverview=false)
```

## Adjusting editors

You can use the editor property of the FormField annotation to trigger usage of a custom editor. Furthermore, place the custom editor into `Partials/CrudForms/Helpers/Editors/[EditorName].html`.

The editor has the following template variables available:

- value: the value to be edited
- object: the full object to be edited, in case you need it.
- field: the meta-model for the currently edited field - it is an array with the following properties:
  - all properties of the Crud\FormField annotation (see above)
  - property: the name of the property to be edited.
- formFieldClass: this CSS class name should be used as CSS class name for the form field itself

Example: 

```
<f:for each="{field.options}" as="option">
    <br />
        <f:form.radio property="{field.property}" value="{option.value}" />
        {option.label}
</f:for>
```

The following editors are built in, but can of course be overridden:

- DateTime
- Radio (uses "options" annotation property for its values)
- ResourceDownload
- SingleSelect (uses "options" annotation property, or alternatively queries a repository for possible values when using "repository")
- String (default)
- TextArea

## Custom listing

In the overview page, the rendering of properties values is done depending on the property type through a partial `CrudForms/Helpers/ListingType/[type].html`. The `type` is either a simple data type (as returned from the PHP function `gettype`); or a fully qualified class name with backslashes replaced by underscores.

Inside the partial, you have the `value` variable available, containing the current value to be shown.

## Virtual properties

You can add virtual properties to your model by just annotating the getter method in the model with `@Crud\FormField` annotation. Then, the respective getter and setter is called to load/store the value.

## Dynamic properties

Sometimes, you need to dynamically, based on runtime decisions, decide which fields you want to show. An example is that you have an object with an array field "extraProperties", and depending on settings, you want to store different values.

To implement this, you need to write a class which inherits from `\Sandstorm\CrudForms\FieldGeneratorInterface` and then annotate your model class with `@Crud\FieldGenerator(className="Your\Field\GeneratorClass")`.

The `FieldGeneratorInterface` needs to return an array with property paths as key, and a FormField annotation class as value. To denote nested properties, just use "." (The dot) in the property path.

Todo example
Todo context



## Add content before/after listing of objects

Simply modify your Index.html template, e.g. by wrapping the table with an <f:widget.paginate>-ViewHelper.

## Add content around the form

Simply modify your Edit.html or New.html template.

## Custom actions for each list element

Sometimes, the simple "edit" and "delete" action is not sufficient on the overview for each object; you might want to e.g. implement a "clone" button which clones the object.

This can be implemented by placing a partial inside `CrudForms/Actions/Fully_Qualified_Class_Name_With_Underscores_instead_of_Backslash.html`.

This partial has the current object available as `object`.

# API

The API is made of two parts - a "public" API, and an "internal" API:

You will use the public API only as long as you do not need to implement an additional base template for Form and Listing. In case you need to do this, you will rely on the "internal" API.

This is important for version upgrades:

- the public API is guaranteed to not contain breaking changes for minor version changes (1.X.Y)
- the internal API is guaranteed to only not contain breaking changes for patch-level version changes (1.2.X). This means it might change in minor versions. Consult the release notes for Infos on how to upgrade.

## Public Controller API

- `Sandstorm\CrudForms\Controller\CrudControllerTrait` implements Listing, Creation, Editing, Deletion of model objects.
- the method `protected function getModelType()` must be overridden in the `Controller`; it must return the class-name
  of the object this controller is responsible for.

```
use Sandstorm\CrudForms\Controller\CrudControllerTrait;
class AddressController extends ActionController
{
    use CrudControllerTrait;

    protected function getModelType()
    {
        // this method must return the class-name of the object this controller is responsible for
        return Address::class;
    }
}
```

- alternatively, if only certain actions should be auto-generated, you can replace `use CrudControllerTrait` by the traits:
    - `BaseControllerTrait` is always needed
    - `IndexControllerTrait` contains the listing of objects (`index` action)
    - `CreateControllerTrait` creates new objects (`new` and `create` actions)
    - `UpdateControllerTrait` updates objects (`edit` and `update` actions)
    - `RemoveControllerTrait` deletes objects (`remove` actions)
  

```
use Sandstorm\CrudForms\Controller\BaseControllerTrait;
use Sandstorm\CrudForms\Controller\IndexControllerTrait;
use Sandstorm\CrudForms\Controller\CreateControllerTrait;
use Sandstorm\CrudForms\Controller\UpdateControllerTrait;
use Sandstorm\CrudForms\Controller\RemoveControllerTrait;

class AddressController extends ActionController
{
    use BaseControllerTrait;
    
    // here, you can remove certain trait imports and manually implement these actions.
    use IndexControllerTrait;
    use CreateControllerTrait;
    use UpdateControllerTrait;
    use RemoveControllerTrait;

    protected function getModelType()
    {
        return Address::class;
    }
}
```

## Public Template API

The public template API contains:

- The <crud:formDefinition> and <crud:listDefinition> ViewHelpers
- The locations for the main form and edit partials
- The conventions for creating new editors
- The conventions for creating new actions
- The conventions for creating new listing object types

## Private API

If you override the main Form.html and Listing, you rely on the private API, which means you have to call the correct ViewHelpers with the correct arguments, and trigger the rendering using correctly, just as it is done in the included Listing.html and Form.html.

If you copy these templates to implement another CSS framework, please consider creating a pull request, so everybody can profit from this.


# Next steps / possible further development

- Support more frameworks
- Support for single view
- Support custom listing partials
- Out of the box relations editor

# License &amp; Copyright

MIT-Licensed, (c) Sandstorm Media GmbH 2016-2017
