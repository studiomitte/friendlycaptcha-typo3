<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha\FieldValidator;

use In2code\Powermail\Domain\Validator\AbstractValidator;
use StudioMitte\FriendlyCaptcha\Service\Api;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\ArrayUtility;
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
            $action = $this->getActionName();
            $confirmationActive = $this->flexForm['settings']['flexform']['main']['confirmation'] === '1';
            $optinActive = $this->flexForm['settings']['flexform']['main']['optin'] === '1';
            if ($action === 'create' && $confirmationActive || $action === 'checkCreate' && $confirmationActive) {
                return true;
            }

            if ($action === 'optinConfirm' && $optinActive) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string "confirmation" or "create"
     */
    protected function getActionName(): string
    {
        /** @var ServerRequest $request */
        $request = $GLOBALS['TYPO3_REQUEST'];
        $pluginVariables = $request->getQueryParams()['tx_powermail_pi1'] ?? [];

        $requestBody = $request->getParsedBody();
        $postVariables = [];
        if (is_array($requestBody) && isset($requestBody['tx_powermail_pi1'])) {
            $postVariables = $requestBody['tx_powermail_pi1'];
        }

        ArrayUtility::mergeRecursiveWithOverrule($pluginVariables, $postVariables);
        return $pluginVariables['action'];
    }
}
