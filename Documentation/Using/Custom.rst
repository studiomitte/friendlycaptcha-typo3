..  include:: /Includes.rst.txt
..  highlight:: php

..  _using-custom:

==================
Custom integration
==================

To integrate Friendly Captcha in your own extensions, 2 steps are required:

Integrate puzzle
----------------

The puzzle needs to be integrated into the form. This can be done like this in your templates

..  code-block:: html

    <html xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
          xmlns:friendlycaptcha="http://typo3.org/ns/StudioMitte/FriendlyCaptcha/ViewHelpers"
          data-namespace-typo3-fluid="true">

        <f:variable name="captchaConfiguration" value="{friendlycaptcha:configuration()}" />
        <f:if condition="{captchaConfiguration.enabled}">
            <f:then>
                <f:asset.script defer="1" async="1" identifier="friendlycaptcha" src="{captchaConfiguration.jsPath}" />
                <div class="frc-captcha" data-sitekey="{captchaConfiguration.siteKey}" data-lang="{captchaConfiguration.languageIsoCode}" data-puzzle-endpoint="{captchaConfiguration.puzzleUrl}"></div>
            </f:then>
            <f:else>
                <p>{f:translate(key:'LLL:EXT:friendlycaptcha_official/Resources/Private/Language/locallang.xlf:configuration_missing')}</p>
            </f:else>
        </f:if>

    </html>

Verify
------

The verification of the puzzle is done after the form has been submitted. Either use the validator `\StudioMitte\FriendlyCaptcha\FieldValidator\FormValidator` or use a custom implementation with a code like this

.. code-block:: php

    $friendlyCaptchaService = GeneralUtility::makeInstance(Api::class);
    // either pass the solution as 1st argument to verify() or let it be fetched from the request within the method
    if (!$friendlyCaptchaService->verify()) {
        $this->addError(
            $this->translateErrorMessage('message.invalid', 'friendlycaptcha_official'),
            1689236324
        );
    }

