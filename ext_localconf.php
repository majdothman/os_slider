<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43(
    'os_slider',
    'Classes/Controller/SliderController.php',
    '_pi1',
    'CType',
    0
);

$overrideSetup = 'plugin.tx_osslider_pi1.userFunc = ' . \OTHMAN\OsSlider\Controller\SliderController::class . '->main';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript('os_slider', 'setup', $overrideSetup);
