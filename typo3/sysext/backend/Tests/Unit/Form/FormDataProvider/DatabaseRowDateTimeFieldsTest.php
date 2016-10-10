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

use TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseRowDateTimeFields;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * Test case
 */
class DatabaseRowDateTimeFieldsTest extends UnitTestCase
{
    /**
     * @test
     */
    public function addDataSetsTimestampZeroForDefaultDateField()
    {
        $input = [
            'tableName' => 'aTable',
            'processedTca' => [
                'columns' => [
                    'aField' => [
                        'config' => [
                            'dbType' => 'date',
                        ],
                    ],
                ],
            ],
        ];
        $expected = $input;
        $expected['databaseRow']['aField'] = 0;
        $this->assertEquals($expected, (new DatabaseRowDateTimeFields())->addData($input));
    }

    /**
     * @test
     */
    public function addDataSetsTimestampZeroForDefaultDateTimeField()
    {
        $input = [
            'tableName' => 'aTable',
            'processedTca' => [
                'columns' => [
                    'aField' => [
                        'config' => [
                            'dbType' => 'datetime',
                        ],
                    ],
                ],
            ],
        ];
        $expected = $input;
        $expected['databaseRow']['aField'] = 0;
        $this->assertEquals($expected, (new DatabaseRowDateTimeFields())->addData($input));
    }

    /**
     * @test
     */
    public function addDataConvertsDateStringToTimestamp()
    {
        $oldTimezone = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $input = [
            'tableName' => 'aTable',
            'processedTca' => [
                'columns' => [
                    'aField' => [
                        'config' => [
                            'dbType' => 'date',
                        ],
                    ],
                ],
            ],
            'databaseRow' => [
                'aField' => '2015-07-27',
            ],
        ];
        $expected = $input;
        $expected['databaseRow']['aField'] = 1437955200; // 27.07.2015 0:00 UTC
        $this->assertEquals($expected, (new DatabaseRowDateTimeFields())->addData($input));
        date_default_timezone_set($oldTimezone);
    }

    /**
     * @test
     */
    public function addDataConvertsDateTimeStringToTimestamp()
    {
        $oldTimezone = date_default_timezone_get();
        date_default_timezone_set('UTC');
        $input = [
            'tableName' => 'aTable',
            'processedTca' => [
                'columns' => [
                    'aField' => [
                        'config' => [
                            'dbType' => 'datetime',
                        ],
                    ],
                ],
            ],
            'databaseRow' => [
                'aField' => '2015-07-27 15:25:32',
            ],
        ];
        $expected = $input;
        $expected['databaseRow']['aField'] = 1438010732; // 27.07.2015 15:25:32 UTC
        $this->assertEquals($expected, (new DatabaseRowDateTimeFields())->addData($input));
        date_default_timezone_set($oldTimezone);
    }
}
