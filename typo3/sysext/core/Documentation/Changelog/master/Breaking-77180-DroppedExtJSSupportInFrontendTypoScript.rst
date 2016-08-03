===============================================================
Breaking: #77180 - Dropped ExtJS support in Frontend TypoScript
===============================================================

Description
===========

The following TypoScript options

::ts
	page.javascriptLibs.ExtJs
	page.javascriptLibs.ExtJs.debug
	page.inlineLanguageLabel
	page.extOnReady

have been removed.


Impact
======

Using the settings above will not include ExtJs and inline language labels anymore in the TYPO3 Frontend.


Affected Installations
======================

Any installation using the shipped ExtJS bundle in the frontend.


Migration
=========

Include ExtJS via :ts:`page.includeJS` manually if needed or migrate to another supported modern framework.