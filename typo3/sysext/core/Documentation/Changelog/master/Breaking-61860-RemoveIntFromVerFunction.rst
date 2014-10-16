===========================================================
Breaking: #61860 - deprecated function int_from_ver removed
===========================================================

Description
===========

Function int_from_ver() from \TYPO3\CMS\Core\Utility\GeneralUtility is removed.


Impact
======

Extensions that still use the function int_from_ver() won't work.


Affected installations
======================

A TYPO3 instance is affected if a 3rd party extension uses the removed function.


Migration
=========

Replace the usage of the removed function with \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger()