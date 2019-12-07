<?php

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc,
    Bitrix\Main\Config\Option,
    Bitrix\Main\Loader;
use CJSCore;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
define('INSTALL_MODULE_ID', 'nm.webcam.widget');

class WebcamWidgetComponent extends CBitrixComponent
{
    /**
     * @inheritDoc
     */
    public function onPrepareComponentParams($params)
    {
        if (empty($params['WEBCAM_POSTER_URL'])) {
            $sModulePath = str_ireplace(Application::getDocumentRoot(),'', __DIR__);
            $params['WEBCAM_POSTER_URL'] = $sModulePath . '/img/webcam_poster.jpg';
        }
        return parent::onPrepareComponentParams($params);
    }

    /**
     * @inheritDoc
     */
    public function executeComponent()
    {
        if (!$this->init()) {
            $this->showError();
            return false;
        }
        CJSCore::Init(['nm.webcam.widget']);
        $this->includeComponentTemplate();
        return $this->arResult;
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        global $APPLICATION;
        if (!Loader::includeModule(INSTALL_MODULE_ID)) {
            $APPLICATION->ThrowException(Loc::getMessage("NM_WEBCAM_MODULE_NOT_INSTALL"));
            return false;
        }
        foreach (['VIDEO_HEIGHT', 'VIDEO_WIDTH', 'WEBCAM_URL', 'UNIQUE_CODE'] as $code) {
            if (empty($this->arParams[$code])) {
                $APPLICATION->ThrowException(Loc::getMessage('NM_WEBCAM_PARAMS_' . $code . '_EMPTY'));
                return false;
            }
        }
        $isActiveModule = (string)Option::get(INSTALL_MODULE_ID, 'activeModule', 'Y');
        $this->arResult['moduleIsActive'] = false;
        if ($isActiveModule === 'Y') {
            $this->arResult['moduleIsActive'] = true;
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function showError()
    {
        global $APPLICATION;
        $e = $APPLICATION->getException();
        if ($e) {
            ShowError($e->GetString());
        }
    }
}