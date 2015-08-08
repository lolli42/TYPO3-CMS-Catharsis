====================================================================================
Feature: #68741 - Introduce new IconFactory as base to replace the icon skinning API
====================================================================================

Description
===========

The logic for working with icons, icon sizes and icon overlays is now bundled into the new ``IconFactory`` class.
The new icon factory will replace the old icon skinning API step by step.

All core icons will be registered directly in the ``IconRegistry`` class, third party extensions must use
``IconRegistry::registerIcon()`` to overwrite existing icons or add additional icons to the icon factory.

The ``IconFactory`` takes care of the correct icon and overlay size and the markup.


IconProvider
------------

The core implement three icon provider classes, which all implements the ``IconProviderInterface``.

* ``BitmapIconProvider`` for all kind of bitmap icons for gif, png and jpg files
* ``FontawesomeIconProvider`` for font icons from fontawesome.io
* ``SvgIconProvider`` for svg icons

Third party extensions can provide own icon provider classes, each class must implement the ``IconProviderInterface``.


Register an icon
----------------

.. code-block:: php

	/*
	 * Put the following code into your ext_localconf.php file of your extension.
	 *
	 * @param string $identifier the icon identifier
	 * @param string $iconProviderClassName the icon provider class name
	 * @param array $options provider specific options, please reference the icon provider class
	 */
	IconRegistry::registerIcon($identifier, $iconProviderClassName, array $options = array());


Use an icon
-----------

To use an icon, you need at least the icon identifier. The default size is small which currently means an icon with 16x16px.
The third parameter can be used to add an additional icon as overlay, which can be any registered icon.

The ``Icon`` class provides only the following constants for Icon sizes:

* ``Icon::SIZE_SMALL`` which currently means 16x16 px
* ``Icon::SIZE_DEFAULT`` which currently means 32x32 px
* ``Icon::SIZE_LARGE`` which currently means 48x48 px

All the sizes can change in future, so please make use of the constants for an unified layout.

.. code-block:: php

	$iconFactory = GeneralUtility::makeInstance(IconFactory::class);
	$iconFactory->getIcon($identifier, Icon::SIZE_SMALL, $overlay)->render();


ViewHelper
----------

The core provides a fluid ViewHelper which makes it really easy to use icons within a fluid view.

.. code-block:: html

	{namespace core = TYPO3\CMS\Core\ViewHelpers}
	<core:icon identifier="my-icon-identifier" size="small" />
	<!-- use the "default" size if none given ->
	<core:icon identifier="my-icon-identifier" />
	<core:icon identifier="my-icon-identifier" size="large" />
	<core:icon identifier="my-icon-identifier" size="small" overlay="overlay-identifier" />
	<core:icon identifier="my-icon-identifier" size="default" overlay="overlay-identifier" />
	<core:icon identifier="my-icon-identifier" size="large" overlay="overlay-identifier" />


Impact
======

No impact
