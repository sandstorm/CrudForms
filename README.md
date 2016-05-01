# Sandstorm CrudForms

Create easy CRUD forms for Domain Models.

Features:
- Support for Zurb Foundation 6
- Extensible
- Listing Views as Table
- New- and Update-Forms
- Kickstarter for creating the controller and templates automatically
- extensible for other frameworks

## Usage (Kickstart)

## Usage (Customization)

## Public API

(is guaranteed to stay stable except for major version updates).

### Public Controller API

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
    
    // here, you can remove certain lines and manually implement these actions.
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

### Public Template API




## Internal API

## License & Copyright

MIT-Licensed, (c) Sandstorm Media GmbH 2016
