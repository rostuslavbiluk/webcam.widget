<?php

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\IO\File;

defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();
define('INSTALL_MODULE_ID', 'nm.webcam.widget');
Loc::loadMessages(__FILE__);

/**
 * Class nm_webcam_widget
 */
class nm_webcam_widget extends CModule
{
    /** @var string */
    public $MODULE_ID;

    /** @var string */
    public $MODULE_VERSION;

    /** @var string */
    public $MODULE_VERSION_DATE;

    /** @var string */
    public $MODULE_NAME;

    /** @var string */
    public $MODULE_DESCRIPTION;

    /** @var string */
    public $MODULE_GROUP_RIGHTS;

    /** @var string */
    public $PARTNER_NAME;

    /** @var string */
    public $PARTNER_URI;

    /** @var string */
    protected $vendorName = 'vendor';

    public function __construct()
    {
        $moduleVersion = [];
        include __DIR__ . '/version.php';
        $this->MODULE_ID = INSTALL_MODULE_ID;
        $this->MODULE_VERSION = $moduleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $moduleVersion['VERSION_DATE'];
        $this->MODULE_NAME = Loc::getMessage('NM_WEBCAM_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('NM_WEBCAM_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = '';
        $this->PARTNER_URI = '';
    }

    public function DoInstall()
    {
        $this->InstallFiles();
        ModuleManager::registerModule($this->MODULE_ID);
    }

    public function DoUninstall()
    {
        $this->UnInstallFiles();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function InstallFiles()
    {
        $path = $this->getPath() . '/install/components';
        if (Directory::isDirectoryExists($path)) {
            CopyDirFiles(
                $path,
                $this->getPathComponents(),
                true,
                true
            );
        }
        $path = $this->getPath() . '/install/admin';
        if (Directory::isDirectoryExists($path)) {
            CopyDirFiles(
                $path,
                Application::getDocumentRoot() . '/bitrix/admin',
                true,
                true
            );
        }
        return true;
    }

    public function UnInstallFiles()
    {
        $components = [];
        $files = [];
        $pathInstallComponents = $this->getPath() . '/install/components/' . $this->vendorName;
        $pathComponents = $this->getPathComponents();
        $documentRoot = Application::getDocumentRoot();
        $directory = new Directory($pathInstallComponents);
        foreach ($directory->getChildren() as $child) {
            if ($child->isDirectory()) {
                $components[] = $child->getName();
            }
        }
        if (!empty($components)) {
            foreach ($components as $component) {
                $pathComponent = $pathComponents .
                    DIRECTORY_SEPARATOR .
                    $this->vendorName .
                    DIRECTORY_SEPARATOR .
                    $component;
                if (Directory::isDirectoryExists($pathComponent)) {
                    Directory::deleteDirectory($pathComponent);
                }
            }
        }
        $pathInstallFiles = $this->getPath() . '/install/admin/';
        $directory = new Directory($pathInstallFiles);
        foreach ($directory->getChildren() as $child) {
            if ($child->isFile()) {
                $files[] = $child->getName();
            }
        }
        if (!empty($files)) {
            foreach ($files as $file) {
                $pathFile = $documentRoot . '/bitrix/admin/' . $file;
                if (File::isFileExists($pathFile)) {
                    File::deleteFile($pathFile);
                }
            }
        }
        return true;
    }

    /**
     * @param bool $documentRoot
     *
     * @return mixed|string
     */
    protected function GetPath($documentRoot = false)
    {
        if ($documentRoot) {
            return str_ireplace(
                Application::getDocumentRoot(),
                '',
                str_replace(DIRECTORY_SEPARATOR, '/', dirname(__DIR__))
            );
        }
        return dirname(__DIR__);
    }

    /**
     * @return string
     */
    protected function getPathComponents()
    {
        $documentRoot = Application::getDocumentRoot();
        $pathToCopy = 'local';
        if (!Directory::isDirectoryExists($documentRoot . '/local/components')) {
            $pathToCopy = 'bitrix';
        }
        return $documentRoot . DIRECTORY_SEPARATOR . $pathToCopy . '/components';
    }
}
