<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha\Tests\Unit\FieldValidator;

use StudioMitte\FriendlyCaptcha\FieldValidator\FormValidator;
use StudioMitte\FriendlyCaptcha\Service\Api;
use StudioMitte\FriendlyCaptcha\Tests\RequestTrait;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\BaseTestCase;

class FormValidatorTest extends BaseTestCase
{
    use RequestTrait;

    /**
     * @test
     */
    public function validateDoesNotAddErrorIfVerified(): void
    {
        self::setupRequest();

        $mockedValidator = $this->getAccessibleMock(FormValidator::class, ['addError'], [], '', false);

        $mockedApi = $this->getAccessibleMock(Api::class, ['verify'], [], '', false);
        $mockedApi->expects(self::once())->method('verify')->willReturn(true);
        GeneralUtility::addInstance(Api::class, $mockedApi);

        $mockedValidator->expects(self::never())->method('addError');
        $mockedValidator->_call('isValid', 'validSolution');
    }

    /**
     * @test
     */
    public function validateAddsErrorIfNotVerified(): void
    {
        self::setupRequest();

        $mockedValidator = $this->getAccessibleMock(FormValidator::class, ['addError', 'translateErrorMessage'], [], '', false);
        $mockedValidator->expects(self::once())->method('addError');
        $mockedValidator->expects(self::once())->method('translateErrorMessage')->willReturn('a translation');

        $mockedApi = $this->getAccessibleMock(Api::class, ['verify'], [], '', false);
        $mockedApi->expects(self::once())->method('verify')->willReturn(false);
        GeneralUtility::addInstance(Api::class, $mockedApi);

        $mockedValidator->expects(self::once())->method('addError')->with('a translation', 1689236324);
        $mockedValidator->_call('isValid', 'invalideSolution');
    }
}
