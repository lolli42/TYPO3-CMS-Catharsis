/**
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
 * Ext.ux.HTMLAreaButton extends Ext.Button
 */
Ext.ux.HTMLAreaButton = function (UserAgent, Event) {

	var Button = Ext.extend(Ext.Button, {

		/**
		 * Component initialization
		 */
		initComponent: function () {
			Button.superclass.initComponent.call(this);
			this.addListener({
				afterrender: {
					fn: this.initEventListeners,
					single: true
				}
			});
		},

		/**
		 * Initialize listeners
		 */
		initEventListeners: function () {
			var self = this;
			Event.on(this, 'HTMLAreaEventHotkey', function (event, key, keyEvent) { return self.onHotKey(key, keyEvent); });
			Event.on(this, 'HTMLAreaEventContextMenu', function (event, button) { return self.onButtonClick(button, event); });
			this.setHandler(this.onButtonClick, this);
			// Monitor toolbar updates in order to refresh the state of the button
			Event.on(this.getToolbar(), 'HTMLAreaEventToolbarUpdate', function (event, mode, selectionEmpty, ancestors, endPointsInSameBlock) { Event.stopEvent(event); self.onUpdateToolbar(mode, selectionEmpty, ancestors, endPointsInSameBlock); return false; });
		},

		/**
		 * Get a reference to the editor
		 */
		getEditor: function() {
			return RTEarea[this.ownerCt.editorId].editor;
		},

		/**
		 * Get a reference to the toolbar
		 */
		getToolbar: function() {
			return this.ownerCt;
		},

		/**
		 * Add properties and function to set button active or not depending on current selection
		 */
		inactive: true,
		activeClass: 'buttonActive',
		setInactive: function (inactive) {
			this.inactive = inactive;
			return inactive ? this.removeClass(this.activeClass) : this.addClass(this.activeClass);
		},

		/**
		 * Determine if the button should be enabled based on the current selection and context configuration property
		 */
		isInContext: function (mode, selectionEmpty, ancestors) {
			var editor = this.getEditor();
			var inContext = true;
			if (mode === 'wysiwyg' && this.context) {
				var attributes = [],
					contexts = [];
				if (/(.*)\[(.*?)\]/.test(this.context)) {
					contexts = RegExp.$1.split(',');
					attributes = RegExp.$2.split(',');
				} else {
					contexts = this.context.split(',');
				}
				contexts = new RegExp( '^(' + contexts.join('|') + ')$', 'i');
				var matchAny = contexts.test('*');
				var i, j, n;
				for (i = 0, n = ancestors.length; i < n; i++) {
					var ancestor = ancestors[i];
					inContext = matchAny || contexts.test(ancestor.nodeName);
					if (inContext) {
						for (j = attributes.length; --j >= 0;) {
							inContext = eval("ancestor." + attributes[j]);
							if (!inContext) {
								break;
							}
						}
					}
					if (inContext) {
						break;
					}
				}
			}
			return inContext && (!this.selection || !selectionEmpty);
		},

		/**
		 * Handler invoked when the button is clicked
		 */
		onButtonClick: function (button, event, key) {
			if (!this.disabled) {
				if (!this.plugins[this.action](this.getEditor(), key || this.itemId) && event) {
					Event.stopEvent(event);
				}
				if (UserAgent.isOpera) {
					this.getEditor().focus();
				}
				if (this.dialog) {
					this.setDisabled(true);
				} else {
					this.getToolbar().update();
				}
			}
			return false;
		},

		/**
		 * Handler invoked when the hotkey configured for this button is pressed
		 */
		onHotKey: function (key, event) {
			return this.onButtonClick(this, event, key);
		},

		/**
		 * Handler invoked when the toolbar is updated
		 */
		onUpdateToolbar: function (mode, selectionEmpty, ancestors, endPointsInSameBlock) {
			this.setDisabled(mode === 'textmode' && !this.textMode);
			if (!this.disabled) {
				if (!this.noAutoUpdate) {
					this.setDisabled(!this.isInContext(mode, selectionEmpty, ancestors));
				}
				this.plugins['onUpdateToolbar'](this, mode, selectionEmpty, ancestors, endPointsInSameBlock);
			}
		}
	});

	return Button;

}(HTMLArea.UserAgent, HTMLArea.Event);
Ext.reg('htmlareabutton', Ext.ux.HTMLAreaButton);
