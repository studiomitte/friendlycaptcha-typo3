<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha\Tests\Unit\ViewHelpers;

use StudioMitte\FriendlyCaptcha\Tests\RequestTrait;
use StudioMitte\FriendlyCaptcha\ViewHelpers\ConfigurationViewHelper;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContext;
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

        $renderingContext = new class () extends RenderingContext {
            public function __construct()
            {
            }
        };
        self::assertSame([
            'languageIsoCode' => 'en',
            'siteKey' => '1234',
            'verifyUrl' => 'https://verify,https://verify2',
            'puzzleUrl' => 'https://puzzle',
            'jsPath' => 'EXT:friendlycaptcha_official/Resources/Public/JavaScript/lib/widget-0.9.12.min.js',
            'enabled' => true,
        ], ConfigurationViewHelper::renderStatic([], static fn () => '', $renderingContext));
    }
}
