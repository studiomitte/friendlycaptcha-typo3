<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha\ViewHelpers;

use StudioMitte\FriendlyCaptcha\Configuration;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class ConfigurationViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    public function render(): array
    {
        $configuration = new Configuration();
        return [
            'siteKey' => $configuration->getSiteKey(),
            'verifyUrl' => $configuration->getVerifyUrl(),
            'useEuPuzzleEndpoint' => $configuration->useEuPuzzleEndpoint(),
            'jsPath' => $configuration->getJsPath(),
            'enabled' => $configuration->isEnabled(),
        ];
    }
}
