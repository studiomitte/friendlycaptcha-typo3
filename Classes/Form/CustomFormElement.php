<?php

declare(strict_types=1);

namespace StudioMitte\FriendlyCaptcha\Form;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator;
use TYPO3\CMS\Form\Domain\Model\FormElements\GenericFormElement;

class CustomFormElement extends GenericFormElement
{
    public function initializeFormElement()
    {
       $this->addValidator(GeneralUtility::makeInstance(NotEmptyValidator::class));
    }
}
