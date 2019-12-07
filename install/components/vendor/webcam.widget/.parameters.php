<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) {
        die();
}
$arComponentParameters = [
    'PARAMETERS' => [
        'UNIQUE_CODE' => [
            'PARENT'    => 'BASE',
            'NAME'      => Loc::getMessage('NM_WEBCAM_PARAM_UNIQUE_CODE'),
            'TYPE'      => 'STRING',
            'DEFAULT'   => 'widget' . rand(0, 1000),
        ],
        'WEBCAM_URL' => [
            'PARENT'    => 'BASE',
            'NAME'      => Loc::getMessage('NM_WEBCAM_PARAM_URL'),
            'TYPE'      => 'STRING',
            'DEFAULT'   => '',
        ],
        'WEBCAM_POSTER_URL' => [
            'PARENT'    => 'BASE',
            'NAME'      => Loc::getMessage('NM_WEBCAM_PARAM_POSTER_URL'),
            'TYPE'      => 'STRING',
            'DEFAULT'   => '',
        ],
        'VIDEO_HEIGHT' => [
            'PARENT'    => 'BASE',
            'NAME'      => Loc::getMessage('NM_WEBCAM_PARAM_VIDEO_HEIGHT'),
            'TYPE'      => 'STRING',
            'DEFAULT'   => '3',
        ],
        'VIDEO_WIDTH' => [
            'PARENT'    => 'BASE',
            'NAME'      => Loc::getMessage('NM_WEBCAM_PARAM_VIDEO_WIDTH'),
            'TYPE'      => 'STRING',
            'DEFAULT'   => '4',
        ]
    ]
];
