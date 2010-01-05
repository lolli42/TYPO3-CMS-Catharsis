<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Xavier Perseguers <typo3@perseguers.ch>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/


require_once('BaseTestCase.php');
require_once('FakeDbConnection.php');

/**
 * Testcase for class ux_t3lib_db. Testing MS SQL database handling.
 * 
 * $Id$
 *
 * @author Xavier Perseguers <typo3@perseguers.ch>
 *
 * @package TYPO3
 * @subpackage dbal
 */
class db_mssql_testcase extends BaseTestCase {

	/**
	 * @var t3lib_db
	 */
	protected $db;

	/**
	 * @var array
	 */
	protected $dbalConfig;

	/**
	 * Prepares the environment before running a test.
	 */
	public function setUp() {
			// Backup DBAL configuration
		$this->dbalConfig = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['dbal'];
			// Backup database connection
		$this->db = $GLOBALS['TYPO3_DB'];
			// Reconfigure DBAL to use MS SQL
		require('fixtures/mssql.config.php');

		$className =  self::buildAccessibleProxy('ux_t3lib_db');
		$GLOBALS['TYPO3_DB'] = new $className;
		$parserClassName = self::buildAccessibleProxy('ux_t3lib_sqlparser');
		$GLOBALS['TYPO3_DB']->SQLparser = new $parserClassName;

			// Initialize a fake MS SQL connection
		FakeDbConnection::connect($GLOBALS['TYPO3_DB'], 'mssql');

		$this->assertTrue($GLOBALS['TYPO3_DB']->handlerInstance['_DEFAULT']->isConnected());
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	public function tearDown() {
			// Clear DBAL-generated cache files
		$GLOBALS['TYPO3_DB']->clearCachedFieldInfo();
			// Restore DBAL configuration
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['dbal'] = $this->dbalConfig;
			// Restore DB connection
		$GLOBALS['TYPO3_DB'] = $this->db;
	}

	/**
	 * Cleans a SQL query.
	 *  
	 * @param mixed $sql
	 * @return mixed (string or array)
	 */
	private function cleanSql($sql) {
		if (!is_string($sql)) {
			return $sql;
		}

		$sql = str_replace("\n", ' ', $sql);
		$sql = preg_replace('/\s+/', ' ', $sql);
		return trim($sql);
	}

	/**
	 * @test 
	 */
	public function configurationIsUsingAdodbAndDriverMssql() {
		$configuration = $GLOBALS['TYPO3_DB']->conf['handlerCfg'];
		$this->assertTrue(is_array($configuration) && count($configuration) > 0, 'No configuration found');
		$this->assertEquals('adodb', $configuration['_DEFAULT']['type']);
		$this->assertTrue($GLOBALS['TYPO3_DB']->runningADOdbDriver('mssql') !== FALSE, 'Not using mssql driver');
	}

	/** 
	 * @test
	 */
	public function tablesWithMappingAreDetected() {
		$tablesWithMapping = array_keys($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['dbal']['mapping']);

		foreach ($GLOBALS['TYPO3_DB']->cache_fieldType as $table => $fieldTypes) {
			$tableDef = $GLOBALS['TYPO3_DB']->_call('map_needMapping', $table);

			if (in_array($table, $tablesWithMapping)) {
				self::assertTrue(is_array($tableDef), 'Table ' . $table . ' was expected to need mapping');
			} else {
				self::assertFalse($tableDef, 'Table ' . $table . ' was not expected to need mapping');
			}
		}
	}

	///////////////////////////////////////
	// Tests concerning advanced operators
	///////////////////////////////////////

	/**
	 * @test
	 * @see http://bugs.typo3.org/view.php?id=13134
	 */
	public function locateStatementIsProperlyQuoted() {
		$query = $this->cleanSql($GLOBALS['TYPO3_DB']->SELECTquery(
			'*, CASE WHEN' .
				' LOCATE(' . $GLOBALS['TYPO3_DB']->fullQuoteStr('(fce)', 'tx_templavoila_tmplobj') . ', datastructure)>0 THEN 2' .
				' ELSE 1' . 
			' END AS scope',
			'tx_templavoila_tmplobj',
			'1=1'
		));
		$expected = 'SELECT *, CASE WHEN CHARINDEX(\'(fce)\', "datastructure") > 0 THEN 2 ELSE 1 END AS "scope" FROM "tx_templavoila_tmplobj" WHERE 1 = 1';
		$this->assertEquals($expected, $query);
	}

	/**
	 * @test
	 * @see http://bugs.typo3.org/view.php?id=13134
	 */
	public function locateStatementWithPositionIsProperlyQuoted() {
		$query = $this->cleanSql($GLOBALS['TYPO3_DB']->SELECTquery(
			'*, CASE WHEN' .
				' LOCATE(' . $GLOBALS['TYPO3_DB']->fullQuoteStr('(fce)', 'tx_templavoila_tmplobj') . ', datastructure, 4)>0 THEN 2' .
				' ELSE 1' . 
			' END AS scope',
			'tx_templavoila_tmplobj',
			'1=1'
		));
		$expected = 'SELECT *, CASE WHEN CHARINDEX(\'(fce)\', "datastructure", 4) > 0 THEN 2 ELSE 1 END AS "scope" FROM "tx_templavoila_tmplobj" WHERE 1 = 1';
		$this->assertEquals($expected, $query);
	}

	/**
	 * @test
	 * @see http://bugs.typo3.org/view.php?id=13134
	 */
	public function locateStatementIsProperlyRemapped() {
		$selectFields = '*, CASE WHEN' .
				' LOCATE(' . $GLOBALS['TYPO3_DB']->fullQuoteStr('(fce)', 'tx_templavoila_tmplobj') . ', datastructure, 4)>0 THEN 2' .
				' ELSE 1' . 
			' END AS scope';
		$fromTables   = 'tx_templavoila_tmplobj';
		$whereClause  = '1=1';
		$groupBy      = '';
		$orderBy      = '';

		$GLOBALS['TYPO3_DB']->_callRef('map_remapSELECTQueryParts', $selectFields, $fromTables, $whereClause, $groupBy, $orderBy);
		$query = $this->cleanSql($GLOBALS['TYPO3_DB']->SELECTquery($selectFields, $fromTables, $whereClause, $groupBy, $orderBy));

		$expected = 'SELECT *, CASE WHEN CHARINDEX(\'(fce)\', "ds", 4) > 0 THEN 2 ELSE 1 END AS "scope" FROM "tx_templavoila_tmplobj" WHERE 1 = 1';
		$this->assertEquals($expected, $query);
	}

	/**
	 * @test
	 * @see http://bugs.typo3.org/view.php?id=13134
	 */
	public function locateStatementWithExternalTableIsProperlyRemapped() {
		$selectFields = '*, CASE WHEN' .
				' LOCATE(' . $GLOBALS['TYPO3_DB']->fullQuoteStr('(fce)', 'tx_templavoila_tmplobj') . ', tx_templavoila_tmplobj.datastructure, 4)>0 THEN 2' .
				' ELSE 1' . 
			' END AS scope';
		$fromTables   = 'tx_templavoila_tmplobj';
		$whereClause  = '1=1';
		$groupBy      = '';
		$orderBy      = '';

		$GLOBALS['TYPO3_DB']->_callRef('map_remapSELECTQueryParts', $selectFields, $fromTables, $whereClause, $groupBy, $orderBy);
		$query = $this->cleanSql($GLOBALS['TYPO3_DB']->SELECTquery($selectFields, $fromTables, $whereClause, $groupBy, $orderBy));

		$expected = 'SELECT *, CASE WHEN CHARINDEX(\'(fce)\', "tx_templavoila_tmplobj"."ds", 4) > 0 THEN 2 ELSE 1 END AS "scope" FROM "tx_templavoila_tmplobj" WHERE 1 = 1';
		$this->assertEquals($expected, $query);
	}
}
?>