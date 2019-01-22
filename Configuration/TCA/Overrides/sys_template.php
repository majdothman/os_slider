<?php
defined('TYPO3_MODE') || die();

/**
 * Include TypoScript
 */
call_user_func(
    function ($extKey) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
            $extKey,
            'Configuration/TypoScript',
            'Othman Slider'
        );
    },
    'os_slider'
);
