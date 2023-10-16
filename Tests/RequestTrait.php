<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha\Tests;

use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Http\Uri;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;

trait RequestTrait
{
    public static function setupRequest(string $siteKey = '1234', string $secretKey = 'ABCDE'): void
    {
        $siteLanguage = new SiteLanguage(123, 'en', new Uri('/'), []);
        $site = new Site('main', 123, [
            'friendlycaptcha_puzzle_url' => 'https://puzzle',
            'friendlycaptcha_secret_key' => $secretKey,
            'friendlycaptcha_site_key' => $siteKey,
            'friendlycaptcha_verify_url' => 'https://verify,https://verify2',
            'friendlycaptcha_skip_dev_validation' => false,
        ]);
        $GLOBALS['TYPO3_REQUEST'] = (new ServerRequest())
            ->withAttribute('site', $site)
            ->withAttribute('language', $siteLanguage);
    }
}
