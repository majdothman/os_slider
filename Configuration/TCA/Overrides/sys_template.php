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

        // Include bootstrap
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
            $extKey,
            'Configuration/TypoScript/Bootstrap',
            'Othman Slider include Bootstrap 4 (optional)'
        );
    },
    'os_slider'
);
