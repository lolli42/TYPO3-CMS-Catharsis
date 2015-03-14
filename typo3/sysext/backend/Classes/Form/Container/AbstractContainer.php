<?php
namespace TYPO3\CMS\Backend\Form\Container;

use TYPO3\CMS\Backend\Form\FormEngine;

abstract class AbstractContainer {

	/**
	 * @var FormEngine
	 */
	protected $formEngine;

	/**
	 * A list of global options given from FormEngine to child elements
	 *
	 * @var array
	 */
	protected $globalOptions = array();

	/**
	 * Constructor function, setting the FormEngine
	 *
	 * @param FormEngine $formEngine
	 */
	public function __construct(FormEngine $formEngine) {
		// @TODO: Remove again
		$this->formEngine = $formEngine;
	}

	/**
	 * Set global options from parent FormEngine instance
	 *
	 * @param array $globalOptions Global options like 'readonly' for all elements
	 * @return AbstractContainer
	 */
	public function setGlobalOptions(array $globalOptions) {
		$this->globalOptions = $globalOptions;
		return $this;
	}


}