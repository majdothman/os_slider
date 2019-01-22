<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'Othman: Slider Plugin',
        'os_slider_pi1',
        'EXT:os_slider/ext_icon.gif',
    ],
    'CType',
    'os_slider'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['os_slider_pi1'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['os_slider_pi1'] = 'recursive,pages';
$GLOBALS['TCA']['tt_content']['types']['os_slider_pi1']['showitem'] = '--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,header,pi_flexform';
$GLOBALS['TCA']['tt_content']['columns']['pi_flexform']['config']['ds'][',' . 'os_slider_pi1'] = 'FILE:EXT:os_slider/Configuration/FlexForm/Slider.xml';
$GLOBALS['TCA']['tt_content']['columns']['pi_flexform']['config']['ds_pointerField'] = 'list_type,CType';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'os_slider_pi1',
    'FILE:EXT:os_slider/Configuration/FlexForm/Slider.xml',
    'os_slider_pi1'
);
