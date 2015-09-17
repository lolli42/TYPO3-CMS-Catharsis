<?php
namespace TYPO3\CMS\Backend\Tests\Unit\Form\FormDataProvider;

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

use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseRowDefaultValues;

/**
 * Test case
 */
class DatabaseRowDefaultValuesTest extends UnitTestCase {

	/**
	 * @var DatabaseRowDefaultValues
	 */
	protected $subject;

	public function setUp() {
		$this->subject = new DatabaseRowDefaultValues();
	}

	/**
	 * @test
	 */
	public function addDataKeepsExistingValue() {
		$input = [
			'databaseRow' => [
				'aDefinedField' => 'aValue',
			],
			'vanillaTableTca' => [
				'columns' => [
					'aDefinedField' => [],
				],
			],
		];
		$expected = $input;
		$this->assertSame($expected, $this->subject->addData($input));
	}

	/**
	 * @test
	 */
	public function addDataKeepsExistingNullValueWithEvalNull() {
		$input = [
			'databaseRow' => [
				'aField' => NULL,
			],
			'vanillaTableTca' => [
				'columns' => [
					'aField' => [
						'config' => [
							'eval' => 'null',
						],
					],
				],
			],
		];
		$expected = $input;
		$this->assertSame($expected, $this->subject->addData($input));
	}

	/**
	 * @test
	 */
	public function addDataSetsNullValueWithDefaultNullForNewRecord() {
		$input = [
			'databaseRow' => [],
			'vanillaTableTca' => [
				'columns' => [
					'aField' => [
						'config' => [
							'eval' => 'null',
							'default' => NULL,
						],
					],
				],
			],
		];
		$expected = $input;
		$expected['databaseRow']['aField'] = NULL;
		$this->assertSame($expected, $this->subject->addData($input));
	}

	/**
	 * @test
	 */
	public function addDataSetsDefaultValueIfEvalNullIsSet() {
		$input = [
			'databaseRow' => [],
			'vanillaTableTca' => [
				'columns' => [
					'aField' => [
						'config' => [
							'eval' => 'null',
							'default' => 'foo',
						],
					],
				],
			],
		];
		$expected = $input;
		$expected['databaseRow']['aField'] = 'foo';
		$this->assertSame($expected, $this->subject->addData($input));
	}

	/**
	 * @test
	 */
	public function addDataSetsDefaultValueIsSet() {
		$input = [
			'databaseRow' => [],
			'vanillaTableTca' => [
				'columns' => [
					'aField' => [
						'config' => [
							'default' => 'foo',
						],
					],
				],
			],
		];
		$expected = $input;
		$expected['databaseRow']['aField'] = 'foo';
		$this->assertSame($expected, $this->subject->addData($input));
	}

}
