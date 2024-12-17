<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha\ViewHelpers;

use StudioMitte\FriendlyCaptcha\Configuration;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class ConfigurationViewHelper extends AbstractViewHelper
{
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
