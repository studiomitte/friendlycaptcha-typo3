<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha\Tests\Unit\FieldValidator;

use In2code\Powermail\Domain\Model\Field;
use In2code\Powermail\Domain\Model\Form;
use In2code\Powermail\Domain\Model\Mail;
use In2code\Powermail\Domain\Model\Page;
use StudioMitte\FriendlyCaptcha\FieldValidator\PowermailValidator;
use StudioMitte\FriendlyCaptcha\Service\Api;
use StudioMitte\FriendlyCaptcha\Tests\RequestTrait;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\BaseTestCase;

class PowermailValidatorTest extends BaseTestCase
{
    use RequestTrait;

    /**
     * @test
     */
    public function validateDoesNotAddErrorIfVerified(): void
    {
        self::setupRequest();
        $GLOBALS['TYPO3_REQUEST'] = $GLOBALS['TYPO3_REQUEST']
            ->withParsedBody(['tx_powermail_pi1' => ['action' => 'create']]);

        $mockedValidator = $this->getAccessibleMock(PowermailValidator::class, ['addError'], [], '', false);
        $mockedValidator->_set('flexForm', [
            'settings' => ['flexform' => ['main' => ['confirmation' => '0', 'optin' => '0']]],
        ]);
        $mockedMail = $this->createMailWithCaptchaField();

        $mockedApi = $this->getAccessibleMock(Api::class, ['verify'], [], '', false);
        $mockedApi->expects(self::once())->method('verify')->willReturn(true);
        GeneralUtility::addInstance(Api::class, $mockedApi);

        $mockedValidator->expects(self::never())->method('addError');
        $mockedValidator->_call('isValid', $mockedMail);
    }

    /**
     * @test
     */
    public function validateAddsErrorIfNotVerified(): void
    {
        self::setupRequest();
        $GLOBALS['TYPO3_REQUEST'] = $GLOBALS['TYPO3_REQUEST']
            ->withParsedBody(['tx_powermail_pi1' => ['action' => 'create']]);

        $mockedValidator = $this->getAccessibleMock(PowermailValidator::class, ['addError', 'translateErrorMessage'], [], '', false);
        $mockedValidator->_set('flexForm', [
            'settings' => ['flexform' => ['main' => ['confirmation' => '0', 'optin' => '0']]],
        ]);
        $mockedValidator->expects(self::once())->method('addError');
        $mockedValidator->expects(self::once())->method('translateErrorMessage')->willReturn('a translation');

        $mockedMail = $this->createMailWithCaptchaField();

        $mockedApi = $this->getAccessibleMock(Api::class, ['verify'], [], '', false);
        $mockedApi->expects(self::once())->method('verify')->willReturn(false);
        GeneralUtility::addInstance(Api::class, $mockedApi);

        $mockedValidator->expects(self::once())->method('addError')->with('a translation', 1689157219);
        $mockedValidator->_call('isValid', $mockedMail);
    }

    /**
     * @test
     */
    public function validateSkipsCheckIfNoFormWithCaptchaField(): void
    {
        self::setupRequest();
        $GLOBALS['TYPO3_REQUEST'] = $GLOBALS['TYPO3_REQUEST']
            ->withParsedBody(['tx_powermail_pi1' => ['action' => 'create']]);

        $mockedValidator = $this->getAccessibleMock(PowermailValidator::class, ['addError'], [], '', false);
        $mockedValidator->_set('flexForm', [
            'settings' => ['flexform' => ['main' => ['confirmation' => '0', 'optin' => '0']]],
        ]);
        $mockedMail = $this->createMailWithoutCaptchaField();

        $mockedApi = $this->getAccessibleMock(Api::class, ['verify'], [], '', false);
        $mockedApi->expects(self::never())->method('verify');
        GeneralUtility::addInstance(Api::class, $mockedApi);

        $mockedValidator->expects(self::never())->method('addError');
        $mockedValidator->_call('isValid', $mockedMail);
    }

    private function createMailWithCaptchaField(): Mail
    {
        $form = $this->createPartialMock(Form::class, ['getPages']);
        $page = $this->createPartialMock(Page::class, ['getFields']);

        $captchaField = $this->createPartialMock(Field::class, ['getType']);
        $captchaField->method('getType')->willReturn('friendlycaptcha');

        $fields = new ObjectStorage();
        $fields->attach($captchaField);
        $page->method('getFields')->willReturn($fields);

        $pages = new ObjectStorage();
        $pages->attach($page);
        $form->method('getPages')->willReturn($pages);

        $mail = $this->createPartialMock(Mail::class, ['getForm']);
        $mail->method('getForm')->willReturn($form);

        return $mail;
    }

    private function createMailWithoutCaptchaField(): Mail
    {
        $form = $this->createPartialMock(Form::class, ['getPages']);
        $page = $this->createPartialMock(Page::class, ['getFields']);

        $regularField = $this->createPartialMock(Field::class, ['getType']);
        $regularField->method('getType')->willReturn('text');

        $fields = new ObjectStorage();
        $fields->attach($regularField);
        $page->method('getFields')->willReturn($fields);

        $pages = new ObjectStorage();
        $pages->attach($page);
        $form->method('getPages')->willReturn($pages);

        $mail = $this->createPartialMock(Mail::class, ['getForm']);
        $mail->method('getForm')->willReturn($form);

        return $mail;
    }
}
