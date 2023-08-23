<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha\Tests\Unit;

use StudioMitte\FriendlyCaptcha\Configuration;
use StudioMitte\FriendlyCaptcha\Tests\RequestTrait;
use TYPO3\TestingFramework\Core\BaseTestCase;

class ConfigurationTest extends BaseTestCase
{
    use RequestTrait;

    /**
     * @test
     */
    public function configurationIsBuiltCorrectly(): void
    {
        self::setupRequest('12345', 'ABCDEF');

        $configuration = new Configuration();
        self::assertEquals('12345', $configuration->getSiteKey());
        self::assertEquals('ABCDEF', $configuration->getSiteSecretKey());
        self::assertEquals('https://puzzle', $configuration->getPuzzleUrl());
        self::assertEquals('https://verify,https://verify2', $configuration->getVerifyUrl());
        self::assertEquals('https://verify', $configuration->getFirstVerifyUrl());
        self::assertTrue($configuration->isEnabled());
    }

    /**
     * @test
     */
    public function configurationIsNotEnabledWithMissingValue(): void
    {
        self::setupRequest('12345', '');

        $configuration = new Configuration();
        self::assertFalse($configuration->isEnabled());
    }
}
