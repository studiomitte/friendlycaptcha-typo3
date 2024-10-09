<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha\ViewHelpers;

use StudioMitte\FriendlyCaptcha\Configuration;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class ConfigurationViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $configuration = new Configuration();
        return [
            'languageIsoCode' => self::getLanguageIsoCode(),
            'siteKey' => $configuration->getSiteKey(),
            'verifyUrl' => $configuration->getVerifyUrl(),
            'puzzleUrl' => $configuration->getPuzzleUrl(),
            'jsPath' => $configuration->getJsPath(),
            'enabled' => $configuration->isEnabled(),
        ];
    }

    protected static function getLanguageIsoCode(): string
    {
        $language = $GLOBALS['TYPO3_REQUEST']->getAttribute('language');
        if (!$language) {
            return '';
        }
        if ((new Typo3Version())->getMajorVersion() >= 12) {
            return $language->getLocale()->getLanguageCode();
        }
        return $language->getTwoLetterIsoCode();
    }
}
