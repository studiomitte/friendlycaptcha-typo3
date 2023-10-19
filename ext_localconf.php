<?php

/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'Friendlycaptcha-icon',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:friendlycaptcha_official/Resources/Public/Icons/Captcha-icon.svg']
);

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('form')) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup('
# Settings for Frontend
plugin.tx_form.settings.yamlConfigurations {
    1689150041921 = EXT:friendlycaptcha_official/Configuration/Yaml/FormSetup.yaml
}
# Settings for Backend
module.tx_form.settings.yamlConfigurations {
    1689150041921 = EXT:friendlycaptcha_official/Configuration/Yaml/FormSetup.yaml
}
');
}

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('powermail')) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup('@import "EXT:friendlycaptcha_official/Configuration/TypoScript/Powermail/setup.typoscript');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('@import "EXT:friendlycaptcha_official/Configuration/PageTsConfig/powermail.typoscript"');
}

if (!isset($GLOBALS['TYPO3_CONF_VARS']['LOG']['StudioMitte']['FriendlyCaptcha']['writerConfiguration'])) {
    $GLOBALS['TYPO3_CONF_VARS']['LOG']['StudioMitte']['FriendlyCaptcha']['writerConfiguration'] = [
        \TYPO3\CMS\Core\Log\LogLevel::WARNING => [
            \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
                'logFileInfix' => 'friendlycaptcha',
            ],
        ],
    ];
}
