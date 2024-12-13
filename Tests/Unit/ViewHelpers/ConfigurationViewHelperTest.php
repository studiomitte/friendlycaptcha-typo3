<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha\Tests\Unit\ViewHelpers;

use StudioMitte\FriendlyCaptcha\Tests\RequestTrait;
use StudioMitte\FriendlyCaptcha\ViewHelpers\ConfigurationViewHelper;
use TYPO3\TestingFramework\Core\BaseTestCase;

class ConfigurationViewHelperTest extends BaseTestCase
{
    use RequestTrait;

    /**
     * @test
     */
    public function viewHelperReturnsProperConfiguration()
    {
        self::setupRequest();
        $configurationViewHelper = new ConfigurationViewHelper();

        self::assertSame([
            'siteKey' => '1234',
            'verifyUrl' => 'https://verify,https://verify2',
            'useEuPuzzleEndpoint' => false,
            'jsPath' => 'EXT:friendlycaptcha_official/Resources/Public/JavaScript/lib/sdk@0.1.8-site.compat.min.js',
            'enabled' => true,
        ], $configurationViewHelper->render());
    }
}
