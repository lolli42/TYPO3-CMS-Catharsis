<?php
namespace TYPO3\CMS\Backend\Form\FormDataProvider;

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

use TYPO3\CMS\Backend\Form\FormDataProviderInterface;

/**
 * Initialize processed TCA from vanilla TCA
 */
class InitializeProcessedTca implements FormDataProviderInterface {

	/**
	 * Add processed TCA as copy from vanilla TCA and sanitize some details
	 *
	 * @param array $result
	 * @return array
	 * @throws \UnexpectedValueException
	 */
	public function addData(array $result) {
		if (!isset($result['vanillaTableTca'])
			|| !is_array($result['vanillaTableTca'])
		) {
			throw new \UnexpectedValueException(
				'vanillaTableTca must be initialized before',
				1438505113
			);
		}

		if (!is_array($result['vanillaTableTca']['columns'])) {
			throw new \UnexpectedValueException(
				'No columns definition in TCA table ' . $result['tableName'],
				1438594406
			);
		}

		if (!isset($result['vanillaTableTca']['types'][$result['recordTypeValue']]['showitem'])) {
			throw new \UnexpectedValueException(
				'No showitem definition in TCA table ' . $result['tableName'] . ' for type ' . $result['recordTypeValue'],
				1438614542
			);
		}

		/**
		 * @todo: This does not work for "default" fields like "hidden", those don't have a type set - fix in bootstrap??
		foreach ($result['vanillaTableTca']['columns'] as $fieldName => $fieldConfig) {
			if (!isset($fieldConfig['type'])) {
				throw new \UnexpectedValueException(
					'Field ' . $fieldName . ' of TCA table ' . $result['tableName'] . ' has no type set',
					1438594044
				);
			}
		}
		 */

		$result['processedTca'] = $result['vanillaTableTca'];
		return $result;
	}

}
