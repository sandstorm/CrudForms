<?php

namespace Sandstorm\CrudForms\Command;


use Neos\Flow\Package\Package;
use Neos\Utility\Files;
use Neos\FluidAdaptor\View\StandaloneView;
use Neos\Flow\Annotations as Flow;

class CrudGeneratorService
{


    /**
     * @Flow\Inject
     * @var \Neos\Flow\Package\PackageManagerInterface
     */
    protected $packageManager;

    /**
     * @var array
     */
    protected $generatedFiles = array();


    /**
     * Generate a controller with the given name for the given package
     *
     * @param string $packageKey The package key of the controller's package
     * @param string $subpackage An optional subpackage name
     * @param string $controllerName The name of the new controller
     * @param string $modelClassName The name of the model to base the controler on
     * @param boolean $overwrite Overwrite any existing files?
     * @return array An array of generated filenames
     */
    public function generateCrudController($packageKey, $subpackage, $controllerName, $modelClassName, $overwrite = FALSE)
    {
        $controllerName = ucfirst($controllerName);
        $controllerClassName = $controllerName . 'Controller';

        $packageNamespace = str_replace('.', '\\', $packageKey);

        if (strpos($modelClassName, '\\') === FALSE) {
            $modelClassName = $packageNamespace . '\Domain\Model\\' . $modelClassName;
        }

        $shortModelClassName = substr($modelClassName, strrpos($modelClassName, '\\') + 1);

        $view = new StandaloneView();
        $view->setTemplatePathAndFilename('resource://Sandstorm.CrudForms/Private/Generator/Controller/CrudControllerTemplate.php.tmpl');
        $view->assign('packageNamespace', $packageNamespace);
        $view->assign('subpackage', $subpackage);
        $view->assign('controllerClassName', $controllerClassName);
        $view->assign('modelClassName', $modelClassName);
        $view->assign('shortModelClassName', $shortModelClassName);

        $fileContent = $view->render();

        $subpackagePath = $subpackage != '' ? $subpackage . '/' : '';
        $controllerFilename = $controllerClassName . '.php';

        $controllerPath = $this->getNamespaceBaseDirectory($packageKey) . $subpackagePath . 'Controller/';
        $targetPathAndFilename = $controllerPath . $controllerFilename;

        $this->generateFile($targetPathAndFilename, $fileContent, $overwrite);

        return $this->generatedFiles;
    }

    /**
     * Generate a controller with the given name for the given package
     *
     * @param string $packageKey The package key of the controller's package
     * @param string $subpackage An optional subpackage name
     * @param string $controllerName The name of the new controller
     * @param string $modelClassName The name of the model to base the controler on
     * @param boolean $overwrite Overwrite any existing files?
     * @return array An array of generated filenames
     */
    public function generateCrudAction($packageKey, $subpackage, $controllerName, $modelClassName, $actionName, $overwrite = FALSE)
    {
        $controllerName = ucfirst($controllerName);

        $shortModelClassName = substr($modelClassName, strrpos($modelClassName, '\\'));

        $view = new StandaloneView();
        $view->setTemplatePathAndFilename('resource://Sandstorm.CrudForms/Private/Generator/Resources/Private/Templates/' . $actionName . '.html.tmpl');
        $view->assign('subpackage', $subpackage);
        $view->assign('modelClassName', $modelClassName);
        $view->assign('shortModelClassName', $shortModelClassName);

        $fileContent = '{namespace crud=Sandstorm\CrudForms\ViewHelpers}' . chr(10) . $view->render();

        $subpackagePath = $subpackage != '' ? $subpackage . '/' : '';
        $this->generateFile('resource://' . $packageKey . '/Private/Templates/' . $subpackagePath . $controllerName . '/' . $actionName . '.html', $fileContent, $overwrite);

        return $this->generatedFiles;
    }

    /**
     * Generate a file with the given content and add it to the
     * generated files
     *
     * @param string $targetPathAndFilename
     * @param string $fileContent
     * @param boolean $force
     * @return void
     */
    protected function generateFile($targetPathAndFilename, $fileContent, $force = FALSE)
    {
        if (!is_dir(dirname($targetPathAndFilename))) {
            \Neos\Utility\Files::createDirectoryRecursively(dirname($targetPathAndFilename));
        }

        if (substr($targetPathAndFilename, 0, 11) === 'resource://') {
            list($packageKey, $resourcePath) = explode('/', substr($targetPathAndFilename, 11), 2);
            $relativeTargetPathAndFilename = $packageKey . '/Resources/' . $resourcePath;
        } elseif (strpos($targetPathAndFilename, 'Tests') !== FALSE) {
            $relativeTargetPathAndFilename = substr($targetPathAndFilename, strrpos(substr($targetPathAndFilename, 0, strpos($targetPathAndFilename, 'Tests/') - 1), '/') + 1);
        } else {
            $relativeTargetPathAndFilename = substr($targetPathAndFilename, strrpos(substr($targetPathAndFilename, 0, strpos($targetPathAndFilename, 'Classes/') - 1), '/') + 1);
        }

        if (!file_exists($targetPathAndFilename) || $force === TRUE) {
            file_put_contents($targetPathAndFilename, $fileContent);
            $this->generatedFiles[] = 'Created .../' . $relativeTargetPathAndFilename;
        } else {
            $this->generatedFiles[] = 'Omitted .../' . $relativeTargetPathAndFilename;
        }
    }

    private function getNamespaceBaseDirectory($packageKey)
    {
        $package = $this->packageManager->getPackage($packageKey);
        if ($package->getAutoloadType() === Package::AUTOLOADER_TYPE_PSR4) {
            // WORKAROUND to support PSR4 properly
            return Files::getNormalizedPath($package->getClassesPath());
        } else {
            return $package->getClassesNamespaceEntryPath();
        }

    }
}
