<?php

namespace StudioMitte\FriendlyCaptcha\ExpressionLanguage;

use TYPO3\CMS\Core\ExpressionLanguage\AbstractProvider;

class TypoScriptConditionProvider extends AbstractProvider
{
    public function __construct()
    {
        $this->expressionLanguageProviders = [
            TypoScriptFunctionsProvider::class,
        ];
    }
}
