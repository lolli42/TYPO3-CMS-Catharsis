========================================================
Breaking: #68814 - Remove of base constant TYPO3_URL_ORG
========================================================

Description
===========

Base constant TYPO3_URL_ORG defined in SystemEnvironmentBuilder::defineBaseConstants() can be removed.
It´s for internal usage only and defined at 2 places in the core.


Impact
======

Constant TYPO3_URL_ORG no longer exists.


Migration
=========

Use TYPO3_URL_GENERAL instead.