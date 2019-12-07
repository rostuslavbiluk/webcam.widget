<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);
$this->SetViewTarget('sidebar', 50);
$moduleIsActiveClass = '';
if (!$arResult['moduleIsActive']) {
    $moduleIsActiveClass = 'not-active';
} ?>
<div class="sidebar-widget sidebar-widget-webcam <?=$moduleIsActiveClass?>">
    <div class="sidebar-widget-top">
        <div class="sidebar-widget-top-title"><?=Loc::getMessage('NM_WEBCAM_NAME')?></div>
    </div>
    <div class="sidebar-widget-item">
        <div id="webcam_widget_<?=$arParams['UNIQUE_CODE']?>"></div>
    </div>
</div>
<script>
    window.addEventListener('DOMContentLoaded', function() {
        let player = new Playerjs({
            autoplay: 0,
            id: "webcam_widget_<?=$arParams['UNIQUE_CODE']?>",
            file: "<?=$arParams['WEBCAM_URL']?>",
            poster: "<?=$arParams['WEBCAM_POSTER_URL']?>"
        });
    });
</script>