<?php
namespace TYPO3\CMS\Core\Locking;

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

/**
 * Interface for locking methods
 *
 * @author Markus Klein <klein.t3@reelworx.at>
 */
interface LockingStrategyInterface {

	/**
	 * Exclusive locks can be acquired
	 */
	const LOCK_CAPABILITY_EXCLUSIVE = 1;

	/**
	 * Shared locks can be acquired
	 */
	const LOCK_CAPABILITY_SHARED = 2;

	/**
	 * Do not block when acquiring the lock
	 */
	const LOCK_CAPABILITY_NOBLOCK = 4;

	/**
	 * @return int LOCK_CAPABILITY_* elements combined with bit-wise OR
	 */
	static public function getCapabilities();

	/**
	 * @return int Returns a priority for the method. 0 to 100, 100 is highest
	 */
	static public function getPriority();

	/**
	 * @param string $subject ID to identify this lock in the system
	 */
	public function __construct($subject);

	/**
	 * Try to acquire a lock
	 *
	 * @param int $mode LOCK_CAPABILITY_EXCLUSIVE or LOCK_CAPABILITY_SHARED
	 * @return bool Returns TRUE if the lock was acquired successfully
	 * @throws \RuntimeException with code 1428700748 if the acquire would have blocked and NOBLOCK was set
	 */
	public function acquire($mode = self::LOCK_CAPABILITY_EXCLUSIVE);

	/**
	 * Release the lock
	 *
	 * @return bool Returns TRUE on success or FALSE on failure
	 */
	public function release();

	/**
	 * Get status of this lock
	 *
	 * @return bool Returns TRUE if lock is acquired by this locker, FALSE otherwise
	 */
	public function isAcquired();

}
