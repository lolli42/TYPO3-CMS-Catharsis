<?php
namespace TYPO3\CMS\Core\Imaging;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The main factory class, which acts as the entrypoint for generating an Icon object which
 * is responsible for rendering an icon. Checks for the correct icon provider through the IconRegistry.
 */
class IconFactory {

	/**
	 * @var IconRegistry
	 */
	protected $iconRegistry;

	/**
	 * @param IconRegistry $iconRegistry
	 */
	public function __construct(IconRegistry $iconRegistry = NULL) {
		$this->iconRegistry = $iconRegistry ? $iconRegistry : GeneralUtility::makeInstance(IconRegistry::class);
	}

	/**
	 * @param string $identifier
	 * @param string $size
	 * @param string $overlayIdentifier
	 *
	 * @return Icon
	 */
	public function getIcon($identifier, $size = Icon::SIZE_DEFAULT, $overlayIdentifier = NULL) {
		if (!$this->iconRegistry->isRegistered($identifier)) {
			$identifier = $this->iconRegistry->getDefaultIconIdentifier();
		}

		$icon = $this->createIcon($identifier, $size, $overlayIdentifier);
		$iconConfiguration = $this->iconRegistry->getIconConfigurationByIdentifier($identifier);
		/** @var IconProviderInterface $iconProvider */
		$iconProvider = GeneralUtility::makeInstance($iconConfiguration['provider']);
		$iconProvider->prepareIconMarkup($icon, $iconConfiguration['options']);
		return $icon;
	}

	/**
	 * Creates an icon object
	 *
	 * @param string $identifier
	 * @param string $size "large" "small" or "default", see the constants of the Icon class
	 * @param string $overlayIdentifier
	 * @return Icon
	 */
	protected function createIcon($identifier, $size, $overlayIdentifier = NULL) {
		$icon = GeneralUtility::makeInstance(Icon::class);
		$icon->setIdentifier($identifier);
		$icon->setSize($size);
		if ($overlayIdentifier !== NULL) {
			$icon->setOverlayIcon($this->getIcon($overlayIdentifier, Icon::SIZE_OVERLAY));
		}
		return $icon;
	}
}
