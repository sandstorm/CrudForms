<?php
namespace Sandstorm\CrudForms\Command;

use Neos\Flow\Cli\CommandController;
use Neos\Flow\Annotations as Flow;

class CrudKickstartCommandController extends CommandController
{


    /**
     * @Flow\Inject
     * @var \Neos\Flow\Package\PackageManagerInterface
     */
    protected $packageManager;

    /**
     * @Flow\Inject
     * @var \Sandstorm\CrudForms\Command\CrudGeneratorService
     */
    protected $crudGeneratorService;


    /**
     * Kickstart a new CRUD Controller
     *
     * @param string $packageKey The package key of the package for the new controller with an optional subpackage, (e.g. "MyCompany.MyPackage/Admin").
     * @param string $controllerName The name for the new controller. This may also be a comma separated list of controller names.
     * @param string $modelName The model class name. Either fully-qualified or assumed to be in $packageKey.
     * @param boolean $override override generated classes?
     * @return string
     * @see typo3.kickstart:kickstart:commandcontroller
     */
    public function crudControllerCommand($packageKey, $controllerName, $modelName, $overwrite = FALSE)
    {
        $subpackageName = '';
        if (strpos($packageKey, '/') !== FALSE) {
            list($packageKey, $subpackageName) = explode('/', $packageKey, 2);
        }
        $this->validatePackageKey($packageKey);
        if (!$this->packageManager->isPackageAvailable($packageKey)) {
            $this->outputLine('Package "%s" is not available.', array($packageKey));
            exit(2);
        }
        $generatedFiles = array();
        $generatedFiles += $this->crudGeneratorService->generateCrudController($packageKey, $subpackageName, $controllerName, $modelName, $overwrite);
        $generatedFiles += $this->crudGeneratorService->generateCrudAction($packageKey, $subpackageName, $controllerName, $modelName, 'Index', $overwrite);
        $generatedFiles += $this->crudGeneratorService->generateCrudAction($packageKey, $subpackageName, $controllerName, $modelName, 'New', $overwrite);
        $generatedFiles += $this->crudGeneratorService->generateCrudAction($packageKey, $subpackageName, $controllerName, $modelName, 'Edit', $overwrite);

        $this->outputLine(implode(PHP_EOL, $generatedFiles));
    }

    /**
     * Checks the syntax of the given $packageKey and quits with an error message if it's not valid
     *
     * @param string $packageKey
     * @return void
     */
    protected function validatePackageKey($packageKey)
    {
        if (!$this->packageManager->isPackageKeyValid($packageKey)) {
            $this->outputLine('Package key "%s" is not valid. Only UpperCamelCase with alphanumeric characters in the format <VendorName>.<PackageKey>, please!', array($packageKey));
            exit(1);
        }
    }
}
