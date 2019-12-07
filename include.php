<?php

use Bitrix\Main\Application;
use Bitrix\Main\Loader;

defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();
define('INSTALL_MODULE_ID', 'nm.webcam.widget');
$dirPath = strpos(__DIR__, "\\");
$currentDirectory = $dirPath ? str_replace('\\', '/', __DIR__) :  __DIR__;
$sModulePath = str_ireplace(Application::getDocumentRoot(),'', $currentDirectory);
Loader::registerAutoLoadClasses(INSTALL_MODULE_ID, []);
CJSCore::RegisterExt(INSTALL_MODULE_ID, [
    'js'    => $sModulePath . '/assets/js/main.js',
    'css'   => $sModulePath . '/assets/css/main.css',
    'rel'   => ['playerjs_core']
]);
CJSCore::RegisterExt('playerjs_core', [
    'js'    => $sModulePath . '/assets/js/player.js',
]);
