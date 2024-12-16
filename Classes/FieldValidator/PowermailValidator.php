<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha\FieldValidator;

use In2code\Powermail\Domain\Validator\AbstractValidator;
use StudioMitte\FriendlyCaptcha\Service\Api;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PowermailValidator extends AbstractValidator
{
    /**
     * @param Mail $mail
     */
    public function isValid($mail): void
    {
        if (!$this->isFormWithCaptchaField($mail) || $this->isCaptchaCheckToSkip()) {
            return;
        }

        $friendlyCaptchaService = GeneralUtility::makeInstance(Api::class);
        if (!$friendlyCaptchaService->verify()) {
            $this->addError(
                $this->translateErrorMessage('message.invalid', 'friendlycaptcha_official'),
                1689157219,
            );
        }
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
            // @TODO: flexForm null in powermail v13
            $confirmationActive = $this->flexForm['settings']['flexform']['main']['confirmation'] === '1';
            $optinActive = $this->flexForm['settings']['flexform']['main']['optin'] === '1';

            return $this->getActionName() === 'create' && $confirmationActive
                || $this->getActionName() === 'optinConfirm' && $optinActive;
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
}
