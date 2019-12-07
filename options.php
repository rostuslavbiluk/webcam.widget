<?php
use Bitrix\Main\Loader,
    Bitrix\Main\Localization\Loc,
	Bitrix\Main\HttpApplication,
    Bitrix\Main\Config\Option;

define('INSTALL_MODULE_ID', 'nm.webcam.widget');
Loc::loadMessages($_SERVER['DOCUMENT_ROOT'] . BX_ROOT . '/modules/main/options.php');
Loc::loadMessages(__FILE__);
global $APPLICATION;
if ($APPLICATION->GetGroupRight(INSTALL_MODULE_ID) < 'S') {
    $APPLICATION->AuthForm(Loc::getMessage('ACCESS_DENIED'));
}
Loader::includeModule(INSTALL_MODULE_ID);
$currentPage = $APPLICATION->GetCurPage();
$request = HttpApplication::getInstance()->getContext()->getRequest();
$actionUrl = $currentPage . '?mid=' . htmlspecialcharsbx($request->get('mid')) . '&lang=' . $request->get('lang');
$tabs = [
    [
        'DIV'       => 'edit1',
        'TAB'       => Loc::getMessage('NM_WEBCAM'),
        'TITLE'     => Loc::getMessage('NM_WEBCAM_TITLE'),
        'OPTIONS'   => [
            [
                'activeModule',
                'Модуль находится в разработке',
                Option::get(INSTALL_MODULE_ID, 'activeModule'), [
                    'checkbox'
                ]
            ],
        ]
    ],
];
if ($request->isPost()) {
    if (check_bitrix_sessid() && $request->get('update') === 'Y') {
        foreach ($tabs as $key => $tab) {
            foreach ($tab['OPTIONS'] as $keyOption => $option) {
                if (!is_array($option) || $option['note']) {
                    continue;
                }
                $name = $option[0];
                $value = $request->getPost($name);
                $value = is_array($value) ? implode(",", $value) : $value;
                Option::set(INSTALL_MODULE_ID, $name, $value);
                $tab[$key]['OPTIONS'][$keyOption][2] = $value;
            }
        }
    }
}
$tabControl = new CAdminTabControl('tabControl', $tabs);
$tabControl->Begin();
?>
<form method="post" action="<?=$actionUrl?>" name="<?=str_replace('.', '_', INSTALL_MODULE_ID)?>">
    <?=bitrix_sessid_post()?>
    <?php
    foreach ($tabs as $tab) {
	    if ($tab['OPTIONS']) {
		    $tabControl->BeginNextTab();
		    __AdmSettingsDrawList(INSTALL_MODULE_ID, $tab['OPTIONS']);
	    }
    }
    $tabControl->BeginNextTab();
    ?>
    <input type="submit" name="update" value="<?=Loc::getMessage('MAIN_SAVE')?>">
    <input type="reset" name="reset" value="<?=GetMessage('MAIN_RESET')?>">
</form>
<?php $tabControl->End(); ?>