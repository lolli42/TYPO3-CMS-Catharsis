<?php
namespace TYPO3\CMS\Filemetadata\Tests\Unit\Tca;

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

use TYPO3\CMS\Backend\Tests\Functional\Form\FormTestService;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Lang\LanguageService;

class FileMetadataVisibleFieldsTest extends \TYPO3\Components\TestingFramework\Core\FunctionalTestCase
{
    protected $coreExtensionsToLoad = ['filemetadata'];

    protected static $fileMetadataFields = [
        File::FILETYPE_UNKNOWN => [
            'sys_language_uid',
            'title',
            'description',
            'ranking',
            'keywords',
            'caption',
            'download_name',
            'visible',
            'status',
            'fe_groups',
            'creator',
            'creator_tool',
            'publisher',
            'source',
            'copyright',
            'location_country',
            'location_region',
            'location_city',
            'categories',
        ],
        File::FILETYPE_TEXT => [
            'sys_language_uid',
            'title',
            'description',
            'ranking',
            'keywords',
            'caption',
            'download_name',
            'visible',
            'status',
            'fe_groups',
            'creator',
            'creator_tool',
            'publisher',
            'source',
            'copyright',
            'language',
            'location_country',
            'location_region',
            'location_city',
            'categories',
        ],
        File::FILETYPE_IMAGE => [
            'sys_language_uid',
            'title',
            'description',
            'ranking',
            'keywords',
            'alternative',
            'caption',
            'download_name',
            'visible',
            'status',
            'fe_groups',
            'creator',
            'creator_tool',
            'publisher',
            'source',
            'copyright',
            'language',
            'location_country',
            'location_region',
            'location_city',
            'latitude',
            'longitude',
            'content_creation_date',
            'content_modification_date',
            'categories',
        ],
        File::FILETYPE_AUDIO => [
            'sys_language_uid',
            'title',
            'description',
            'ranking',
            'keywords',
            'caption',
            'download_name',
            'visible',
            'status',
            'fe_groups',
            'creator',
            'creator_tool',
            'publisher',
            'source',
            'copyright',
            'language',
            'content_creation_date',
            'content_modification_date',
            'duration',
            'categories',
        ],
        File::FILETYPE_VIDEO => [
            'sys_language_uid',
            'title',
            'description',
            'ranking',
            'keywords',
            'caption',
            'download_name',
            'visible',
            'status',
            'fe_groups',
            'creator',
            'creator_tool',
            'publisher',
            'source',
            'copyright',
            'language',
            'content_creation_date',
            'content_modification_date',
            'duration',
            'categories',
        ],
    ];

    /**
     * @test
     */
    public function fileMetadataFormContainsExpectedFields()
    {
        $this->setUpBackendUserFromFixture(1);
        $GLOBALS['LANG'] = GeneralUtility::makeInstance(LanguageService::class);
        $GLOBALS['TCA']['sys_file_metadata']['ctrl']['type'] = 'fileype';

        $formEngineTestService = GeneralUtility::makeInstance(FormTestService::class);

        foreach (static::$fileMetadataFields as $filetype => $expectedFields) {
            $formResult = $formEngineTestService->createNewRecordForm(
                'sys_file_metadata',
                ['fileype' => $filetype]
            );

            foreach ($expectedFields as $expectedField) {
                $this->assertNotFalse(
                    $formEngineTestService->formHtmlContainsField($expectedField, $formResult['html']),
                    'The field ' . $expectedField . ' is not in the form HTML for file type ' . $filetype
                );
            }
        }
    }
}
