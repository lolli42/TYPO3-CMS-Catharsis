<?php
namespace TYPO3\CMS\Backend\Template\Components;

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

use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\Utility\IconUtility;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Lang\LanguageService;
use TYPO3\CMS\Core\Imaging\IconFactory;

/**
 * MetaInformation
 */
class MetaInformation {

	/**
	 * The recordArray.
	 * Typically this is a page record
	 *
	 * @var array
	 */
	protected $recordArray = [];

	/**
	 * Set the RecordArray
	 *
	 * @param array $recordArray RecordArray
	 *
	 * @return void
	 */
	public function setRecordArray(array $recordArray) {
		$this->recordArray = $recordArray;
	}

	/**
	 * Generate the page path for docHeader
	 *
	 * @return string The page path
	 */
	public function getPath() {
		$pageRecord = $this->recordArray;
		// Is this a real page
		if (is_array($pageRecord) && $pageRecord['uid']) {
			$title = substr($pageRecord['_thePathFull'], 0, -1);
			// Remove current page title
			$pos = strrpos($title, $pageRecord['title']);
			if ($pos !== FALSE) {
				$title = substr($title, 0, $pos);
			}
		} else {
			$title = '';
		}
		// Setting the path of the page
		// crop the title to title limit (or 50, if not defined)
		$beUser = $this->getBackendUser();
		$cropLength = empty($beUser->uc['titleLen']) ? 50 : $beUser->uc['titleLen'];
		$croppedTitle = GeneralUtility::fixed_lgd_cs($title, - $cropLength);
		if ($croppedTitle !== $title) {
			$pagePath = '<abbr title="' . htmlspecialchars($title) . '">' . htmlspecialchars($croppedTitle) . '</abbr>';
		} else {
			$pagePath = htmlspecialchars($title);
		}
		return $pagePath;
	}

	/**
	 * Setting page icon with clickMenu + uid for docheader
	 *
	 * @return string Page info
	 */
	public function getRecordInformation() {
		$iconFactory = GeneralUtility::makeInstance(IconFactory::class);
		$moduleTemplate = GeneralUtility::makeInstance(ModuleTemplate::class);
		$pageRecord = $this->recordArray;
		// Add icon with clickMenu, etc:
		// If there IS a real page
		if (is_array($pageRecord) && $pageRecord['uid']) {
			$altText = BackendUtility::getRecordIconAltText($pageRecord, 'pages');
			$iconImg = IconUtility::getSpriteIconForRecord('pages', $pageRecord, array('title' => $altText));
			// Make Icon:
			$theIcon = $moduleTemplate->wrapClickMenuOnIcon($iconImg, 'pages', $pageRecord['uid']);
			$uid = $pageRecord['uid'];
			$title = BackendUtility::getRecordTitle('pages', $pageRecord);
		} else {
			// On root-level of page tree
			// Make Icon
			$iconImg = '<span title="' .
				htmlspecialchars($GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename']) .
				'">' .
				$iconFactory->getIcon('apps-pagetree-root', Icon::SIZE_SMALL)->render() . '</span>';
			if ($this->getBackendUser()->isAdmin()) {
				$theIcon = $moduleTemplate->wrapClickMenuOnIcon($iconImg, 'pages', 0);
			} else {
				$theIcon = $iconImg;
			}
			$uid = '0';
			$title = $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'];
		}
		// Setting icon with clickMenu + uid
		return $theIcon . '<strong>' . htmlspecialchars($title) . '&nbsp;[' . $uid . ']</strong>';
	}

	/**
	 * Get LanguageService Object
	 *
	 * @return LanguageService
	 */
	protected function getLanguageService() {
		return $GLOBALS['LANG'];
	}

	/**
	 * Get the Backend User Object
	 *
	 * @return \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
	 */
	protected function getBackendUser() {
		return $GLOBALS['BE_USER'];
	}
}