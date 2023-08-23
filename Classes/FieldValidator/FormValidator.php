<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha\FieldValidator;

use StudioMitte\FriendlyCaptcha\Service\Api;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class FormValidator extends AbstractValidator
{
    protected function isValid($value): void
    {
        $friendlyCaptchaService = GeneralUtility::makeInstance(Api::class);
        if (!$friendlyCaptchaService->verify()) {
            $this->addError(
                $this->translateErrorMessage('message.invalid', 'friendlycaptcha_official'),
                1689236324
            );
        }
    }
}
