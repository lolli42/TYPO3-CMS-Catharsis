<?php
namespace TYPO3\CMS\Core\Package;

/*                                                                        *
 * This script belongs to the TYPO3 Flow framework.                       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * Interface for a Flow Package class
 *
 * @api
 */
interface PackageInterface extends \TYPO3\Flow\Package\PackageInterface {

	/**
	 * @return array
	 */
	public function getPackageReplacementKeys();

	/**
	 * @return array
	 */
	public function getClassFilesFromAutoloadRegistry();

}
