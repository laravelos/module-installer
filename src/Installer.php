<?php
namespace Laravelos\ModuleInstaller;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class Installer extends LibraryInstaller
{

    protected $locations = array(
        'library' => 'libraries/{$name}/',
    );
        /**
     * Return the install path based on package type.
     *
     * @param  PackageInterface $package
     * @param  string           $frameworkType
     * @return string
     */
    public function getInstallPath(PackageInterface $package, $frameworkType = '')
    {
        $type = $package->getType();

        $prettyName = $package->getPrettyName();
        if (strpos($prettyName, '/') !== false) {
            list($vendor, $name) = explode('/', $prettyName);
        } else {
            $vendor = '';
            $name = $prettyName;
        }

        // $availableVars = $this->inflectPackageVars(compact('name', 'vendor', 'type'));

        $extra = $package->getExtra();
        if (!empty($extra['installer-name'])) {
            $moduleName = $extra['installer-name'];
        }else{
            $moduleName = ucfirst($vendor).ucfirst($name);
        }
        $moduleName = ucfirst($moduleName);
        return "Modules/".$moduleName;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'laravelos-module' === $packageType;
    }
}
