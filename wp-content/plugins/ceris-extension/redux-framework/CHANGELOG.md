# Redux Changelog

## 4.1.22
* Fixed: Menu locations wp_data object not providing name.
* Fixed: Another import/export edge case.
* Fixed: Fix setField API value.
* Fixed: Older extension compatibility.
* Fixed: Text field error with data/options args not displaying properly.
* Release date: Oct 20, 2020

## 4.1.21
* Fixed: Fixed connection banner to hide even if JS is broken by jQuery migrate issue (WP 5.5).
* Fixed: Resolved all remaining legacy extension compatibility issues.
* Fixed: Custom callback with select field.
* Fixed: Typography bug when style was hidden.
* Fixed: Issue with text labels.
* Fixed: Google fonts html validation issues.
* Added: Feedback modal.
* Fixed: Import logic flaw.
* Fixed: Security bug. Thanks @lenonleite of www.lenonleite.com.br.
* Release date: Oct 08, 2020

## 4.1.20
* Added: Properly adjust the blocked editor page width based on template selected.
* Added: Remove Qubely Pro update notice if Redux Pro is activated.
* Added: Broke out third-party premium plugins for filtering to help with understanding of what comes with Redux Pro.
* Added: Update block editor width when selecting a Redux template.
* Fixed: Some styling issues with preview modal.
* Fixed: Issue where plugin titles were not alphabetical.
* Fixed: Disabled third party premium dependencies.
* Fixed: Issue where crash would occur when Redux could not write out a file.
* Fixed: CSS selectors with HTML entities, like >, were not getting decoded for the passed compiler values.
* Fixed: Invalid logic causing some extensions not to run.
* Release date: Sep 18, 2020

## 4.1.18
* Fixed: Bug with typography output and non-array values for CSS selectors.
* Fixed: Bug with spacing field not adding the units when a default is provided.
* Added: Redux Pro install and activation flow.
* Fixed: Templates trial wasn't working properly! It works now. :)
* Release date: Sept 9, 2020

## 4.1.17
* Fixed: Edge case where enable Gutenberg notice doesn't disappear.
* Release date: Aug 27, 2020

## 4.1.16
* Fixed: Issue when null values were sent to Redux::set();
* Fixed: Default for Google fonts is now swap.
* Fixed: Fix for developers calling the API without checking for files.
* Fixed: Edge case for filter var not working on some sites.
* Fixed: Proper loading to override Redux 3 plugin.
* Added: Site name to WP data return.
* Fixed: Set height for library button when other plugins modify the CSS for the Gutenberg toolbar.
* Fixed: Don't show template messages on the front-end if an extension is missing. How did that get through?
* Fixed: Non-array values for WP data. Thanks @wilokecom.
* Added: Notification so users can enable Gutenberg when disabled.
* Added: Welcome guide to Gutenberg screen.
* Fixed: Some readme issues.
* Release date: Aug 26, 2020

## 4.1.15
* Fixed: Defaults were not saving in some situations.
* Added: Various fallback calls for JS when fetching opt_names.
* Fixed: Warnings with Rest API due to WP 5.5.
* Fixed: Subsets now are full-width in typography when rendered after page load.
* Fixed: for subsets loading when font-family is not specified.
* Added: No opt-in to tracking when embedded. Google Fonts and panel notices are still there though.
* Fixed: Is local checks conflicting with some servers.
* Fixed: WooCommerce race condition with their autoloader causing issues with some sites.
* Updated: Complete overhaul of WordPress data class.
* Fixed: Backtrace errors when blocked on servers.
* Fixed: Select2 and required fixes.
* Fixed: Customizer sidebar not showing in some cases.
* Added: Google Fonts now load ~20% faster!!!
* Release date: Aug 19, 2020

## 4.1.14
* Added: Shim for ReduxFramework->get_default_value()
* Fixed: Local issue with WP and strtolower. Sites that couldn't find classes should work now.
* Fixed: Ajax for select boxes is now working again.
* Fixed: Autoloading to bypass other embedded versions of Redux.
* Fixed: Customizer interactions are MUCH faster now. Had a greedy CSS selector before.
* Fixed: If opt_names had multiple dashes in them, JS errors occurred by a non-global replace.
* Fixed: Fix for servers that disable output buffers.
* Fixed: Ajax now does not load anything else, faster calls.
* Fixed: .folds replace issue when opt_name selector wasn't properly found.
* Release date: Aug 11, 2020

## 4.1.13
* Fixed: Major typography bug affecting saving in the panel as well as third-party extensions.
* Fixed: Customizer issue with some external extensions.
* Added: Removed `FS_METHOD` define completely.
* Release date: Aug 5, 2020

## 4.1.12
* Fixed: Direct calls to ReduxFramework were causing unexpected errors.
* Fixed: JS error on .replace because opt_name wasn't found.
* Added: `FS_METHOD` define location, had to move lower in the stack.
* Release date: Aug 5, 2020

## 4.1.11
* Fixed: Templates JS not loading and conflicting with other plugins. Need to namespace or something.
* Added: `FS_METHOD` define method for environments where it is not properly defined.
* Release date: Aug 4, 2020

## 4.1.10
* Fixed: Minified templates directory now loads.
* Added: Shadow files from old repo to stop errors from previously included third-party developer includes.
* Release date: Aug 4, 2020

## 4.1.9
* Fixed: Compatibility issue when developers made custom panel templates. The opt_name wasn't fetched and thus saving broke.
* Release date: Aug 1, 2020

## 4.1.8
* Fixed: Map files are now all present.
* Fixed: Path fix for how developers called the typography file directory.
* Release date: Aug 1, 2020

## 4.1.7
* Fixed: Issue with sortable in text mode not properly passing the name attribute and thus not saving properly.
* Fixed: Compatibility with old extension names to not crash other plugins.
* Release date: July 31, 2020

## 4.1.6
* Fixed: Issue with customizer double loading the PHP classes and causing an exception.
* Fixed: Chanced a class name as to not conflict with a 6+ year old version of Redux.
* Release date: July 30, 2020

## 4.1.5
* Fixed: Google fonts not working when old configs used string vs an array for output.
* Release date: July 30, 2020

## 4.1.4
* Fixed: Google fonts loading over non-secure breaks fonts. Forced all SSL for Google fonts.  :)
* Release date: July 30, 2020

## 4.1.3
* Fixed: Issue where theme devs tried to bypass the framework. Literally I made an empty file to fix their coding. :P
* Release date: July 29, 2020

## 4.1.2
* Fixed: Don't try to set empty defaults when none are present.
* Fixed: Issue where the WP Data argument was misused.
* Release date: July 29, 2020

## 4.1.1
* Fixed: CSS decode when esc_attr replaces the HTML characters and CSS outputs are set with >'s.
* Release date: July 29, 2020

## 4.1.0
* Fixed: Compatibility with certain themes using the deprecated $_is_plugin variable.
* Release date: July 29, 2020

## 4.0.9
* Fixed: Complete compatibility fix for older Redux extensions.
* Release date: July 28, 2020

## 4.0.8
* Fixed: Initial library load was failing on some server setups.
* Release date: July 28, 2020

## 4.0.7
* Fixed: Race condition for PHP include for Redux_Typography causing blank white screens.
* Release date: July 28, 2020

## 4.0.5
* Fixed: Issues where the site crashes because of varied ways Redux was called.
* Fixed: Varied implementations of opt_names resulting in option panels not working as expected.
* Release date: July 28, 2020

## 4.0.4.2
* Fixed:    PHP issue when Redux was called in legacy methods.
* Fixed:    CSS output not rendering properly.

## 4.0.4
* Fixed:    PHPCS, all.
* Added:    Redux Templates.
* Added:    Complete rewrite of the underlying code base is complete and complies with all WordPress coding standards. 

## 4.0.3
* Fixed:    PHPCS findings.
* Added:    New output_variables flags that dynamically add CSS variables to pages even on fields that do not support 
            dynamic CSS output. Thanks @andrejarh for the idea!

## 4.0.2
* Fixed:    PHP backwards compatibility for extensions. Still have to work on JS probably.

## 4.0.1.9
* Fixed:    #33 - Reset Section and Reset All not show appropriate message. Thanks @voldemortensen!
* Fixed:    #29 - Multi-Text class not saving properly per new field. Adding to parent container only instead.
* Fixed:    #48 - Color RGBa field alpha was not showing.
* Removed:  Deprecated notices for old Redux API is fine.
* Fixed:    Fixes for color and comma numeric validations.
* Fixed:    #30 - Initial load of typography always initiates a redux_change. Resolved, thanks @kprovance.
* Fixed:    #31 - Text field not show the correct type, thanks @adrix71!

## 4.0.1.8
* Fixed:    #30 - Typography field causing a "save" notice.
* Added:    Start of Redux Builder API for fields.
* Modified: Moved some methods to new classes.
* Fixed:    Fix underscore naming convention in in Redux_Field,
* Modified: Move two ajax saves routines to Redux_Functions_Ex for advanced customizer validation on save.

## 4.0.1.7
* Fixed:    #20 - variable mssing $ dev.
* Fixed:    Customizer saving.
* Fixed     Customizer 'required'.
* Fixed:    button_set field not saving or loading in multi mode.
* Fixed:    Section disable and section hidde in customizer.
* Fixed:    Some malformed field ids in sample-config, for some reason.
* Change:   #19 - `validate_msg` field arg replaces `msg` for validation schemes.  Shim in place for backward compatibility.

## 4.0.1.6
* Modified: Metabox lite loop not using correct extension key.
* Fixed:    Error when no theme is installed, which is possible, apparently.

## 4.0.1.5
* Fixed:    redux_post_meta returning null always.
* Added:    New Redux API get_post_meta to retrieve Metabox values.

## 4.0.1.4
* Fixed:      Metabox lite css/js not minifying on compile.
* New:        Redux APIs set_field, set_fields

## 4.0.1.3
* Improved:   Improvement record caller and warning fixes  Thanks @Torfadel.
* Fixed:      Errors on 'Get Support' page.

## 4.0.1.2
* Fixed:      #14 - Malformed enqueue URLs when embedding.

## 4.0.1.1
* Fixed:      Section field not hiding with required calls.
* Fixed:      Tour pointer not remembing closed state. 

## 4.0.1
* New:        Initial public beta release.

## 4.0.0.22
* Added:    `allow_empty_line_height` arg for the typography field to prevent font-size from overriding a blank line-height field.

## 4.0.0.21
* Fixed:    Editor field not saving.

## 4.0.0.20
* Modified: Continued work for compatibility with the forecoming Redux Pro.
* New:      Global arg `elusive_frontend` to enqueue the internal Elusive Font CSS on the front end.

## 4.0.0.19
* Added:    Metaboxes Lite.  See READ ME & sample config (sample-metabox-config.php).
* Added:    Removed "welcome" screen.  Replaced with 'What is this?' screen that no longer appears on first launch.
* Fixed:    Demo mode actiavtes in Netword Enabled mode.
* Modified: Additional WPCS work.
* Modified: Improved tracking.

## 4.0.0.18
* Added:    Field/section disabling.  See README.

## 4.0.0.17
* Fixed:    Data caching for WordPress data class.

## 4.0.0.16
* Added:    Optional AJAX loading for select2 fields.  See README.
* Disabled: WordPress Data caching.  It's broke.  See issue tracker.

## 4.0.0.15
* Added:    Field sanitzing added.  See README.
* Added:    Sanitizing examples added to sample config.
* Fixed:    Multi text not removing new added boxes until after save.

## 4.0.0.14
* Fixed:    Sections in customizer not rendering properly when customizer is set to false.  Thanks @onurdemir.
* Fixed:    Function in ajax save class bombing when v3 is embedded.  Thanks @danielbarenkamp.

## 4.0.0.13
* Nope.  I'm supersticous!

## 4.0.0.12
* Modified: Core to accept v3 based extensions with deprecation notice.
* Modified: @Torfindel's work on the extension/builder abstract.
* Finished: New Spinner UI, with extra args.

## 4.0.0.11
* Fixed:    Typo in redux.js caused panel to stall.  My bad.  :)
* Updated:  Gulp to version 4 to solve vulnerability issues.
* Modified: Linting of remaining JS files.

## 4.0.0.10
* Modified: redux.js opt_name logic to shim in older versions of metaboxes.
* Updated:  Spinner field mods.  New look.  No more jQuery depricated notices.

## 4.0.0.9
* Fixed:    Import/Export feature not importing.  Damn typesafe decs got me again!!!  Thanks, WPCS.  ;-)
* Modified: Replace wpFileSystemInit in sample-config.php with a more practical solution.  Thanks @Torfindel 

## 4.0.0.8
* Modified: Changed typography update localize handle.  Too generic.  Conflicted with something else.
* Fixed:    Template head structure cause tempalte notice to fail.  Thanks @anikitas.
* Fixed:    Google font update choked over incorrect protocol.
* Fixed:    Required logic was operating backward.  Damn those typesafe operators!
* Fixed:    Redux v3 templates no longer crash v4 panel.
* Modified: Sample config to default settings.  They got all wonky for testing various things.

## 4.0.0.7
* Added:    'sites' to the select field data argument to return blog urls.
* Fixed:    Old extensions that extend to the ReduxFramework class failed to save.
* Fixed:    Extraneous semicolon output in admin notices.
* Fixed:    Redux v4 plugin trips fatal error on activation when v3 is embedded in a project.
* Modified: Moved new functions in Redux_Helpers due to incompatibility with embedded v3.
* Fixed:    Section field malformed when two or more section use together with no indentation.
* Fixed:    CDN loading failed even on success due to typesafe comparison (whoops, my bad) - kp.

## 4.0.0.6 (Welcome Fundraiser participants)
* Fixed:    Admin notices were msflromed due to mis-escaped code.
* Added:    Abstract class for extensions.
* Modified: Last of the JavaScript mods from JSHint and JSCS.  Travis checks will no longer fail.

## 4.0.0.3
* Fixed:    Remove plugins_loaded hook to init plugin.  Broke backward compat with Redux 3.

## 4.0.0.2
* Modified: Sorter 'checkbox' now 'toggle' with UI redesign.  Full backward compatibility in place.
* Added:    Shim for redux localization JS object from 3.x where the optName is not appended.  This broke repeater.

## 4.0.0.1
* Rewrite:  Core.  Now modularized.
* Update:   Select2 v4.0.3
* Added:    Dimension and spacing fields now contain extra and new units.
* Modified: The field 'validate' argument now supports an array of values.
* Updated:  Removed 'color_rgba' validation.  'color' validation now supports and sanitizes all color fields.
* Added:    New global arg 'admin_theme'.  The Redux Pro UI now mimics the WordPress menu system in terms of theme colors and behaviour.  Set this arg to 'classic' to use the old Redux UI.
* Fixed:    Tracking opt-in and newsletters popups now appear due to malformed inline javascript.
* Added:    Redux::disable_demo to the Redux API to disable the demo mode.  No more actions hooks.
* Added:    Redux::instance($opt_name) to the Redux API to obtain an instance of Redux based on the opt_name argument.
* Added:    Redux::get_all_instances() to the Redux API to return an array of all available Redux instances with the opt_name as they key.
* Modified: All outputting variables fully escaped to comply with wp.org and themeforest standards.
