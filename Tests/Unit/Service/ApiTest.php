<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha\Tests\Unit\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Psr\Log\NullLogger;
use StudioMitte\FriendlyCaptcha\Service\Api;
use StudioMitte\FriendlyCaptcha\Tests\RequestTrait;
use TYPO3\CMS\Core\Http\Client\GuzzleClientFactory;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\TestingFramework\Core\BaseTestCase;

class ApiTest extends BaseTestCase
{
    use RequestTrait;

    /**
     * @test
     */
    public function verifyUrlIsCalledWithProperData(): void
    {
        self::setupRequest();
        $GLOBALS['TYPO3_REQUEST'] = $GLOBALS['TYPO3_REQUEST']
            ->withParsedBody(['frc-captcha-response' => '1234']);
        $historyContainer = [];
        $client = $this->createClientWithHistory(
            [new Response(200, [], '{"success": true}')],
            $historyContainer
        );

        if ((new Typo3Version())->getMajorVersion() >= 12) {
            $factory = new RequestFactory(new GuzzleClientFactory());
        } else {
            $factory = new RequestFactory();
        }
        $api = new Api($factory, $client, new NullLogger());
        self::assertTrue($api->verify());
    }

    /**
     * @test
     */
    public function solutionIsRetrieved(): void
    {
        self::setupRequest();
        $mockedApi = $this->getAccessibleMock(Api::class, null, [], '', false);

        self::assertSame('', $mockedApi->_call('getResponseFromRequest'));

        $GLOBALS['TYPO3_REQUEST'] = $GLOBALS['TYPO3_REQUEST']
            ->withQueryParams(['frc-captcha-response' => '12345']);
        self::assertSame('12345', $mockedApi->_call('getResponseFromRequest'));

        $GLOBALS['TYPO3_REQUEST'] = $GLOBALS['TYPO3_REQUEST']
            ->withParsedBody(['frc-captcha-response' => '1234']);
        self::assertSame('1234', $mockedApi->_call('getResponseFromRequest'));
    }

    private function createClientWithHistory(array $responses, array &$historyContainer): Client
    {
        $handlerStack = HandlerStack::create(
            new MockHandler([
                ...$responses,
            ])
        );
        $history = Middleware::history($historyContainer);
        $handlerStack->push($history);
        return new Client(['handler' => $handlerStack]);
    }
}
