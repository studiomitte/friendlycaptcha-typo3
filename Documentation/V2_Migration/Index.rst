..  include:: /Includes.rst.txt

..  _v2_migration:

============
Migration to FriendlyCaptcha V2
============

If you’re currently using an earlier version of the plugin with **Friendly Captcha V1** and want to switch to **Friendly Captcha V2**:

* Enable **V2** in yout Application in the Panel at https://friendlycaptcha.com/
* Install the newest version of the plugin (min v1.0)
* In TYPO3 backend, go to the *Site Management*/*Sites* module and switch to the **FriendlyCaptcha** tab. You need to change the URLs
**Puzzle Endpoint** - check it if you want to use the EU Endpoint
**Verify URL** - `https://global.frcapi.com/api/v2/captcha/siteverify` or `https://eu.frcapi.com/api/v2/captcha/siteverify` if you prefer to use EU endpoint
**JavaScript Path** - `EXT:friendlycaptcha_official/Resources/Public/JavaScript/lib/sdk@0.1.26-site.compat.min.js`
