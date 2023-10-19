<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha\FieldValidator;

use In2code\Powermail\Domain\Validator\AbstractValidator;
use StudioMitte\FriendlyCaptcha\Service\Api;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Error\Error;
use TYPO3\CMS\Extbase\Error\Result;

class PowermailValidator extends AbstractValidator
{
    /**
     * @param Mail $mail
     * @return Result
     */
    public function validate($mail): Result
    {
        $result = new Result();
        if (!$this->isFormWithCaptchaField($mail) || $this->isCaptchaCheckToSkip()) {
            return $result;
        }

        $friendlyCaptchaService = GeneralUtility::makeInstance(Api::class);
        if (!$friendlyCaptchaService->verify()) {
            $result->addError(
                new Error(
                    $this->getLanguageService()->sL('LLL:EXT:friendlycaptcha_official/Resources/Private/Language/locallang.xlf:message.invalid'),
                    1689157219
                )
            );
        }
        return $result;
    }

    public function isValid(mixed $mail): void
    {
        return;
    }

    protected function isFormWithCaptchaField($mail): bool
    {
        foreach ($mail->getForm()->getPages() as $page) {
            foreach ($page->getFields() as $field) {
                if ($field->getType() === 'friendlycaptcha') {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Captcha check should be skipped on createAction if there was a confirmationAction where the captcha was
     * already checked before
     * Note: $this->flexForm is only available in powermail 3.9 or newer
     */
    protected function isCaptchaCheckToSkip(): bool
    {
        if (property_exists($this, 'flexForm')) {
            $confirmationActive = $this->flexForm['settings']['flexform']['main']['confirmation'] === '1';
            return $this->getActionName() === 'create' && $confirmationActive;
        }
        return false;
    }

    /**
     * @return string "confirmation" or "create"
     */
    protected function getActionName(): string
    {
        $pluginVariables = GeneralUtility::_GPmerged('tx_powermail_pi1');
        return $pluginVariables['action'];
    }

    private function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
