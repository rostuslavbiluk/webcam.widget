<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
$arComponentDescription = [
	'NAME' => Loc::getMessage('NM_WEBCAM_COMPONENT_NAME'),
	'DESCRIPTION' => Loc::getMessage('NM_WEBCAM_COMPONENT_DESC'),
    'ICON' => '',
	'CACHE_PATH' => 'Y',
	'SORT' => 500,
	'PATH' => [
		'ID' => 'vendor',
        'NAME' => Loc::getMessage('NM_WEBCAM_PARENT_TITLE')
	],
];
