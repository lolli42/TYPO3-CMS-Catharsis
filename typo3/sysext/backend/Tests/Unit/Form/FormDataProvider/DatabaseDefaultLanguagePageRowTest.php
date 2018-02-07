<?php
declare(strict_types = 1);
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

use TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseDefaultLanguagePageRow;

/**
 * Test case
 */
class DatabaseDefaultLanguagePageRowTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var DatabaseDefaultLanguagePageRow|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    protected function setUp()
    {
        $GLOBALS['TCA']['pages']['ctrl']['transOrigPointerField'] = 'l10n_parent';
        $this->subject = $this->getMockBuilder(DatabaseDefaultLanguagePageRow::class)
            ->setMethods(['getDatabaseRow'])
            ->getMock();
    }

    /**
     * @test
     */
    public function addDataDoesNotApplyToAnyNonPagesTable()
    {
        $input = [
            'tableName' => 'tx_doandroidsdreamofelectricsheep',
            'databaseRow' => [
                'uid' => 23,
                'l10n_parent' => 13,
                'sys_language_uid' => 23
            ]
        ];
        $result = $this->subject->addData($input);

        $this->assertNull($result['defaultLanguagePageRow']);
    }

    /**
     * @test
     */
    public function addDataDoesApplyToAPagesTableButNoChangeForDefaultLanguage()
    {
        $input = [
            'tableName' => 'pages',
            'databaseRow' => [
                'uid' => 23,
                'l10n_parent' => 0,
                'sys_language_uid' => 0
            ]
        ];
        $result = $this->subject->addData($input);
        $this->assertSame($input, $result);
    }

    /**
     * @test
     */
    public function addDataDoesApplyToATranslatedPagesTable()
    {
        $input = [
            'tableName' => 'pages',
            'databaseRow' => [
                'uid' => 23,
                'pid' => 1,
                'l10n_parent' => 13,
                'sys_language_uid' => 8
            ]
        ];

        $defaultLanguagePageRow = [
            'uid' => 13,
            'pid' => 1,
            'sys_language_uid' => 0,
            'l10n_parent' => 0
        ];

        $this->subject->expects($this->once())
            ->method('getDatabaseRow')
            ->with($input['tableName'], 13)
            ->willReturn($defaultLanguagePageRow);

        $result = $this->subject->addData($input);
        $this->assertEquals($defaultLanguagePageRow, $result['defaultLanguagePageRow']);
    }
}
