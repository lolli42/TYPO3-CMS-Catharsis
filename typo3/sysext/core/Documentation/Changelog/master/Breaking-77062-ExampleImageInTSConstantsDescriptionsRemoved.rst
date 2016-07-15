=====================================================================
Breaking: #77062 - Example image in TS constants descriptions removed
=====================================================================

Description
===========

In previous TYPO3 versions it was possible to add help text and and an help image to a certain category or
configuration option in the TypoScript Constant Editor of the TYPO3 Backend. This was previously done via an
additional Constant Editor option within the ``TSConstantEditor`` object.

The functionality has been removed without substitution.

Along with that change, the following PHP methods have been removed:
- ExtendedTemplateService::ext_getTSCE_config_image()
- ConfigurationForm::ext_getTSCE_config_image()

The following public properties have been removed:
- ExtendedTemplateService::$ext_localGfxPrefix
- ExtendedTemplateService::$ext_localWebGfxPrefix

Within ``ConfigurationForm::ext_initTSstyleConfig()`` the second and third parameter have been removed.


Impact
======

Setting an option ``TSConstantEditor.basic.image = EXT:sys_note/ext_icon.png`` for a category or configuration option in TypoScript constants has no effect anymore.

Calling any of the removed methods will result in a fatal PHP error.

Using any of the removed properties will result in a PHP warning.

Calling ``ConfigurationForm::ext_initTSstyleConfig()`` with the second or third parameter will result in a PHP warning.


Affected Installations
======================

Any TYPO3 installation with extended TypoScript constant editor configuration.


Migration
=========

Remove the affected TypoScript constant editor configuration code, and any reference to the removed PHP
methods and properties.