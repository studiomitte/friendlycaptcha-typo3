<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Configuration
{
    public const DEFAULT_JS_PATH = 'EXT:friendlycaptcha_official/Resources/Public/JavaScript/lib/sdk@0.1.8-site.compat.min.js';

    protected string $siteKey = '';
    protected string $siteSecretKey = '';
    protected bool $useEuPuzzleEndpoint = false;
    protected string $verifyUrl = '';
    protected string $jsPath = '';
    protected bool $skipDevValidation = false;

    public function __construct(Site $site = null)
    {
        if ($site === null) {
            $site = $GLOBALS['TYPO3_REQUEST']->getAttribute('site');
        }
        if ($site === null) {
            return;
        }
        $siteConfiguration = $site->getConfiguration();
        $this->siteKey = trim($siteConfiguration['friendlycaptcha_site_key'] ?? '');
        $this->siteSecretKey = trim($siteConfiguration['friendlycaptcha_secret_key'] ?? '');
        $this->useEuPuzzleEndpoint = $siteConfiguration['friendlycaptcha_use_eu_puzzle_endpoint'] ?? false;
        $this->verifyUrl = trim($siteConfiguration['friendlycaptcha_verify_url'] ?? '');
        $this->jsPath = trim($siteConfiguration['friendlycaptcha_js_path'] ?? '');
        $this->skipDevValidation = (bool)($siteConfiguration['friendlycaptcha_skip_dev_validation'] ?? false);
    }

    public function isEnabled(): bool
    {
        return $this->siteKey !== '' && $this->siteSecretKey !== '' && $this->verifyUrl !== '' && !$this->hasSkipHeaderValidation();
    }

    public function getSiteKey(): string
    {
        return $this->siteKey;
    }

    public function getSiteSecretKey(): string
    {
        return $this->siteSecretKey;
    }

    public function useEuPuzzleEndpoint(): bool
    {
        return $this->useEuPuzzleEndpoint;
    }

    public function getVerifyUrl(): string
    {
        return $this->verifyUrl;
    }

    public function getFirstVerifyUrl(): string
    {
        $urls = GeneralUtility::trimExplode(',', $this->verifyUrl, true);
        return $urls[0] ?? '';
    }

    public function getJsPath(): string
    {
        return $this->jsPath ?: self::DEFAULT_JS_PATH;
    }

    public function hasSkipDevValidation(): bool
    {
        return Environment::getContext()->isDevelopment() && $this->skipDevValidation;
    }

    public function hasSkipHeaderValidation(): bool
    {
        /** @var ServerRequest $request */
        $request = $GLOBALS['TYPO3_REQUEST'];
        $validationName = (string)($_ENV['FRIENDLYCAPTCHA_SKIP_HEADER_VALIDATION'] ?? '');
        if (strlen($validationName) < 30) {
            return false;
        }
        return $request && $request->hasHeader('X-FriendlyCaptcha-Skip-Validation') && in_array($validationName, $request->getHeader('X-FriendlyCaptcha-Skip-Validation'), true);
    }
}
