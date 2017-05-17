.. include:: ../../Includes.txt

===================================================
Breaking: #80700 - Deprecated functionality removed
===================================================

See :issue:`80700`

Description
===========

The following PHP classes that have been previously deprecated for v8 have been removed:
* RemoveXSS
* TYPO3\CMS\Backend\Console\Application
* TYPO3\CMS\Backend\Console\CliRequestHandler
* TYPO3\CMS\Backend\Controller\Wizard\ColorpickerController
* TYPO3\CMS\Backend\Form\Container\SoloFieldContainer
* TYPO3\CMS\Backend\Form\Wizard\SuggestWizard
* TYPO3\CMS\Backend\Form\Wizard\ValueSliderWizard
* TYPO3\CMS\Core\Cache\CacheFactory
* TYPO3\CMS\Core\Controller\CommandLineController
* TYPO3\CMS\Core\Http\AjaxRequestHandler
* TYPO3\CMS\Core\Messaging\AbstractStandaloneMessage
* TYPO3\CMS\Core\Messaging\ErrorpageMessage
* TYPO3\CMS\Core\TimeTracker\NullTimeTracker
* TYPO3\CMS\Extbase\Utility\ArrayUtility
* TYPO3\CMS\Form\Domain\Model\FormElements\AdvancedPassword
* TYPO3\CMS\Form\ViewHelpers\Form\CheckboxViewHelper
* TYPO3\CMS\Form\ViewHelpers\Form\PlainTextMailViewHelper
* TYPO3\CMS\Frontend\Page\FramesetRenderer
* TYPO3\CMS\Lowlevel\CleanerCommand

The following PHP interfaces have been dropped:
* TYPO3\CMS\Backend\Form\DatabaseFileIconsHookInterface

The following PHP interface signatures have been changed:
* TYPO3\CMS\Extbase\Persistence\Generic\QueryInterface->like() - Third argument dropped

The following PHP class methods that have been previously deprecated for v8 have been removed:
* TYPO3\CMS\Backend\Clipboard\Clipboard->confirmMsg()
* TYPO3\CMS\Backend\Controller\BackendController->addCssFile()
* TYPO3\CMS\Backend\Controller\BackendController->addJavascript()
* TYPO3\CMS\Backend\Controller\BackendController->addJavascriptFile()
* TYPO3\CMS\Backend\Controller\BackendController->includeLegacyBackendItems()
* TYPO3\CMS\Backend\Controller\Page\LocalizationController->getRecordUidsToCopy()
* TYPO3\CMS\Backend\Controller\Page\PageLayoutController->printContent()
* TYPO3\CMS\Backend\Domain\Repository\Localization\LocalizationRepository->getAllowedLanguagesForBackendUser()
* TYPO3\CMS\Backend\Domain\Repository\Localization\LocalizationRepository->getExcludeQueryPart()
* TYPO3\CMS\Backend\Domain\Repository\Localization\LocalizationRepository->getPreviousLocalizedRecordUid()
* TYPO3\CMS\Backend\Domain\Repository\Localization\LocalizationRepository->getRecordLocalization()
* TYPO3\CMS\Backend\Form\FormDataProvider\AbstractItemProvider->sanitizeMaxItems()
* TYPO3\CMS\Backend\Module\AbstractFunctionModule->getBackPath()
* TYPO3\CMS\Backend\Module\AbstractFunctionModule->getDatabaseConnection()
* TYPO3\CMS\Backend\Module\AbstractFunctionModule->incLocalLang()
* TYPO3\CMS\Backend\Module\BaseScriptClass->getDatabaseConnection()
* TYPO3\CMS\Backend\Form\AbstractFormElement->isWizardsDisabled()
* TYPO3\CMS\Backend\Form\AbstractFormElement->renderWizards()
* TYPO3\CMS\Backend\Form\AbstractNode->getValidationDataAsDataAttribute()
* TYPO3\CMS\Backend\Form\FormResultCompiler->JStop()
* TYPO3\CMS\Backend\Routing\UriBuilder->buildUriFromAjaxId()
* TYPO3\CMS\Backend\Template\DocumentTemplate->divider()
* TYPO3\CMS\Backend\Template\DocumentTemplate->funcMenu()
* TYPO3\CMS\Backend\Template\DocumentTemplate->getContextMenuCode()
* TYPO3\CMS\Backend\Template\DocumentTemplate->getDragDropCode()
* TYPO3\CMS\Backend\Template\DocumentTemplate->getHeader()
* TYPO3\CMS\Backend\Template\DocumentTemplate->getResourceHeader()
* TYPO3\CMS\Backend\Template\DocumentTemplate->getTabMenu()
* TYPO3\CMS\Backend\Template\DocumentTemplate->getTabMenuRaw()
* TYPO3\CMS\Backend\Template\DocumentTemplate->header()
* TYPO3\CMS\Backend\Template\DocumentTemplate->icons()
* TYPO3\CMS\Backend\Template\DocumentTemplate->loadJavascriptLib()
* TYPO3\CMS\Backend\Template\DocumentTemplate->section()
* TYPO3\CMS\Backend\Template\DocumentTemplate->sectionBegin()
* TYPO3\CMS\Backend\Template\DocumentTemplate->sectionEnd()
* TYPO3\CMS\Backend\Template\DocumentTemplate->sectionHeader()
* TYPO3\CMS\Backend\Template\DocumentTemplate->t3Button()
* TYPO3\CMS\Backend\Template\DocumentTemplate->getVersionSelector()
* TYPO3\CMS\Backend\Template\DocumentTemplate->viewPageIcon()
* TYPO3\CMS\Backend\Template\DocumentTemplate->wrapInCData()
* TYPO3\CMS\Backend\Template\DocumentTemplate->wrapScriptTags()
* TYPO3\CMS\Backend\Template\ModuleTemplate->getVersionSelector()
* TYPO3\CMS\Backend\View\PageLayoutView->pages_getTree()
* TYPO3\CMS\Backend\Utility\BackendUtility::getAjaxUrl()
* TYPO3\CMS\Backend\Utility\BackendUtility::getFlexFormDS()
* TYPO3\CMS\Backend\Utility\BackendUtility::getListViewLink()
* TYPO3\CMS\Backend\Utility\BackendUtility::getRecordRaw()
* TYPO3\CMS\Backend\Utility\BackendUtility::getRecordsByField()
* TYPO3\CMS\Backend\Utility\BackendUtility::getSpecConfParametersFromArray()
* TYPO3\CMS\Backend\Utility\BackendUtility::getSpecConfParts()
* TYPO3\CMS\Backend\Utility\BackendUtility::getSQLselectableList()
* TYPO3\CMS\Backend\Utility\BackendUtility::titleAltAttrib()
* TYPO3\CMS\Backend\Utility\BackendUtility::makeConfigForm()
* TYPO3\CMS\Backend\Utility\BackendUtility::processParams()
* TYPO3\CMS\Backend\Utility\BackendUtility::replaceL10nModeFields()
* TYPO3\CMS\Backend\Utility\BackendUtility::RTEsetup()
* TYPO3\CMS\Core\Authentication\AbstractUserAuthentication->veriCode()
* TYPO3\CMS\Core\Charset\CharsetConverter->convCapitalize()
* TYPO3\CMS\Core\Charset\CharsetConverter->conv_case()
* TYPO3\CMS\Core\Charset\CharsetConverter->euc_char2byte_pos()
* TYPO3\CMS\Core\Charset\CharsetConverter->euc_strlen()
* TYPO3\CMS\Core\Charset\CharsetConverter->euc_strtrunc()
* TYPO3\CMS\Core\Charset\CharsetConverter->euc_substr()
* TYPO3\CMS\Core\Charset\CharsetConverter->getPreferredClientLanguage()
* TYPO3\CMS\Core\Charset\CharsetConverter->strlen()
* TYPO3\CMS\Core\Charset\CharsetConverter->strtrunc()
* TYPO3\CMS\Core\Charset\CharsetConverter->substr()
* TYPO3\CMS\Core\Charset\CharsetConverter->utf8_byte2char_pos()
* TYPO3\CMS\Core\Charset\CharsetConverter->utf8_strlen()
* TYPO3\CMS\Core\Charset\CharsetConverter->utf8_strpos()
* TYPO3\CMS\Core\Charset\CharsetConverter->utf8_strrpos()
* TYPO3\CMS\Core\Charset\CharsetConverter->utf8_strtrunc()
* TYPO3\CMS\Core\Charset\CharsetConverter->utf8_substr()
* TYPO3\CMS\Core\Core\Bootstrap->loadExtensionTables()
* TYPO3\CMS\Core\Database\RelationHandler->readyForInterface()
* TYPO3\CMS\Core\Database\QueryView->tableWrap()
* TYPO3\CMS\Core\DataHandling\DataHandler::rmComma()
* TYPO3\CMS\Core\DataHandling\DataHandler::destPathFromUploadFolder()
* TYPO3\CMS\Core\DataHandling\DataHandler::noRecordsFromUnallowedTables()
* TYPO3\CMS\Core\Imaging\GraphicalFunctions->createTempSubDir()
* TYPO3\CMS\Core\Imaging\GraphicalFunctions->prependAbsolutePath()
* TYPO3\CMS\Core\Imaging\IconRegistry->getDeprecationSettings()
* TYPO3\CMS\Core\Messaging\FlashMessage->getClass()
* TYPO3\CMS\Core\Messaging\FlashMessage->getIconName()
* TYPO3\CMS\Core\TypoScript\TemplateService->splitConfArray()
* TYPO3\CMS\Core\TypoScript\TemplateService->fileContent()
* TYPO3\CMS\Core\TypoScript\TemplateService->removeQueryString()
* TYPO3\CMS\Core\TypoScript\TemplateService->sortedKeyList()
* TYPO3\CMS\Core\Utility\ArrayUtility::inArray()
* TYPO3\CMS\Core\Utility\ClientUtility::getDeviceType()
* TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addExtJSModule()
* TYPO3\CMS\Core\Utility\ExtensionManagementUtility::appendToTypoConfVars()
* TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath()
* TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler()
* TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerExtDirectComponent()
* TYPO3\CMS\Core\Utility\File\ExtendedFileUtility::pushErrorMessagesToFlashMessageQueue()
* TYPO3\CMS\Core\Utility\GeneralUtility::array2xml_cs()
* TYPO3\CMS\Core\Utility\GeneralUtility::compat_version()
* TYPO3\CMS\Core\Utility\GeneralUtility::convertMicrotime()
* TYPO3\CMS\Core\Utility\GeneralUtility::csvValues()
* TYPO3\CMS\Core\Utility\GeneralUtility::deHSCentities()
* TYPO3\CMS\Core\Utility\GeneralUtility::flushOutputBuffers()
* TYPO3\CMS\Core\Utility\GeneralUtility::freetypeDpiComp()
* TYPO3\CMS\Core\Utility\GeneralUtility::generateRandomBytes()
* TYPO3\CMS\Core\Utility\GeneralUtility::getMaximumPathLength()
* TYPO3\CMS\Core\Utility\GeneralUtility::getRandomHexString()
* TYPO3\CMS\Core\Utility\GeneralUtility::imageMagickCommand()
* TYPO3\CMS\Core\Utility\GeneralUtility::lcfirst()
* TYPO3\CMS\Core\Utility\GeneralUtility::rawUrlEncodeFP()
* TYPO3\CMS\Core\Utility\GeneralUtility::rawUrlEncodeJS()
* TYPO3\CMS\Core\Utility\GeneralUtility::removeXSS()
* TYPO3\CMS\Core\Utility\GeneralUtility::requireFile()
* TYPO3\CMS\Core\Utility\GeneralUtility::requireOnce()
* TYPO3\CMS\Core\Utility\GeneralUtility::resolveAllSheetsInDS()
* TYPO3\CMS\Core\Utility\GeneralUtility::resolveSheetDefInDS()
* TYPO3\CMS\Core\Utility\GeneralUtility::slashJS()
* TYPO3\CMS\Core\Utility\GeneralUtility::strtolower()
* TYPO3\CMS\Core\Utility\GeneralUtility::strtoupper()
* TYPO3\CMS\Core\Utility\GeneralUtility::xmlGetHeaderAttribs()
* TYPO3\CMS\Extbase\Domain\Model\Category->getIcon()
* TYPO3\CMS\Extbase\Domain\Model\Category->setIcon()
* TYPO3\CMS\Extbase\Persistence\Generic\Qom\Comparison->getParameterIdentifier()
* TYPO3\CMS\Extbase\Persistence\Generic\Qom\Comparison->setParameterIdentifier()
* TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings->getUsePreparedStatement()
* TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings->getUseQueryCache()
* TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings->usePreparedStatement()
* TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings->useQueryCache()
* TYPO3\CMS\Fluid\Core\Rendering\RenderingContext->getObjectManager()
* TYPO3\CMS\Fluid\Core\Rendering\RenderingContext->getTemplateVariableContainer()
* TYPO3\CMS\Fluid\Core\Rendering\RenderingContext->injectObjectManager()
* TYPO3\CMS\Fluid\Core\Rendering\RenderingContext->setLegacyMode()
* TYPO3\CMS\Form\Domain\Model\FormElements\AbstractFormElement->onSubmit()
* TYPO3\CMS\Form\Domain\Model\FormElements\AbstractSection->onSubmit()
* TYPO3\CMS\Form\Domain\Model\FormElements\FileUpload->onBuildingFinished()
* TYPO3\CMS\Form\Domain\Model\FormElements\FormElementInterface->onSubmit()
* TYPO3\CMS\Form\Domain\Model\FormElements\UnknownFormElement->onSubmit()
* TYPO3\CMS\Form\Domain\Model\Renderable\AbstractRenderable->beforeRendering()
* TYPO3\CMS\Form\Domain\Model\Renderable\AbstractRenderable->onBuildingFinished()
* TYPO3\CMS\Form\Domain\Model\Renderable\RenderableInterface->onBuildingFinished()
* TYPO3\CMS\Form\Domain\Model\Renderable\RootRenderableInterface->beforeRendering()
* TYPO3\CMS\Form\Domain\Runtime\FormRuntime->beforeRendering()
* TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication->record_registration()
* TYPO3\CMS\Frontend\ContentObject\AbstractContentObject->getContentObject()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->URLqMark()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->clearTSProperties()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->fileResource()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->fillInMarkerArray()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->getClosestMPvalueForPage()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->getSubpart()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->getWhere()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->gifBuilderTextBox()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->includeLibs()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->linebreaks()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->processParams()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->removeBadHTML()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->stdWrap_fontTag()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->stdWrap_removeBadHTML()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->substituteMarker()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->substituteMarkerAndSubpartArrayRecursive()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->substituteMarkerArray()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->substituteMarkerArrayCached()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->substituteMarkerInObject()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->substituteSubpart()
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->substituteSubpartArray()
* TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController->beLoginLinkIPList()
* TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController->csConv()
* TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController->encryptCharcode()
* TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController->encryptEmail()
* TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController->generatePage_whichScript()
* TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController->includeLibraries()
* TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController->setParseTime()
* TYPO3\CMS\Frontend\Page\PageGenerator::pagegenInit()
* TYPO3\CMS\Frontend\Page\PageRepository->getPathFromRootline()
* TYPO3\CMS\Frontend\Page\PageRepository::getHash()
* TYPO3\CMS\Frontend\Page\PageRepository::storeHash()
* TYPO3\CMS\IndexedSearch\Indexer->includeCrawlerClass()
* TYPO3\CMS\Lang\LanguageService->addModuleLabels()
* TYPO3\CMS\Lang\LanguageService->getParserFactory()
* TYPO3\CMS\Lang\LanguageService->makeEntities()
* TYPO3\CMS\Lang\LanguageService->overrideLL()
* TYPO3\CMS\Lowlevel\Utility\ArrayBrowser->wrapValue()
* TYPO3\CMS\Recordlist\RecordList\AbstractDatabaseRecordList->makeQueryArray()
* TYPO3\CMS\Taskcenter\Controller\TaskModuleController->printContent()

The following methods changed signature according to previous deprecations in v8:
* TYPO3\CMS\Core\Charset\CharsetConverter->euc_char_mapping() - Third and fourth argument dropped
* TYPO3\CMS\Core\Charset\CharsetConverter->sb_char_mapping() - Third and fourth argument dropped
* TYPO3\CMS\Core\Charset\CharsetConverter->utf8_char_mapping() - Second and third argument dropped
* TYPO3\CMS\Core\DataHandling\DataHandler->extFileFunctions() - Fourth argument dropped
* TYPO3\CMS\Core\Html\HtmlParser->RTE_transform() - Second argument unused
* TYPO3\CMS\Core\Localization\LanguageStore->setConfiguration() - Third argument dropped
* TYPO3\CMS\Core\Localization\LocalizationFactory->getParsedData() - Third and fourth argument unused
* TYPO3\CMS\Core\Localization\Parser\AbstractXmlParser->getParsedData() - Third argument dropped
* TYPO3\CMS\Core\Localization\Parser\LocalizationParserInterface->getParsedData() - Third argument dropped
* TYPO3\CMS\Core\Localization\Parser\LocallangXmlParser->getParsedData() - Third argument dropped
* TYPO3\CMS\Core\Page\PageRenderer->addInlineLanguageLabelFile() - Fourth argument dropped
* TYPO3\CMS\Core\Page\PageRenderer->includeLanguageFileForInline() - Fourth argument dropped
* TYPO3\CMS\Core\TypoScript\TemplateService->linkData() - Fourth argument unused
* TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction() - Persistent or file prefix in first argument removed
* \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule - Fifth argument ignores  [labels][tabs_images][tab]
* TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName() - Second and thrird argument dropped
* TYPO3\CMS\Core\Utility\GeneralUtility::getUserObj() - File reference prefix in first argument removed
* TYPO3\CMS\Core\Utility\GeneralUtility::wrapJS() - Second argument dropped
* TYPO3\CMS\Extbase\Persistence\Generic\Qom\Statement - support for \TYPO3\CMS\Core\Database\PreparedStatement as argument dropped
* TYPO3\CMS\Extbase\Mvc\Cli\ConsoleOutput->askAndValidate() - support for boolean as fourth argument removed
* TYPO3\CMS\Extbase\Mvc\Cli\ConsoleOutput->select() - support for boolean as fifth argument removed
* TYPO3\CMS\Extbase\Persistence\Generic\Query->like() - Third argument dropped
* TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->searchWhere() - Third parameter is now mandatory
* TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController->whichWorkspace() - First argument removed
* TYPO3\CMS\Frontend\Plugin\AbstractPlugin->__constructor() - First argument unused
* TYPO3\CMS\Lang\LanguageService->getLL() - Second argument dropped
* TYPO3\CMS\Lang\LanguageService->getLLL() - Third argument dropped
* TYPO3\CMS\Lang\LanguageService->getsL() - Second argument dropped
* TYPO3\CMS\Recycler\Utility\RecyclerUtility->getRecordPath() - Second, third and fourth argument dropped

The following public class properties have been dropped:
* TYPO3\CMS\Backend\Controller\EditDocumentController->localizationMode
* TYPO3\CMS\Backend\Controller\Page\PageLayoutController->edit_record
* TYPO3\CMS\Backend\Controller\Page\PageLayoutController->new_unique_uid
* TYPO3\CMS\Backend\Controller\Page\PageLayoutController->externalTables
* TYPO3\CMS\Backend\Module\AbstractFunctionModule->thisPath
* TYPO3\CMS\Backend\Template\DocumentTemplate->extJScode
* TYPO3\CMS\Backend\Template\DocumentTemplate->form_largeComp
* TYPO3\CMS\Core\Charset\CharsetConverter->charSetArray
* TYPO3\CMS\Core\Charset\CharsetConverter->fourByteSets
* TYPO3\CMS\Core\DataHandling\DataHandler->checkWorkspaceCache
* TYPO3\CMS\Core\Imaging\GraphicalFunctions->tempPath
* TYPO3\CMS\Frontend\ContentObject\Menu\AbstractMenuContentObject->parentMenuArr
* TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController->compensateFieldWidth
* TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController->dtdAllowsFrames
* TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController->excludeCHashVars
* TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController->scriptParseTime
* TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController->csConvObj
* TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController->defaultCharSet
* TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController->renderCharset
* TYPO3\CMS\Lang\LanguageService->charSet
* TYPO3\CMS\Lang\LanguageService->csConvObj
* TYPO3\CMS\Lang\LanguageService->moduleLabels
* TYPO3\CMS\Lang\LanguageService->parserFactory

The following class properties have changed visibility:
* TYPO3\CMS\Core\DataHandling\DataHandler->recUpdateAccessCache changed from public to protected
* TYPO3\CMS\Core\DataHandling\DataHandler->recInsertAccessCache changed from public to protected
* TYPO3\CMS\Core\DataHandling\DataHandler->isRecordInWebMount_Cache changed from public to protected
* TYPO3\CMS\Core\DataHandling\DataHandler->isInWebMount_Cache changed from public to protected
* TYPO3\CMS\Core\DataHandling\DataHandler->cachedTSconfig changed from public to protected
* TYPO3\CMS\Core\DataHandling\DataHandler->pageCache changed from public to protected

The following public class constants have been dropped:
* TYPO3\CMS\Backend\Template\DocumentTemplate::STATUS_ICON_ERROR
* TYPO3\CMS\Backend\Template\DocumentTemplate::STATUS_ICON_WARNING
* TYPO3\CMS\Backend\Template\DocumentTemplate::STATUS_ICON_NOTIFICATION
* TYPO3\CMS\Backend\Template\DocumentTemplate::STATUS_ICON_OK

The following configuration options are not evaluated anymore:
* $TYPO3_CONF_VARS[SC_OPTIONS][GLOBAL][cliKeys]
* $TYPO3_CONF_VARS[FE][noPHPscriptInclude]
* $TYPO3_CONF_VARS[FE][maxSessionDataSize]
* $GLOBALS['TYPO3_CONF_VARS_extensionAdded']

The following entry points have been removed:
* typo3/cli_dispatch.phpsh

The following hooks have been removed:
* $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['getFlexFormDSClass']
* $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/div/class.t3lib_utility_client.php']['getDeviceType']
* $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/class.db_list.inc']['makeQueryArray']

The following functionality has been removed:
* Support for legacy prepared statements within Extbase Persistence within Qom\Statement

The following TypoScript options have been removed:
* stdWrap.fontTag
* stdWrap.removeBadHTML
* config.mainScript
* config.frameReloadIfNotInFrameset
* config.noScaleUp
* config.setJS_mouseOver
* config.setJS_openPic
* config.doctype = xhtml_frames
* config.xhtmlDoctype = xhtml_frames
* config.pageGenScript
* config.beLoginLinkIPList
* config.beLoginLinkIPList_login
* config.beLoginLinkIPList_logout
* page.frameSet
* page.insertClassesFromRTE
* single slashes are no longer interpreted as comment

The following TCA properties have been removed:
* type=select selectedListStyle
* type=select itemListStyle

The following PageTsConfig properties have been removed:
* TCEFORM.[table].[field].addItems.icon - with icons not registered in IconRegistry
* TCEFORM.[table].[flexFormField].PAGE_TSCONFIG_ID
* TCEFORM.[table].[flexFormField].PAGE_TSCONFIG_IDLIST
* TCEFORM.[table].[flexFormField].PAGE_TSCONFIG_STR

The following icon identifiers have been removed:
* actions-document-close
* actions-edit-add

The following Fluid ViewHelper arguments have been removed:
* f:be.container->enableClickMenu
* f:be.container->loadExtJs
* f:be.container->loadExtJsTheme
* f:be.container->enableExtJsDebug
* f:be.container->loadJQuery
* f:be.container->jQueryNamespace
* f:be.pageRenderer->loadExtJs
* f:be.pageRenderer->loadExtJsTheme
* f:be.pageRenderer->enableExtJsDebug
* f:be.pageRenderer->loadJQuery
* f:be.pageRenderer->jQueryNamespace

The following requireJS modules have been removed:
* TYPO3/CMS/Core/QueryGenerator

Further removal notes:
* FormEngine result array ignores key `extJSCODE`
* RTE transformation 'ts_css' dropped
* Invalid flex form data structure wildcard matching `secondFieldValue,*` dropped

The following JavaScript methods and options have been removed:
* backend/Resources/Public/JavaScript/jsfunc.inline.js escapeSelectorObjectId
* TYPO3/CMS/Backend/Modal.getSeverityClass()
* TYPO3/CMS/Backend/Severity.information


Impact
======

Instantiating or requiring the PHP classes, will result in PHP fatal errors.

Calling the entry points via CLI will result in a file not found error.

.. index:: PHP-API
