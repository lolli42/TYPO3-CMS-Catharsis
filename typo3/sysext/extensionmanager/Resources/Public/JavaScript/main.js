// IIFE for faster access to $ and save $ use
(function ($) {

	$(document).ready(function() {
		manageExtensionListing();
		$("#typo3-extension-configuration-forms").tabs();

		$('.onClickMaskExtensionManager').click(function() {
			$('.typo3-extension-manager').mask();
		});

		$('.dataTables_wrapper .dataTables_filter input').clearable({
			onClear: function() {
				datatable.search('').draw();
			}
		});

		$('.expandable').expander({
			expandEffect: 'slideDown',
			collapseEffect: 'slideUp',
			beforeExpand: function() {
				$(this).parent().css('z-index', 199);
			},
			afterCollapse: function() {
				$(this).parent().css('z-index', 1);
			}
		});

		$('.t3-button-action-installdistribution').click(function(){
			$('.typo3-extension-manager').mask();
		});

	});

	function getUrlVars() {
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	}

	function manageExtensionListing() {
		datatable = $('#typo3-extension-list').DataTable({
			'paging': false,
			'jQueryUI': true,
			'lengthChange': false,
			'pageLength': 15,
			'language': {'search': TYPO3.l10n.localize('extensionList.search')},
			'stateSave': true,
			'drawCallback': bindActions,
			'columns': [
				null,
				null,
				null,
				null,
				{ 'type': 'version' },
				{ 'orderable': false },
				null
			]
		});

		var getVars = getUrlVars();

		// restore filter
		if(datatable.length && getVars['search']) {
			datatable.search(getVars['search']).draw();
		}
	}

	$.fn.dataTableExt.oSort['version-asc'] = function(a, b) {
		var result = compare(a,b);
		result = result * -1;
		return result;
	};

	$.fn.dataTableExt.oSort['version-desc'] = function(a, b) {
		var result = compare(a,b);
		return result;
	};

	function compare(a, b) {
		if (a === b) {
			return 0;
		}

		var a_components = a.split(".");
		var b_components = b.split(".");

		var len = Math.min(a_components.length, b_components.length);

		// loop while the components are equal
		for (var i = 0; i < len; i++) {
			// A bigger than B
			if (parseInt(a_components[i]) > parseInt(b_components[i])) {
				return 1;
			}

			// B bigger than A
			if (parseInt(a_components[i]) < parseInt(b_components[i])) {
				return -1;
			}
		}

		// If one's a prefix of the other, the longer one is greater.
		if (a_components.length > b_components.length) {
			return 1;
		}

		if (a_components.length < b_components.length) {
			return -1;
		}
		// Otherwise they are the same.
		return 0;
	}

	function bindActions() {
		$('.removeExtension').not('.transformed').each(function() {
			$(this).data('href', $(this).attr('href'));
			$(this).attr('href', '#');
			$(this).addClass('transformed');
			$(this).click(function() {
				TYPO3.Dialog.QuestionDialog({
					title: TYPO3.l10n.localize('extensionList.removalConfirmation.title'),
					msg: TYPO3.l10n.localize('extensionList.removalConfirmation.question'),
					url: $(this).data('href'),
					fn: function(button, dummy, dialog) {
						if (button == 'yes') {
							$('.typo3-extension-manager').mask();
							$.ajax({
								url: dialog.url,
								success: function() {
									location.reload();
								},
								error: function() {
									$('.typo3-extension-manager').unmask();
								}
							});
						}
					}
				});
			});
		});

		$('.t3-icon-system-extension-update').parent().each(function() {
			$(this).data('href', $(this).attr('href'));
			$(this).attr('href', '#');
			$(this).addClass('transformed');
			$(this).click(function() {
				$('.typo3-extension-manager').mask();
				$.ajax({
					url: $(this).data('href'),
					dataType: 'json',
					success: updateExtension
				});
			});
		});
	}

	function updateExtension(data) {
		var message = '<h1>' + TYPO3.l10n.localize('extensionList.updateConfirmation.title') + '</h1>';
		message += '<h2>' + TYPO3.l10n.localize('extensionList.updateConfirmation.message') + '</h2>';
		$.each(data.updateComments, function(version, comment) {
			message += '<h3>' + version + '</h3>';
			message += '<div>' + comment + '</div>';
		});

		TYPO3.Dialog.QuestionDialog({
			title: TYPO3.l10n.localize('extensionList.updateConfirmation.questionVersionComments'),
			msg: message,
			width: 600,
			url: data.url,
			fn: function(button, dummy, dialog) {
				if (button == 'yes') {
					$.ajax({
						url: dialog.url,
						dataType: 'json',
						success: function(data) {
							if (data.hasErrors) {
								top.TYPO3.Flashmessage.display(
									top.TYPO3.Severity.error,
									TYPO3.l10n.localize('downloadExtension.updateExtension.error'),
									data.errorMessage,
									15
								);
							} else {
								top.TYPO3.Flashmessage.display(
									top.TYPO3.Severity.info,
									TYPO3.l10n.localize('extensionList.updateFlashMessage.title'),
									TYPO3.l10n.localize('extensionList.updateFlashMessage.message').replace(/\{0\}/g, data.extension),
									15
								);
							}
							$('.typo3-extension-manager').unmask();
						},
						error: function(jqXHR, textStatus, errorThrown) {
							// Create an error message with diagnosis info.
							var errorMessage = textStatus + '(' + errorThrown + '): ' + jqXHR.responseText;

							top.TYPO3.Flashmessage.display(
								top.TYPO3.Severity.error,
								TYPO3.l10n.localize('downloadExtension.updateExtension.error'),
								errorMessage,
								15
							);
							$('.typo3-extension-manager').unmask();
						}
					});
				} else {
					$('.typo3-extension-manager').unmask();
				}
			}
		});
	}
}(jQuery));
