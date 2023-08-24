..  include:: /Includes.rst.txt
..  highlight:: php

..  _using-powermail:

=============
EXT:powermail
=============

Friendly Captcha can be used in EXT:powermail by following these steps:

Setup
-----

TypoScript and Page TsConfig need to be extended.

Add TypoScript
~~~~~~~~~~~~~~

Either import the TypoScript manually in your site package or add the following line to your TypoScript template:

..  code-block:: typoscript

    @import 'EXT:friendlycaptcha_official/Configuration/TypoScript/Powermail/setup.typoscript'

or select the TypoScript in your TypoScript record

..  figure:: /Images/integration/powermail-typoscript.png
    :class: with-shadow
    :alt: Add TypoScript
    :width: 450px

    Add TypoScript

Add Page TsConfig
~~~~~~~~~~~~~~~~~

Either import the TsConfig manually in your site package or add the following line to your TsConfig files :

..  code-block:: typoscript

    @import 'EXT:friendlycaptcha_official/Configuration/PageTsConfig/powermail.typoscript'

or select the TypoScript in your TypoScript record

..  figure:: /Images/integration/powermail-page-tsconfig.png
    :class: with-shadow
    :alt: Add Page TsConfig
    :width: 450px

    Add Page TsConfig

Usage
-----

It is now possible to select Friendly Captcha as a field type in a powermail field record

..  figure:: /Images/integration/powermail-field.png
    :class: with-shadow
    :alt: Add Friendly Captcha to your form
    :width: 450px

    Add Friendly Captcha to your form

Result
------

The result should look like this:

..  figure:: /Images/integration/powermail-result.png
    :class: with-shadow
    :alt: Result
    :width: 450px

    Result
