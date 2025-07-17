..  include:: /Includes.rst.txt


**JavaScript Path**.  _v2.1.0_update:


============
Migration to FriendlyCaptcha v2.1.0
============

If you’re currently using an earlier v2 version of the plugin and want to switch to **Friendly Captcha v2.1.0**:

* After install the newest version, you need to change the **JavaScript Path** in TYPO3 backend - *Site Management*/*Sites* module
Change `EXT:friendlycaptcha_official/Resources/Public/JavaScript/lib/sdk@0.1.8-site.compat.min.js` to `EXT:friendlycaptcha_official/Resources/Public/JavaScript/lib/sdk@0.1.26-site.compat.min.js`

Why to switch?
=================
Version 2.1.0 of the plugin uses the latest 0.1.26 version of the Friendly Captcha widget library, which includes improvements to accessibility.
