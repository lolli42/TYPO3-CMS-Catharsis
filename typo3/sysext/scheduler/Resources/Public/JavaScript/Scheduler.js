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
 * Module: TYPO3/CMS/Scheduler/Scheduler
 */
define(['jquery'], function($) {

	/**
	 *
	 * @type {{}}
	 * @exports TYPO3/CMS/Scheduler/Scheduler
	 */
	var Scheduler = {};

	var allCheckedStatus = false;

	/**
	 * This method reacts on changes to the task class
	 * It switches on or off the relevant extra fields
	 *
	 * @param {Object} theSelector
	 */
	Scheduler.actOnChangedTaskClass = function(theSelector) {
		var taskClass = theSelector.val();
		taskClass = taskClass.toLowerCase().replace(/\\/g, '-');

		// Hide all extra fields
		$('.extraFields').hide();
		// Show only relevant extra fields
		$('.extra_fields_' + taskClass).show();
	};

	/**
	 * This method reacts on changes to the type of a task, i.e. single or recurring,
	 * by showing or hiding the relevant form fields
	 *
	 * @param {Object} theSelector
	 */
	Scheduler.actOnChangedTaskType = function(theSelector) {
		// Get task type from selected value, or set default value
		// Single taskType = 1, Recurring task = 0
		var taskType = parseInt(theSelector.val()) == 1 ? 0 : 1;
		$('#task_end_row').toggle(taskType);
		$('#task_frequency_row').toggle(taskType);
		$('#task_multiple_row').toggle(taskType);
	};

	/**
	 * This method reacts on field changes of all table field for table garbage collection task
	 *
	 * @param {Object} theCheckbox
	 */
	Scheduler.actOnChangeSchedulerTableGarbageCollectionAllTables = function(theCheckbox) {
		var $numberOfDays = $('#task_tableGarbageCollection_numberOfDays');
		var $taskTableGarbageCollectionTable = $('#task_tableGarbageCollection_table');
		if (theCheckbox.prop('checked')) {
			$taskTableGarbageCollectionTable.prop('disabled', true);
			$numberOfDays.prop('disabled', true);
		} else {
			// Get number of days for selected table
			var numberOfDays = parseInt($numberOfDays.val());
			if (numberOfDays < 1) {
				var selectedTable = $taskTableGarbageCollectionTable.val();
				if (typeof(defaultNumberOfDays[selectedTable]) !== 'undefined') {
					numberOfDays = defaultNumberOfDays[selectedTable];
				}
			}

			$taskTableGarbageCollectionTable.prop('disabled', false);
			if (numberOfDays > 0) {
				$numberOfDays.prop('disabled', false);
			}
		}
	};

	/**
	 * This methods set the 'number of days' field to the default expire period
	 * of the selected table
	 *
	 * @param {Object} theSelector
	 */
	Scheduler.actOnChangeSchedulerTableGarbageCollectionTable = function(theSelector) {
		var $numberOfDays = $('#task_tableGarbageCollection_numberOfDays');
		if (defaultNumberOfDays[theSelector.val()] > 0) {
			$numberOfDays.prop('disabled', false);
			$numberOfDays.val(defaultNumberOfDays[theSelector.val()]);
		} else {
			$numberOfDays.prop('disabled', true);
			$numberOfDays.val(0);
		}
	};

	/**
	 * Check or uncheck all checkboxes
	 *
	 * @param {Object} theSelector
	 * @returns {Boolean}
	 */
	Scheduler.checkOrUncheckAllCheckboxes = function(theSelector) {
		theSelector.parents('.tx_scheduler_mod1').find(':checkbox').prop('checked', !allCheckedStatus);
		allCheckedStatus = !allCheckedStatus;
		return false;
	};

	/**
	 * Registers listeners
	 */
	Scheduler.initializeEvents = function() {
		$('#checkall').on('click', function() {
			Scheduler.checkOrUncheckAllCheckboxes($(this));
		});

		$('#task_class').change(function() {
			Scheduler.actOnChangedTaskClass($(this));
		});

		$('#task_type').change(function() {
			Scheduler.actOnChangedTaskType($(this));
		});

		$('#task_tableGarbageCollection_allTables').change(function() {
			Scheduler.actOnChangeSchedulerTableGarbageCollectionAllTables($(this));
		});

		$('#task_tableGarbageCollection_table').change(function() {
			Scheduler.actOnChangeSchedulerTableGarbageCollectionTable($(this));
		});
	};

	$(Scheduler.initializeEvents);

	return Scheduler;
});
