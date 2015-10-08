<?php
namespace TYPO3\CMS\Backend\Form\Utility;

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

use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Lang\LanguageService;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;

/**
 * This is a static, internal and intermediate helper class for various
 * FormEngine related tasks.
 *
 * This class was introduced to help disentangling FormEngine and
 * its sub classes. It MUST NOT be used in other extensions and will
 * change or vanish without further notice.
 *
 * @internal
 * @todo: These helpers are target to be dropped if further FormEngine refactoring is done
 */
class FormEngineUtility {

	/**
	 * Whitelist that allows TCA field configuration to be overridden by TSconfig
	 *
	 * @see overrideFieldConf()
	 * @var array
	 */
	static protected $allowOverrideMatrix = array(
		'input' => array('size', 'max', 'readOnly'),
		'text' => array('cols', 'rows', 'wrap', 'readOnly'),
		'check' => array('cols', 'showIfRTE', 'readOnly'),
		'select' => array('size', 'autoSizeMax', 'maxitems', 'minitems', 'readOnly', 'treeConfig'),
		'group' => array('size', 'autoSizeMax', 'max_size', 'show_thumbs', 'maxitems', 'minitems', 'disable_controls', 'readOnly'),
		'inline' => array('appearance', 'behaviour', 'foreign_label', 'foreign_selector', 'foreign_unique', 'maxitems', 'minitems', 'size', 'autoSizeMax', 'symmetric_label', 'readOnly'),
	);

	/**
	 * Overrides the TCA field configuration by TSconfig settings.
	 *
	 * Example TSconfig: TCEform.<table>.<field>.config.appearance.useSortable = 1
	 * This overrides the setting in $GLOBALS['TCA'][<table>]['columns'][<field>]['config']['appearance']['useSortable'].
	 *
	 * @param array $fieldConfig $GLOBALS['TCA'] field configuration
	 * @param array $TSconfig TSconfig
	 * @return array Changed TCA field configuration
	 * @internal
	 */
	static public function overrideFieldConf($fieldConfig, $TSconfig) {
		if (is_array($TSconfig)) {
			$TSconfig = GeneralUtility::removeDotsFromTS($TSconfig);
			$type = $fieldConfig['type'];
			if (is_array($TSconfig['config']) && is_array(static::$allowOverrideMatrix[$type])) {
				// Check if the keys in TSconfig['config'] are allowed to override TCA field config:
				foreach ($TSconfig['config'] as $key => $_) {
					if (!in_array($key, static::$allowOverrideMatrix[$type], TRUE)) {
						unset($TSconfig['config'][$key]);
					}
				}
				// Override $GLOBALS['TCA'] field config by remaining TSconfig['config']:
				if (!empty($TSconfig['config'])) {
					ArrayUtility::mergeRecursiveWithOverrule($fieldConfig, $TSconfig['config']);
				}
			}
		}
		return $fieldConfig;
	}

	/**
	 * Returns TSconfig for given table and row
	 *
	 * @param string $table The table name
	 * @param array $row The table row - Must at least contain the "uid" value, even if "NEW..." string.
	 *                   The "pid" field is important as well, negative values will be interpreted as pointing to a record from the same table.
	 * @param string $field Optionally specify the field name as well. In that case the TSconfig for this field is returned.
	 * @return mixed The TSconfig values - probably in an array
	 * @internal
	 */
	static public function getTSconfigForTableRow($table, $row, $field = '') {
		static $cache;
		if (is_null($cache)) {
			$cache = array();
		}
		$cacheIdentifier = $table . ':' . $row['uid'];
		if (!isset($cache[$cacheIdentifier])) {
			$cache[$cacheIdentifier] = BackendUtility::getTCEFORM_TSconfig($table, $row);
		}
		if ($field) {
			return $cache[$cacheIdentifier][$field];
		}
		return $cache[$cacheIdentifier];
	}

	/**
	 * Renders the $icon, supports a filename for skinImg or sprite-icon-name
	 *
	 * @param string $icon The icon passed, could be a file-reference or a sprite Icon name
	 * @param string $alt Alt attribute of the icon returned
	 * @param string $title Title attribute of the icon return
	 * @return string A tag representing to show the asked icon
	 * @internal
	 */
	static public function getIconHtml($icon, $alt = '', $title = '') {
		$icon = (string)$icon;
		$iconFile = '';
		$iconInfo = FALSE;

		if (StringUtility::beginsWith($icon, 'EXT:')) {
			$absoluteFilePath = GeneralUtility::getFileAbsFileName($icon);
			if (!empty($absoluteFilePath)) {
				$iconFile = '../' . PathUtility::stripPathSitePrefix($absoluteFilePath);
				$iconInfo = (StringUtility::endsWith($absoluteFilePath, '.svg'))
					? TRUE
					: getimagesize($absoluteFilePath);
			}
		} elseif (StringUtility::beginsWith($icon, '../')) {
			// @TODO: this is special modList, files from folders and selicon
			$iconFile = GeneralUtility::resolveBackPath($icon);
			if (is_file(PATH_site . GeneralUtility::resolveBackPath(substr($icon, 3)))) {
				$iconInfo = (StringUtility::endsWith($icon, '.svg'))
					? TRUE
					: getimagesize((PATH_site . GeneralUtility::resolveBackPath(substr($icon, 3))));
			}
		}

		if ($iconInfo !== FALSE && is_file(GeneralUtility::resolveBackPath(PATH_typo3 . $iconFile))) {
			return '<img'
				. ' src="' . htmlspecialchars($iconFile) . '"'
				. ' alt="' . htmlspecialchars($alt) . '" '
				. ($title ? 'title="' . htmlspecialchars($title) . '"' : '')
			. ' />';
		}

		$iconFactory = GeneralUtility::makeInstance(IconFactory::class);
		return '<span alt="' . htmlspecialchars($alt). '" title="' . htmlspecialchars($title) . '">'
			. $iconFactory->getIcon($icon, Icon::SIZE_SMALL)->render()
			. '</span>';
	}

	/**
	 * Determine the configuration and the type of a record selector.
	 * This is a helper method for inline / IRRE handling
	 *
	 * @param array $conf TCA configuration of the parent(!) field
	 * @param string $field Field name
	 * @return array Associative array with the keys 'PA' and 'type', both are FALSE if the selector was not valid.
	 * @internal
	 */
	static public function getInlinePossibleRecordsSelectorConfig($conf, $field = '') {
		$foreign_table = $conf['foreign_table'];
		$foreign_selector = $conf['foreign_selector'];
		$PA = FALSE;
		$type = FALSE;
		$table = FALSE;
		$selector = FALSE;
		if ($field) {
			$PA = array();
			$PA['fieldConf'] = $GLOBALS['TCA'][$foreign_table]['columns'][$field];
			if ($PA['fieldConf'] && $conf['foreign_selector_fieldTcaOverride']) {
				ArrayUtility::mergeRecursiveWithOverrule($PA['fieldConf'], $conf['foreign_selector_fieldTcaOverride']);
			}
			$PA['fieldTSConfig'] = FormEngineUtility::getTSconfigForTableRow($foreign_table, array(), $field);
			$config = $PA['fieldConf']['config'];
			// Determine type of Selector:
			$type = static::getInlinePossibleRecordsSelectorType($config);
			// Return table on this level:
			$table = $type === 'select' ? $config['foreign_table'] : $config['allowed'];
			// Return type of the selector if foreign_selector is defined and points to the same field as in $field:
			if ($foreign_selector && $foreign_selector == $field && $type) {
				$selector = $type;
			}
		}
		return array(
			'PA' => $PA,
			'type' => $type,
			'table' => $table,
			'selector' => $selector
		);
	}

	/**
	 * Determine the type of a record selector, e.g. select or group/db.
	 *
	 * @param array $config TCE configuration of the selector
	 * @return mixed The type of the selector, 'select' or 'groupdb' - FALSE not valid
	 * @internal
	 */
	static protected function getInlinePossibleRecordsSelectorType($config) {
		$type = FALSE;
		if ($config['type'] === 'select') {
			$type = 'select';
		} elseif ($config['type'] === 'group' && $config['internal_type'] === 'db') {
			$type = 'groupdb';
		}
		return $type;
	}

	/**
	 * Update expanded/collapsed states on new inline records if any.
	 *
	 * @param array $uc The uc array to be processed and saved (by reference)
	 * @param \TYPO3\CMS\Core\DataHandling\DataHandler $tce Instance of FormEngine that saved data before
	 * @return void
	 * @internal
	 */
	static public function updateInlineView(&$uc, $tce) {
		$backendUser = static::getBackendUserAuthentication();
		if (isset($uc['inlineView']) && is_array($uc['inlineView'])) {
			$inlineView = (array)unserialize($backendUser->uc['inlineView']);
			foreach ($uc['inlineView'] as $topTable => $topRecords) {
				foreach ($topRecords as $topUid => $childElements) {
					foreach ($childElements as $childTable => $childRecords) {
						$uids = array_keys($tce->substNEWwithIDs_table, $childTable);
						if (!empty($uids)) {
							$newExpandedChildren = array();
							foreach ($childRecords as $childUid => $state) {
								if ($state && in_array($childUid, $uids)) {
									$newChildUid = $tce->substNEWwithIDs[$childUid];
									$newExpandedChildren[] = $newChildUid;
								}
							}
							// Add new expanded child records to UC (if any):
							if (!empty($newExpandedChildren)) {
								$inlineViewCurrent = &$inlineView[$topTable][$topUid][$childTable];
								if (is_array($inlineViewCurrent)) {
									$inlineViewCurrent = array_unique(array_merge($inlineViewCurrent, $newExpandedChildren));
								} else {
									$inlineViewCurrent = $newExpandedChildren;
								}
							}
						}
					}
				}
			}
			$backendUser->uc['inlineView'] = serialize($inlineView);
			$backendUser->writeUC();
		}
	}

	/**
	 * Gets an array with the uids of related records out of a list of items.
	 * This list could contain more information than required. This methods just
	 * extracts the uids.
	 *
	 * @param string $itemList The list of related child records
	 * @return array An array with uids
	 * @internal
	 */
	static public function getInlineRelatedRecordsUidArray($itemList) {
		$itemArray = GeneralUtility::trimExplode(',', $itemList, TRUE);
		// Perform modification of the selected items array:
		foreach ($itemArray as &$value) {
			$parts = explode('|', $value, 2);
			$value = $parts[0];
		}
		unset($value);
		return $itemArray;
	}

	/**
	 * Compatibility layer for methods not in FormEngine scope.
	 *
	 * databaseRow was a flat array with single elements in select and group fields as comma separated list.
	 * With new data handling in FormEngine, this is now an array of element values. There are however "old"
	 * methods that still expect the flat array.
	 * This method implodes the array again to fake the old behavior of a database row before it is given
	 * to those methods.
	 *
	 * @param array $row Incoming array
	 * @return array Flat array
	 * @internal
	 */
	static public function databaseRowCompatibility(array $row) {
		$newRow = [];
		foreach ($row as $fieldName => $fieldValue) {
			if (!is_array($fieldValue)) {
				$newRow[$fieldName] = $fieldValue;
			} else {
				$newElementValue = [];
				foreach ($fieldValue as $itemNumber => $itemValue) {
					if (is_array($itemValue) && array_key_exists(1, $itemValue)) {
						$newElementValue[] = $itemValue[1];
					} else {
						$newElementValue[] = $itemValue;
					}
				}
				$newRow[$fieldName] = implode(',', $newElementValue);
			}
		}
		return $newRow;
	}

	/**
	 * @return LanguageService
	 */
	static protected function  getLanguageService() {
		return $GLOBALS['LANG'];
	}

	/**
	 * @return DatabaseConnection
	 */
	static protected function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}

	/**
	 * @return BackendUserAuthentication
	 */
	static protected function getBackendUserAuthentication() {
		return $GLOBALS['BE_USER'];
	}

}
