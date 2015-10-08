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

module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		banner: '/*!\n' +
			' * This file is part of the TYPO3 CMS project.\n' +
			' *\n' +
			' * It is free software; you can redistribute it and/or modify it under\n' +
			' * the terms of the GNU General Public License, either version 2\n' +
			' * of the License, or any later version.\n' +
			' *\n' +
			' * For the full copyright and license information, please read the\n' +
			' * LICENSE.txt file that was distributed with this source code.\n' +
			' *\n' +
			' * The TYPO3 project - inspiring people to share!\n' +
			' */\n',
		paths: {
			resources : 'Resources/',
			less      : '<%= paths.resources %>Public/Less/',
			icons     : '<%= paths.resources %>Private/Icons/',
			root      : '../',
			sysext    : '<%= paths.root %>typo3/sysext/',
			t3skin    : '<%= paths.sysext %>t3skin/Resources/',
			backend   : '<%= paths.sysext %>backend/Resources/',
			core      : '<%= paths.sysext %>core/Resources/',
			flags     : 'bower_components/region-flags/svg/'
		},
		less: {
			t3skin: {
				options: {
					banner: '<%= banner %>',
					outputSourceFiles: true
				},
				files: {
					"<%= paths.t3skin %>Public/Css/backend.css": "<%= paths.less %>backend.less"
				}
			}
		},
		postcss: {
			options: {
				map: false,
				processors: [
					require('autoprefixer')({ // add vendor prefixes
						browsers: [
							'Last 2 versions',
							'Firefox ESR',
							'IE 9'
						]
					})
				]
			},
			t3skin: {
				src: '<%= paths.t3skin %>Public/Css/*.css'
			}
		},
		watch: {
			less: {
				files: '<%= paths.less %>**/*.less',
				tasks: 'css'
			}
		},
		bowercopy: {
			options: {
				clean: false,
				report: false,
				runBower: false,
				srcPrefix: "bower_components/"
			},
			all: {
				options: {
					destPrefix: "<%= paths.core %>Public/JavaScript/Contrib"
				},
				files: {
					'nprogress.js': 'nprogress/nprogress.js',
					'jquery.dataTables.js': 'datatables/media/js/jquery.dataTables.min.js',
					'require.js': 'requirejs/require.js',
					'moment.js': 'moment/moment.js',
					'moment-timezone.js': 'moment-timezone/builds/moment-timezone-with-data.min.js',
					'cropper.min.js': 'cropper/dist/cropper.min.js',
					'imagesloaded.pkgd.min.js': 'imagesloaded/imagesloaded.pkgd.min.js',
					'bootstrap-datetimepicker.js': 'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
					'autosize.js': 'autosize/dest/autosize.min.js',
					'placeholders.jquery.min.js': 'Placeholders.js/dist/placeholders.jquery.min.js',
					'taboverride.min.js': 'taboverride/build/output/taboverride.min.js',
					'bootstrap-slider.min.js': 'seiyria-bootstrap-slider/dist/bootstrap-slider.min.js',
					/* disabled until autocomplete groupBy is fixed by the author
						see https://github.com/devbridge/jQuery-Autocomplete/pull/387
					'jquery.autocomplete.js': 'devbridge-autocomplete/src/jquery.autocomplete.js',
					 */

					/**
					 * copy needed parts of jquery
					 */
					'jquery/jquery-2.1.4.js': 'jquery/dist/jquery.js',
					'jquery/jquery-2.1.4.min.js': 'jquery/dist/jquery.min.js',
					/**
					 * copy needed parts of jquery-ui
					 */
					'jquery-ui/core.js': 'jquery-ui/ui/core.js',
					'jquery-ui/draggable.js': 'jquery-ui/ui/draggable.js',
					'jquery-ui/droppable.js': 'jquery-ui/ui/droppable.js',
					'jquery-ui/mouse.js': 'jquery-ui/ui/mouse.js',
					'jquery-ui/position.js': 'jquery-ui/ui/position.js',
					'jquery-ui/resizable.js': 'jquery-ui/ui/resizable.js',
					'jquery-ui/selectable.js': 'jquery-ui/ui/selectable.js',
					'jquery-ui/sortable.js': 'jquery-ui/ui/sortable.js',
					'jquery-ui/widget.js': 'jquery-ui/ui/widget.js'
				}
			}
		},
		uglify: {
			thirdparty: {
				files: {
					"<%= paths.core %>Public/JavaScript/Contrib/require.js": ["<%= paths.core %>Public/JavaScript/Contrib/require.js"],
					"<%= paths.core %>Public/JavaScript/Contrib/moment.js": ["<%= paths.core %>Public/JavaScript/Contrib/moment.js"],
					"<%= paths.core %>Public/JavaScript/Contrib/nprogress.js": ["<%= paths.core %>Public/JavaScript/Contrib/nprogress.js"],
					"<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/core.js": ["<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/core.js"],
					"<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/draggable.js": ["<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/draggable.js"],
					"<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/droppable.js": ["<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/droppable.js"],
					"<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/mouse.js": ["<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/mouse.js"],
					"<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/position.js": ["<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/position.js"],
					"<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/resizable.js": ["<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/resizable.js"],
					"<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/selectable.js": ["<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/selectable.js"],
					"<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/sortable.js": ["<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/sortable.js"],
					"<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/widget.js": ["<%= paths.core %>Public/JavaScript/Contrib/jquery-ui/widget.js"]
				}
			}
		},
		svgmin: {
			options: {
				plugins: [
					{ removeViewBox: false }
				]
			},
			// Action Icons
			icons_action: {
				files: {
					'<%= paths.backend %>Public/Icons/Action/actions-document-duplicates-select.svg': '<%= paths.icons %>Action/actions-document-duplicates-select.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-document-export-csv.svg': '<%= paths.icons %>Action/actions-document-export-csv.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-document-paste-after.svg': '<%= paths.icons %>Action/actions-document-paste-after.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-document-paste-before.svg': '<%= paths.icons %>Action/actions-document-paste-before.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-document-paste-into.svg': '<%= paths.icons %>Action/actions-document-paste-into.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-document-paste.svg': '<%= paths.icons %>Action/actions-document-paste.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-document-save-cleartranslationcache.svg': '<%= paths.icons %>Action/actions-document-save-cleartranslationcache.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-document-save-close.svg': '<%= paths.icons %>Action/actions-document-save-close.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-document-save-new.svg': '<%= paths.icons %>Action/actions-document-save-new.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-document-save-translation.svg': '<%= paths.icons %>Action/actions-document-save-translation.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-document-save-view.svg': '<%= paths.icons %>Action/actions-document-save-view.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-document-save.svg': '<%= paths.icons %>Action/actions-document-save.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-edit-rename.svg': '<%= paths.icons %>Action/actions-edit-rename.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-filter.svg': '<%= paths.icons %>Action/actions-filter.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-page-new.svg': '<%= paths.icons %>Action/actions-page-new.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-page-move.svg': '<%= paths.icons %>Action/actions-page-move.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-page-open.svg': '<%= paths.icons %>Action/actions-page-open.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-refresh.svg': '<%= paths.icons %>Action/actions-refresh.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-search.svg': '<%= paths.icons %>Action/actions-search.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-system-cache-clear-impact-high.svg': '<%= paths.icons %>Action/actions-system-cache-clear-impact-high.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-system-cache-clear-impact-low.svg': '<%= paths.icons %>Action/actions-system-cache-clear-impact-low.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-system-cache-clear-impact-medium.svg': '<%= paths.icons %>Action/actions-system-cache-clear-impact-medium.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-system-help-open.svg': '<%= paths.icons %>Action/actions-system-help-open.svg',
					'<%= paths.backend %>Public/Icons/Action/actions-system-tree-search-open.svg': '<%= paths.icons %>Action/actions-system-tree-search-open.svg'
				}
			},
			// Action Icons
			icons_apps: {
				files: {
					'<%= paths.backend %>Public/Icons/App/apps-filetree-folder-default.svg': '<%= paths.icons %>App/apps-filetree-folder-default.svg',
					'<%= paths.backend %>Public/Icons/App/apps-filetree-folder-locked.svg': '<%= paths.icons %>App/apps-filetree-folder-locked.svg',
					'<%= paths.backend %>Public/Icons/App/apps-filetree-folder-opened.svg': '<%= paths.icons %>App/apps-filetree-folder-opened.svg',
					'<%= paths.backend %>Public/Icons/App/apps-filetree-folder-recycler.svg': '<%= paths.icons %>App/apps-filetree-folder-recycler.svg',
					'<%= paths.backend %>Public/Icons/App/apps-filetree-folder-temp.svg': '<%= paths.icons %>App/apps-filetree-folder-temp.svg',
					'<%= paths.backend %>Public/Icons/App/apps-filetree-mount.svg': '<%= paths.icons %>App/apps-filetree-mount.svg',
					'<%= paths.backend %>Public/Icons/App/apps-pagetree-root.svg': '<%= paths.icons %>App/apps-pagetree-root.svg',
					'<%= paths.backend %>Public/Icons/App/apps-toolbar-menu-search.svg': '<%= paths.icons %>App/apps-toolbar-menu-search.svg'
				}
			},
			// Avatar Icons
			icons_avatar: {
				files: {
					'<%= paths.sysext %>backend/Resources/Public/Icons/avatar-default.svg': '<%= paths.icons %>Avatar/avatar-default.svg'
				}
			},
			// Default Icons
			icons_default: {
				files: {
					'<%= paths.backend %>Public/Icons/Default/default-not-found.svg': '<%= paths.icons %>Default/default-not-found.svg'
				}
			},
			// Mimetypes
			icons_mimetypes: {
				files: {
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-compressed.svg': '<%= paths.icons %>Mimetype/mimetypes-compressed.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-excel.svg': '<%= paths.icons %>Mimetype/mimetypes-excel.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-application.svg': '<%= paths.icons %>Mimetype/mimetypes-application.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-media-audio.svg': '<%= paths.icons %>Mimetype/mimetypes-media-audio.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-media-flash.svg': '<%= paths.icons %>Mimetype/mimetypes-media-flash.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-media-image.svg': '<%= paths.icons %>Mimetype/mimetypes-media-image.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-media-video.svg': '<%= paths.icons %>Mimetype/mimetypes-media-video.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-media-video-vimeo.svg': '<%= paths.icons %>Mimetype/mimetypes-media-video-vimeo.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-media-video-youtube.svg': '<%= paths.icons %>Mimetype/mimetypes-media-video-youtube.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-other-other.svg': '<%= paths.icons %>Mimetype/mimetypes-other-other.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-pdf.svg': '<%= paths.icons %>Mimetype/mimetypes-pdf.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-powerpoint.svg': '<%= paths.icons %>Mimetype/mimetypes-powerpoint.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-text-css.svg': '<%= paths.icons %>Mimetype/mimetypes-text-css.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-text-csv.svg': '<%= paths.icons %>Mimetype/mimetypes-text-csv.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-text-html.svg': '<%= paths.icons %>Mimetype/mimetypes-text-html.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-text-js.svg': '<%= paths.icons %>Mimetype/mimetypes-text-js.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-text-php.svg': '<%= paths.icons %>Mimetype/mimetypes-text-php.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-text-text.svg': '<%= paths.icons %>Mimetype/mimetypes-text-text.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-text-ts.svg': '<%= paths.icons %>Mimetype/mimetypes-text-ts.svg',
					'<%= paths.backend %>Public/Icons/Mimetype/mimetypes-word.svg': '<%= paths.icons %>Mimetype/mimetypes-word.svg'
				}
			},
			// ContentElement Icons
			icons_contentelement: {
				files: {
					'<%= paths.sysext %>backend/Resources/Public/Icons/ContentElement/content-bullets.svg': '<%= paths.icons %>ContentElement/content-bullets.svg',
					'<%= paths.sysext %>backend/Resources/Public/Icons/ContentElement/content-header.svg': '<%= paths.icons %>ContentElement/content-header.svg',
					'<%= paths.sysext %>backend/Resources/Public/Icons/ContentElement/content-image.svg': '<%= paths.icons %>ContentElement/content-image.svg',
					'<%= paths.sysext %>backend/Resources/Public/Icons/ContentElement/content-plugin.svg': '<%= paths.icons %>ContentElement/content-plugin.svg',
					'<%= paths.sysext %>backend/Resources/Public/Icons/ContentElement/content-special-divider.svg': '<%= paths.icons %>ContentElement/content-special-divider.svg',
					'<%= paths.sysext %>backend/Resources/Public/Icons/ContentElement/content-special-html.svg': '<%= paths.icons %>ContentElement/content-special-html.svg',
					'<%= paths.sysext %>backend/Resources/Public/Icons/ContentElement/content-special-menu.svg': '<%= paths.icons %>ContentElement/content-special-menu.svg',
					'<%= paths.sysext %>backend/Resources/Public/Icons/ContentElement/content-table.svg': '<%= paths.icons %>ContentElement/content-table.svg',
					'<%= paths.sysext %>backend/Resources/Public/Icons/ContentElement/content-text.svg': '<%= paths.icons %>ContentElement/content-text.svg',
					'<%= paths.sysext %>backend/Resources/Public/Icons/ContentElement/content-textpic.svg': '<%= paths.icons %>ContentElement/content-textpic.svg'
				}
			},
			// Miscellaneous Icons
			icons_miscellaneous: {
				files: {
					'<%= paths.backend %>Public/Icons/Miscellaneous/miscellaneous-placeholder.svg': '<%= paths.icons %>Miscellaneous/miscellaneous-placeholder.svg'
				}
			},
			// Module Icons
			icons_module: {
				files: {
					'<%= paths.sysext %>about/Resources/Public/Icons/module-about.svg': '<%= paths.icons %>Module/module-about.svg',
					'<%= paths.sysext %>aboutmodules/Resources/Public/Icons/module-aboutmodules.svg': '<%= paths.icons %>Module/module-aboutmodules.svg',
					'<%= paths.sysext %>belog/Resources/Public/Icons/module-belog.svg': '<%= paths.icons %>Module/module-belog.svg',
					'<%= paths.sysext %>beuser/Resources/Public/Icons/module-beuser.svg': '<%= paths.icons %>Module/module-beuser.svg',
					'<%= paths.sysext %>lowlevel/Resources/Public/Icons/module-config.svg': '<%= paths.icons %>Module/module-config.svg',
					'<%= paths.sysext %>cshmanual/Resources/Public/Icons/module-cshmanual.svg': '<%= paths.icons %>Module/module-cshmanual.svg',
					'<%= paths.sysext %>dbal/Resources/Public/Icons/module-dbal.svg': '<%= paths.icons %>Module/module-dbal.svg',
					'<%= paths.sysext %>lowlevel/Resources/Public/Icons/module-dbint.svg': '<%= paths.icons %>Module/module-dbint.svg',
					'<%= paths.sysext %>documentation/Resources/Public/Icons/module-documentation.svg': '<%= paths.icons %>Module/module-documentation.svg',
					'<%= paths.sysext %>extensionmanager/Resources/Public/Icons/module-extensionmanager.svg': '<%= paths.icons %>Module/module-extensionmanager.svg',
					'<%= paths.sysext %>filelist/Resources/Public/Icons/module-filelist.svg': '<%= paths.icons %>Module/module-filelist.svg',
					'<%= paths.sysext %>func/Resources/Public/Icons/module-func.svg': '<%= paths.icons %>Module/module-func.svg',
					'<%= paths.sysext %>indexed_search/Resources/Public/Icons/module-indexed_search.svg': '<%= paths.icons %>Module/module-indexed_search.svg',
					'<%= paths.sysext %>info/Resources/Public/Icons/module-info.svg': '<%= paths.icons %>Module/module-info.svg',
					'<%= paths.sysext %>install/Resources/Public/Icons/module-install.svg': '<%= paths.icons %>Module/module-install.svg',
					'<%= paths.sysext %>lang/Resources/Public/Icons/module-lang.svg': '<%= paths.icons %>Module/module-lang.svg',
					'<%= paths.sysext %>recordlist/Resources/Public/Icons/module-list.svg': '<%= paths.icons %>Module/module-list.svg',
					'<%= paths.sysext %>backend/Resources/Public/Icons/module-page.svg': '<%= paths.icons %>Module/module-page.svg',
					'<%= paths.sysext %>beuser/Resources/Public/Icons/module-permission.svg': '<%= paths.icons %>Module/module-permission.svg',
					'<%= paths.sysext %>recycler/Resources/Public/Icons/module-recycler.svg': '<%= paths.icons %>Module/module-recycler.svg',
					'<%= paths.sysext %>reports/Resources/Public/Icons/module-reports.svg': '<%= paths.icons %>Module/module-reports.svg',
					'<%= paths.sysext %>scheduler/Resources/Public/Icons/module-scheduler.svg': '<%= paths.icons %>Module/module-scheduler.svg',
					'<%= paths.sysext %>setup/Resources/Public/Icons/module-setup.svg': '<%= paths.icons %>Module/module-setup.svg',
					'<%= paths.sysext %>taskcenter/Resources/Public/Icons/module-taskcenter.svg': '<%= paths.icons %>Module/module-taskcenter.svg',
					'<%= paths.sysext %>tstemplate/Resources/Public/Icons/module-tstemplate.svg': '<%= paths.icons %>Module/module-tstemplate.svg',
					'<%= paths.sysext %>version/Resources/Public/Icons/module-version.svg': '<%= paths.icons %>Module/module-version.svg',
					'<%= paths.sysext %>viewpage/Resources/Public/Icons/module-viewpage.svg': '<%= paths.icons %>Module/module-viewpage.svg',
					'<%= paths.sysext %>workspaces/Resources/Public/Icons/module-workspaces.svg': '<%= paths.icons %>Module/module-workspaces.svg',
					'<%= paths.sysext %>backend/Resources/Public/Icons/Spinner/spinner-circle-dark.svg': '<%= paths.icons %>Spinner/spinner-circle-dark.svg',
					'<%= paths.sysext %>backend/Resources/Public/Icons/Spinner/spinner-circle-light.svg': '<%= paths.icons %>Spinner/spinner-circle-light.svg'
				}
			},
			// Overlay Icons
			icons_overlay: {
				files: {
					'<%= paths.backend %>Public/Icons/Overlay/overlay-deleted.svg': '<%= paths.icons %>Overlay/overlay-deleted.svg',
					'<%= paths.backend %>Public/Icons/Overlay/overlay-hidden.svg': '<%= paths.icons %>Overlay/overlay-hidden.svg',
					'<%= paths.backend %>Public/Icons/Overlay/overlay-includes-subpages.svg': '<%= paths.icons %>Overlay/overlay-includes-subpages.svg',
					'<%= paths.backend %>Public/Icons/Overlay/overlay-locked.svg': '<%= paths.icons %>Overlay/overlay-locked.svg',
					'<%= paths.backend %>Public/Icons/Overlay/overlay-missing.svg': '<%= paths.icons %>Overlay/overlay-missing.svg',
					'<%= paths.backend %>Public/Icons/Overlay/overlay-readonly.svg': '<%= paths.icons %>Overlay/overlay-readonly.svg',
					'<%= paths.backend %>Public/Icons/Overlay/overlay-restricted.svg': '<%= paths.icons %>Overlay/overlay-restricted.svg',
					'<%= paths.backend %>Public/Icons/Overlay/overlay-scheduled.svg': '<%= paths.icons %>Overlay/overlay-scheduled.svg',
					'<%= paths.backend %>Public/Icons/Overlay/overlay-translated.svg': '<%= paths.icons %>Overlay/overlay-translated.svg'
				}
			},
			// Flags
			flags: {
				files: [{
					expand: true,
					cwd: '<%= paths.flags %>',
					src: '*.svg',
					dest: '<%= paths.sysext %>core/Resources/Public/Icons/Flags/SVG/',
					ext: '.svg',
					extDot: 'first'
				}]
			}
		}
	});

	// Register tasks
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-bowercopy');
	grunt.loadNpmTasks('grunt-npm-install');
	grunt.loadNpmTasks('grunt-bower-just-install');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-svgmin');
	grunt.loadNpmTasks('grunt-postcss');

	/**
	 * grunt default task
	 *
	 * call "$ grunt"
	 *
	 * this will trigger the CSS build
	 */
	grunt.registerTask('default', ['css']);

	/**
	 * grunt css task
	 *
	 * call "$ grunt css"
	 *
	 * this task does the following things:
	 * - less
	 * - postcss
	 */
	grunt.registerTask('css', ['less', 'postcss']);

	/**
	 * grunt update task
	 *
	 * call "$ grunt update"
	 *
	 * this task does the following things:
	 * - npm install
	 * - bower install
	 * - copy some bower components to a specific destinations because they need to be included via PHP
	 */
	grunt.registerTask('update', ['npm-install', 'bower_install', 'bowercopy']);

	/**
	 * grunt build task
	 *
	 * call "$ grunt build"
	 *
	 * this task does the following things:
	 * - execute update task
	 * - compile less files
	 * - uglify js files
	 * - minifies svg files
	 */
	grunt.registerTask('build', ['update', 'css', 'uglify', 'svgmin']);
};
