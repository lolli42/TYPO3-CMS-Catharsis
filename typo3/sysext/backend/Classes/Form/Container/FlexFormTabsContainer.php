<?php
namespace TYPO3\CMS\Backend\Form\Container;

use TYPO3\CMS\Backend\Template\DocumentTemplate;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Lang\LanguageService;

class FlexFormTabsContainer extends AbstractContainer {

	/**
	 * @return array As defined in initializeResultArray() of AbstractNode
	 */
	public function render() {
		$languageService = $this->getLanguageService();

		$table = $this->globalOptions['table'];
		$row = $this->globalOptions['databaseRow'];
		$fieldName = $this->globalOptions['fieldName']; // field name of the flex form field in DB
		$parameterArray = $this->globalOptions['parameterArray'];
		$flexFormDataStructureArray = $this->globalOptions['flexFormDataStructureArray'];
		$flexFormCurrentLanguage = $this->globalOptions['flexFormCurrentLanguage'];
		$flexFormRowData = $this->globalOptions['flexFormRowData'];

		$resultArray = $this->initializeResultArray();

		$tabsContent = array();
		foreach ($flexFormDataStructureArray['sheets'] as $sheetName => $sheetDataStructure) {
			$flexFormRowSheetDataSubPart = $flexFormRowData['data'][$sheetName][$flexFormCurrentLanguage];

			// Evaluate display condition for this sheet if there is one
			$displayConditionResult = TRUE;
			if (!empty($sheetDataStructure['ROOT']['TCEforms']['displayCond'])) {
				$displayConditionDefinition = $sheetDataStructure['ROOT']['TCEforms']['displayCond'];
				$displayConditionResult = $this->evaluateFlexFormDisplayCondition(
					$displayConditionDefinition,
					$flexFormRowSheetDataSubPart
				);
			}
			if (!$displayConditionResult) {
				continue;
			}

			if (!is_array($sheetDataStructure['ROOT']['el'])) {
				$resultArray['html'] .= LF . 'No Data Structure ERROR: No [\'ROOT\'][\'el\'] found for sheet "' . $sheetName . '".';
				continue;
			}

			// Assemble key for loading the correct CSH file
			// @todo: what is that good for?
			$dsPointerFields = GeneralUtility::trimExplode(',', $GLOBALS['TCA'][$table]['columns'][$fieldName]['config']['ds_pointerField'], TRUE);
			$parameterArray['_cshKey'] = $table . '.' . $fieldName;
			foreach ($dsPointerFields as $key) {
				$parameterArray['_cshKey'] .= '.' . $row[$key];
			}

			// @todo: next two lines are dummy
			$childReturn = $this->initializeResultArray();
			$childReturn['html'] = 'element in sheet';

			$tabsContent[] = array(
				'label' => !empty($sheetDataStructure['ROOT']['TCEforms']['sheetTitle']) ? $languageService->sL($sheetDataStructure['ROOT']['TCEforms']['sheetTitle']) : $sheetName,
				'content' => $childReturn['html'],
				'description' => $sheetDataStructure['ROOT']['TCEforms']['sheetDescription'] ? $languageService->sL($sheetDataStructure['ROOT']['TCEforms']['sheetDescription']) : '',
				'linkTitle' => $sheetDataStructure['ROOT']['TCEforms']['sheetShortDescr'] ? $languageService->sL($sheetDataStructure['ROOT']['TCEforms']['sheetShortDescr']) : '',
			);

			$childReturn['html'] = '';
			$resultArray = $this->mergeChildReturnIntoExistingResult($resultArray, $childReturn);
		}

		// Feed everything to document template for tab rendering
		$tabId = 'TCEFORMS:flexform:' . $this->globalOptions['parameterArray']['itemFormElName'] . $flexFormCurrentLanguage;
		$resultArray['html'] = $this->getDocumentTemplate()->getDynamicTabMenu($tabsContent, $tabId, 1, FALSE, FALSE);
		return $resultArray;
	}

	/**
	 * @throws \RuntimeException
	 * @return DocumentTemplate
	 */
	protected function getDocumentTemplate() {
		$docTemplate = $GLOBALS['TBE_TEMPLATE'];
		if (!is_object($docTemplate)) {
			throw new \RuntimeException('No instance of DocumentTemplate found', 1427143328);
		}
		return $docTemplate;
	}

	/**
	 * @return LanguageService
	 */
	protected function getLanguageService() {
		return $GLOBALS['LANG'];
	}

}
