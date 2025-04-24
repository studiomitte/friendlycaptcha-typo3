<?php

namespace StudioMitte\FriendlyCaptcha;

interface ConfigurationInterface
{
    public function isEnabled(): bool;

    public function getSiteKey(): string;

    public function getSiteSecretKey(): string;

    public function useEuPuzzleEndpoint(): bool;

    public function getVerifyUrl(): string;

    public function getFirstVerifyUrl(): string;

    public function getJsPath(): string;

    public function hasSkipDevValidation(): bool;

    public function hasSkipHeaderValidation(): bool;
}
