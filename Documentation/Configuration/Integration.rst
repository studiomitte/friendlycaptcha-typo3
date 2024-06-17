..  include:: /Includes.rst.txt
..  index:: Configuration
..  _configuration-general:

===========
Integration
===========

The integration is configured in the *Sites* module.

Switch to the module *Site Management*/*Sites* and select the site which you want to configure.

A new tab **Friendly Captcha** is available which includes all configuration options.


..  figure:: /Images/configuration_site.png
    :class: with-shadow
    :alt: Integration in the Site module
    :width: 500px

    Integration in the Site module

..  note::
    After finishing the configuration, you are ready to use Friendly Captcha on your site.

    This is described in the :ref:`using` section!


Working with automated tests
============================
If you are using automated tests you might want to skip the captcha.
This can be achieved by setting the folloowing ENV variable `FRIENDLYCAPTCHA_SKIP_HEADER_VALIDATION` to a string with minimum length of 30.

Now provide the same string with with the request header `X-FriendlyCaptcha-Skip-Validation`.
