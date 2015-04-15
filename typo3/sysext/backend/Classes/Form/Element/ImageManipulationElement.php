<?php
namespace TYPO3\CMS\Backend\Form\Element;

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

use TYPO3\CMS\Backend\Form\FormEngine;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Resource\Exception\FileDoesNotExistException;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Extbase\Utility\ArrayUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Generation of crop image TCEform elements
 */
class ImageManipulationElement extends AbstractFormElement {

	/**
	 * Default element configuration
	 *
	 * @var array
	 */
	protected $defaultConfig = array(
		'file_field' => 'uid_local',
		'enableZoom' => FALSE,
		'allowedExtensions' => NULL, // default: $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
		'ratios' => array(
			'1.7777777777777777' => 'LLL:EXT:lang/locallang_wizards.xlf:imwizard.ratio.16_9',
			'1.3333333333333333' => 'LLL:EXT:lang/locallang_wizards.xlf:imwizard.ratio.4_3',
			'1' => 'LLL:EXT:lang/locallang_wizards.xlf:imwizard.ratio.1_1',
			'NaN' => 'LLL:EXT:lang/locallang_wizards.xlf:imwizard.ratio.free',
		)
	);

	/**
	 * Handler for unknown types.
	 *
	 * @param string $table The table name of the record
	 * @param string $field The field name which this element is supposed to edit
	 * @param array $row The record data array where the value(s) for the field can be found
	 * @param array $additionalInformation An array with additional configuration options.
	 * @return string The HTML code for the TCEform field
	 */
	public function render($table, $field, $row, &$additionalInformation) {
		// If ratios are set do not add default options
		if (isset($additionalInformation['fieldConf']['config']['ratios'])) {
			unset($this->defaultConfig['ratios']);
		}
		$config = ArrayUtility::arrayMergeRecursiveOverrule($this->defaultConfig, $additionalInformation['fieldConf']['config']);

		// By default we allow all image extensions that can be handled by the GFX functionality
		if ($config['allowedExtensions'] === NULL) {
			$config['allowedExtensions'] = $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'];
		}

		if ($this->isGlobalReadonly() || $config['readOnly']) {
			$formEngineDummy = new FormEngine();
			$noneElement = GeneralUtility::makeInstance(NoneElement::class, $formEngineDummy);
			$elementConfiguration = array(
				'fieldConf' => array(
					'config' => $config,
				),
				'itemFormElValue' => $additionalInformation['itemFormElValue'],
			);
			return $noneElement->render('', '', '', $elementConfiguration);
		}

		$file = $this->getFile($row, $config['file_field']);
		if (!$file) {
			return '';
		}

		$content = '';
		$preview = '';
		if (GeneralUtility::inList(mb_strtolower($config['allowedExtensions']), mb_strtolower($file->getExtension()))) {

			// Get preview
			$preview = $this->getPreview($file, $additionalInformation['itemFormElValue']);

			// Check if ratio labels hold translation strings
			$languageService = $this->getLanguageService();
			foreach ((array)$config['ratios'] as $ratio => $label) {
				$config['ratios'][$ratio] = $languageService->sL($label, TRUE);
			}

			$formFieldId = str_replace('.', '', uniqid('formengine-image-manipulation-', TRUE));
			$wizardData = array(
				'file' => $file->getUid(),
				'zoom' => $config['enableZoom'] ? '1' : '0',
				'ratios' => json_encode($config['ratios']),
			);
			$wizardData['token'] = GeneralUtility::hmac(implode('|', $wizardData), 'ImageManipulationWizard');

			$buttonAttributes = array(
				'data-url' => BackendUtility::getAjaxUrl('ImageManipulationWizard::getHtmlForImageManipulationWizard', $wizardData),
				'data-severity' => 'notice',
				'data-image-name' => $file->getNameWithoutExtension(),
				'data-image-uid' => $file->getUid(),
				'data-file-field' => $config['file_field'],
				'data-field' => $formFieldId,
			);

			$button = '<button class="btn btn-default t3js-image-manipulation-trigger"';
			foreach ($buttonAttributes as $key => $value) {
				$button .= ' ' . $key . '="' . htmlspecialchars($value) . '"';
			}
			$button .= '><span class="t3-icon fa fa-crop"></span>';
			$button .= $languageService->sL('LLL:EXT:lang/locallang_wizards.xlf:imwizard.open-editor', TRUE);
			$button .= '</button>';

			$inputField = '<input type="hidden" '
				. 'id="' . $formFieldId . '" '
				. 'name="' . $additionalInformation['itemFormElName'] . '" '
				. 'value="' . htmlspecialchars($additionalInformation['itemFormElValue']) . '" />';

			$content .= $inputField . $button;

			$content .= $this->getImageManipulationInfoTable($additionalInformation['itemFormElValue']);

			/** @var $pageRenderer \TYPO3\CMS\Core\Page\PageRenderer */
			$pageRenderer = $GLOBALS['SOBE']->doc->getPageRenderer();
			$pageRenderer->loadRequireJsModule(
				'TYPO3/CMS/Backend/ImageManipulation',
				'function(ImageManipulation){ImageManipulation.initializeTrigger()}' // Initialize after load
			);
		}

		$content .= '<p class="text-muted"><em>' . $languageService->sL('LLL:EXT:lang/locallang_wizards.xlf:imwizard.supported-types-message', TRUE) . '<br />';
		$content .= mb_strtoupper(implode(', ', GeneralUtility::trimExplode(',', $config['allowedExtensions'])));
		$content .= '</em></p>';

		$item = '<div class="media">';
		$item .= $preview;
		$item .= '<div class="media-body">' . $content . '</div>';
		$item .= '</div>';

		return $item;
	}

	/**
	 * Get file object
	 *
	 * @param array $row
	 * @param string $fieldName
	 * @return NULL|\TYPO3\CMS\Core\Resource\File
	 */
	protected function getFile(array $row, $fieldName) {
		$file = NULL;
		$fileUid = !empty($row[$fieldName]) ? $row[$fieldName] : NULL;

		if (strpos($fileUid, 'sys_file_') === 0) {
			$fileUid = substr($fileUid, 9);
		}
		if (MathUtility::canBeInterpretedAsInteger($fileUid)) {
			try {
				$file = ResourceFactory::getInstance()->getFileObject($fileUid);
			} catch (FileDoesNotExistException $e) {
			}
		}
		return $file;
	}

	/**
	 * Get preview image if cropping is set
	 *
	 * @param File $file
	 * @param string $crop
	 * @return string
	 */
	public function getPreview(File $file, $crop) {
		$preview = '';
		if ($crop) {
			$imageSetup = array('width' => '150m', 'height' => '200m', 'crop' => $crop);
			$processedImage = $file->process(\TYPO3\CMS\Core\Resource\ProcessedFile::CONTEXT_IMAGECROPSCALEMASK, $imageSetup);
			// Only use a thumbnail if the processing process was successful by checking if image width is set
			if ($processedImage->getProperty('width')) {
				$imageUrl = $processedImage->getPublicUrl(TRUE);
				$preview = '<img src="' . $imageUrl . '" ' .
					'class="media-object thumbnail" ' .
					'width="' . $processedImage->getProperty('width') . '" ' .
					'height="' . $processedImage->getProperty('height') . '" >';
			}
		}
		return '<div class="media-left t3js-image-manipulation-preview' . ($preview ? '' : ' hide'). '">' . $preview . '</div>';
	}

	/**
	 * Get image manipulation info table
	 *
	 * @param string $rawImageManipulationValue
	 * @return string
	 */
	protected function getImageManipulationInfoTable($rawImageManipulationValue) {
		$content = '';
		$imageManipulation = NULL;
		$x = $y = $width = $height = 0;

		// Determine cropping values
		if ($rawImageManipulationValue) {
			$imageManipulation = json_decode($rawImageManipulationValue);
			if (is_object($imageManipulation)) {
				$x = (int)$imageManipulation->x;
				$y = (int)$imageManipulation->y;
				$width = (int)$imageManipulation->width;
				$height = (int)$imageManipulation->height;
			} else {
				$imageManipulation = NULL;
			}
		}
		$languageService = $this->getLanguageService();

		$content .= '<div class="table-fit-block table-spacer-wrap">';
		$content .= '<table class="table table-no-borders t3js-image-manipulation-info'. ($imageManipulation === NULL ? ' hide' : '') . '">';
		$content .= '<tr><td>' . $languageService->sL('LLL:EXT:lang/locallang_wizards.xlf:imwizard.crop-x', TRUE) . '</td>';
		$content .= '<td class="t3js-image-manipulation-info-crop-x">' . $x . 'px</td></tr>';
		$content .= '<tr><td>' . $languageService->sL('LLL:EXT:lang/locallang_wizards.xlf:imwizard.crop-y', TRUE) . '</td>';
		$content .= '<td class="t3js-image-manipulation-info-crop-y">' . $y . 'px</td></tr>';
		$content .= '<tr><td>' . $languageService->sL('LLL:EXT:lang/locallang_wizards.xlf:imwizard.crop-width', TRUE) . '</td>';
		$content .= '<td class="t3js-image-manipulation-info-crop-width">' . $width . 'px</td></tr>';
		$content .= '<tr><td>' . $languageService->sL('LLL:EXT:lang/locallang_wizards.xlf:imwizard.crop-height', TRUE) . '</td>';
		$content .= '<td class="t3js-image-manipulation-info-crop-height">' . $height . 'px</td></tr>';
		$content .= '</table>';
		$content .= '</div>';

		return $content;
	}
}
