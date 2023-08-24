<?php

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('powermail')) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        'friendlycaptcha_official',
        'Configuration/TypoScript/Powermail',
        'Friendly Captcha - EXT:powermail'
    );
}
