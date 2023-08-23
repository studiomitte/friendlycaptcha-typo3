<?php

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('powermail')) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        'friendlycaptcha',
        'Configuration/TypoScript/Powermail/setup.typoscript',
        'Friendly Captcha - EXT:powermail'
    );
}
