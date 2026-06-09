<?php

namespace StudioMitte\FriendlyCaptcha\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class TypoScriptFunctionsProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions(): array
    {
        return [
            $this->isExtensionLoadedFunction(),
        ];
    }

    private function isExtensionLoadedFunction(): ExpressionFunction
    {
        return new ExpressionFunction(
            'isFriendlyLoaded',
            static fn() => null, // Not implemented, we only use the evaluator
            static function ($arguments, $extKey) {
            return ExtensionManagementUtility::isLoaded((string )$extKey);
        });
    }
}