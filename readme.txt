=== Microthemer Lite ===

Contributors: bastywebb, joseluiscruz, ahrale
Donate link: http://themeover.com/microthemer/
Tags: customize theme, visual design tool, css plugin, learn responsive design, SCSS code editor
Requires at least: 3.6
Tested up to: 4.7.4
Stable tag: 5.0.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A visual theme editor for responsively customizing the appearance of any WordPress theme or plugin, with or without writing code.

== Description ==

Microthemer is a feature-rich visual design plugin for responsively customizing the appearance of any WordPress theme or plugin content (e.g. contact forms), down to the smallest detail. This free version limits you styling 15 things. To unlock the full program, you can purchase a <a href="http://themeover.com/microthemer/" target="_blank">Standard</a> ($45) or <a href="http://themeover.com/microthemer/" target="_blank">Developer</a> ($90) license with **free updates for life**. Microthemer caters for both coders and non-coders.

= Main Features (for all users) =

1. **Style anything** on your web page, including headers, menus, sidebars footers, and plugin content.
2. **Intuitive visual editing**.
3. **Over 80 style options** at your disposal (e.g. Google Web Fonts, background color, font-family, CSS3 gradients, drop shadow etc).
4. **Design responsively** without the usual headaches. Preview your site at different screen sizes and apply *media queries styles* without writing code.
5. **Export your designs** as a zip file. For sharing with friends, or transferring between domains.
6. **In-program docs** so you can learn about CSS, or refresh your memory.
7. **History feature**, so you can go back if you make a mistake.
8. **Draft mode**, so you can try new designs on a live site without affecting what visitors see until you're ready to publish.
9. **Apply styles per-page or globally**.
10. **Apply :hover states** an any other pseudo selector like :nth-child() without having to remember the syntax.
11. **Advanced color picker** for sampling colors from your theme and creating custom palettes.
12. **Import CSS** media queries, selectors, and styles from any stylesheet into Microthemer's GUI.
13. **Light-weight**. Microthemer generates CSS. It doesn't try to do much more than that.
14. **Nonce security** to help keep things secure.
15. **Supports multi-site**.
16. **Supports SSL sites**.
17. **Great support** provided via <a title="Microthemer Support Forum" href="http://themeover.com/forum/" target="_blank">our dedicated Microthemer forum</a>.
18. Free <a title="HTML, CSS Layout & Responsive Design - Using WordPress & Microthemer" href="https://themeover.com/html-css-responsive-design-wordpress-microthemer/" target="_blank">CSS, HTML, and responsive design tutorial</a>.


= Main Features for developers =

1. **Full code editor** that lets you write code in the browser while looking at the page.
2. **Hybrid GUI code editor** if you want to leverage the power of the GUI but prefer writing CSS properties and values by hand.
3. **SCSS, CSS, and JS** supported.
4. **Enqueue JS libraries** native to WordPress like jQuery UI for rapid experimentation.
5. **Minify CSS** code.
6. **HTML and CSS inspection**, similar to browser inspectors.
7. **Keyboard shortcuts** for common actions.
8. **Validation** of custom selectors with visual feedback as you type.
9. **Hide from clients** by uninstalling or deactivating, but still use the CSS Microthemer generates by copying and pasting a few lines of PHP code to your theme's functions.php file.

= 10 minute demo (pending update for version 5) =

https://www.youtube.com/watch?v=FNEx-q5wQzI


== Installation ==

1. Upload `microthemer` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to The Microthemer Menu item on the left
4. Tip: you may want to set the visual view to load by default on the Preferences page (most people don't use the Standard View anymore).
   

== Frequently Asked Questions ==

= Is This Plugin Supported? =
Yes. Please post your question in <a title="Microthemer Support Forum" href="http://themeover.com/forum/" target="_blank">our Microthemer forum</a>.  

= Where can I find documentation? =
Microthemer has built-in documentation! Just click the help icon (top right of the interface) to load the tutorials and CSS Reference. You can also search and post questions in our forum from there without having to leave the Microthemer interface.


== Screenshots ==

1. Microthemer’s intuitive interface sits above your site to make it easy to see the changes as you make them.
2. To start editing simply double click anything on the page. Or click the 'Target' button to enable 'hover targeting'.
3. Microthemer comes with over 80 CSS styling properties grouped into eleven categories. In this screenshot we can see border options, such as color, width, radius and style.
4. The main menu allows you organise and manage your folders and selectors. You can simply drag and drop them into the required position, as well as copy, edit, or delete. 
5. Microthemer includes a revision restore feature. The past 50 actions that alter your workspace are remembered. So if you make a mistake you can easily roll back to a previous point.
6. The advanced selector wizard options show you the computed CSS for anything you double-click, just like right-click with browser inspectors.
7. The advanced targeting options includes a list of potential selectors from the very specific to the very broad. Microthemer understands that sometimes users want to target a set of elements, such as all list items titles, as well as just single elements.
8. Easily preview your site as if you were viewing it on phone or tablet as you design and apply screen width specific styles to make your theme fully responsive.
9. You can view the CSS code Microthemer generates for debugging or copying and pasting elsewhere. Some users like the fact you can deactivate Microthemer and still make the use of the styles (without having to copy and paste CSS).


== Upgrade Notice ==
This is an exciting update. Version 5 focusing on better targeting options, with a host of other improvements.

== Changelog ==

= 5.0.0.2 (May 13th, 2017) =

# Enhancement
* Sped up the selection/deselection of elements in basic targeting mode (and in advanced view when 'Styles' tab is not active).
* Added more :nth() pseudo selector recipes to the suggestions menu.
* Using the up/down arrow on style option menus instantly applies the value. This also works on the :nth() pseudo selector suggestions, where it's particularly useful for visually exploring what's possible.
* The color picker defaults to full rgba opacity, even if the computed value for color is 'transparent', which it often is.

# Bugs fixed
* 2nd attempt at fixing @mrover's issue - PHP syntax error: unexpected '[';
* Suggested pseudo selector e.g. :nth-child(n+2) was not working due to presence of plus (+) sign.
* Applying an :nth() pseudo selector suggestion reset the targeting to the default selector that only targets one element.
* 'No element' was shown in the targeting field if enabled pseudo selectors caused MT to only produce selectors that target nothing. Now the pseudo selectors are shown (even in the basic view), and the CSS modifier icon goes orange.
* Removing pseudo modifiers that caused no elements to be targeted didn't restore normality immediately (under specific conditions).

= 5.0.0.1 Beta (May 11th, 2017) =

# Enhancement
* Color picker has palettes for sampling site colors, saving colors, and showing the last 11 colors used.
* Made some presentational changes to the folders & selectors menu. Including a new icon for sorting the order of selectors.
* Made CSS selector updating via the folders and selectors menu more congruent with the new code/label sync system in the selector wizard.
* Added a new icon to the selector actions (in the main and quick edit menus) for re-targeting an existing selector using the selector wizard.

# Change
* Changed keyboard shortcut for toggling targeting mode to: Ctrl+Alt+T. 'T' used instead of 'I', because we're calling it 'targeting mode' instead of 'inspection mode'.
* Removed the prev/next selector nav arrows from top toolbar. Happy to return these if they were popular, but maybe to the right of the selector name in the top toolbar.
* Toggle for targeting mode now says 'Target' to make it more obvious.
* WP admin toolbar on frontend can be targeted/styled too (not the admin interface yet though).
* Feathers, to indicate styles present on folder/selector/tab/property group, have become blue dots.
* Targeting mode does not persist across page refresh. You must click the targeting button again if you wish to return to that mode.
* 'Settings saved' message shows after each save, to reassure users that auto-save is happening.
* Double-click launches targeting mode AND selects the element that was double-clicked. This is like the classic double-click functionality. But single-clicking AFTER the double-click will unselect the element, and hover targeting will be enabled.
* PHP4 constructor replaced with PHP 5+ constructor on JSON class.

# Bugs fixed
* Add first and last classes to WP menu feature does so in a better way. This should fix conflict with Max mega menu.
* border-color shorthand property wasn't being imported correctly, when importing CSS values from a stylesheet.
* nth-type pseudo selectors inout field didn't display useful suggestions.
* When expanding the advanced targeting options, the HTML preview didn't default to the current element. And the breadcrumbs didn't display properly (with drag ability).
* Reordered selectors needed an extra save for the order to be retained on the next page load under some conditions.

= 5.0 Beta (April 13th, 2017) =

# Enhancement
* Microthemer can import selectors and styles from a CSS stylesheet or arbitrarily pasted CSS code.
* Microthemer automatically names selectors for quicker targeting.
* Selector labels can be synced with the actual CSS targeting code (useful for devs that glean more meaning from actual CSS selectors).
* Microthemer now uses hover-then-click targeting over double-click. Although double-click can still be used to toggle targeting mode on or off. So too can the keyboard shortcut: Ctrl+Alt+I.
* Quick create / navigate buttons appear on the page in hover mode for instant selector creation or relocating a previously created selector visually.
* An updated selector suggestion algorithm scans HTML code more extensively, but prioritises only a handful of selectors based on which selectors target a unique set of elements on the page (e.g. 1, 3, 8 etc). Equivalent suggestions are available via a dropdown menu. Also, Microthemer always finds (and defaults to) a selector that targets the single element you click, by using :nth-of-type() if no ids or classes will do the job.
* The selector wizard options have been split into basic and advanced. The basic view allows for more screen space, while the advanced view provides functionality offered by native browser inspectors: HTML/CSS inspection. They are not just for reporting. Microthemer will suggest selectors based on which lines of HTML, or dom breadcrumb you click.
* Microthemer provides instant validation of how many elements your selector targets when customizing a suggestion in the selector wizard (either in basic view with code synced selector label, or in the targeting pane of the advanced options).
* Microthemer provides a list of pseudo selectors/elements that can be applied to the auto-generated CSS selectors. There is also an option for prefixing selectors with a page-id, so styles can easily be applied to a single page.
* Added keyboard shortcut to trigger selector highlight: Ctrl+Alt+h (Windows) or Command+alt+h (Mac).
* Updated PHP SCSS compiler.
* Added JS Libraries dialog for enqueuing native WordPress JavaScripts.
* Allowed Command for Ctrl+S keyboard shortcut on Macs.
* Added quick toggle for full code editor under MT logo.
* Code editors can be drag resized if this preference is set via the option to the left of the code editor.
* Code editors can be searched with Ctrl+F.
* Microthemer supports multiple border radius values per corner e.g. border-top-left-radius: 1em 5em;
* Microthemer saves settings a bit faster. But the big speed improvements are yet to come!

# Change
* The selector wizard appears horizontally at the top rather than to the right. This is so the current screen width is not disturbed, which can lead to incidentally triggering media query styles.
* .input-wrap classes to .tvr-input-wrap in MT interface to prevent conflict with TK Google Fonts plugin.
* Browser native scroll bars are used for scrolling (faster).
* Hover tooltips no longer have a pointer as this could often break.
* When importing scss with @import at the top of the custom code editor, the starting directory is /wp-content/micro-themes/. So if importing a scss file located in your theme directory, the import path you add in MT would be @import '../themes/[your-theme-name]/scss/file.scss'
* Fully removed auto-capitalization behaviour on selector names etc.

# Bugs fixed
* Navigating from a WordPress Post/Page preview to Microthemer caused issues. Unpublished previews cannot be loaded in Microthemer properly. Also, there was a issue with URLs getting double // in the path, which triggered 'Something's wrong' message.
* Unlocking with email addresses that contained a "+" character failed.
* Fixed conflict with Uber menu not opening on mobile.
* Fixed issue with IE stylesheets being called after main Microthemer stylesheet under some circumstances.
* Style-indicating feathers update properly when moving selectors between folders.
* Wizard's computed CSS no longer lists custom CSS as a property.
* Fixed tab alignment of certain properties in active-styles.css
* Updated in_array() JS function to use === false as returned key can be zero.

= 4.9.7.8 (Feb 7th, 2017) =
* After fixing the display of the admin bar preferences, a further fix was needed to make them work correctly, including for non-administrators who are always denied access to the MT interface.

= 4.9.7.7 (Feb 6th, 2017) =
* Fixed bug with both MT admin bar preferences showing as 'Yes' and 'No' when trying to set them to 'No'.

= 4.9.7.6 (July 15th, 2016) =
* Enhancement: Added support for custom JavaScript for full frontend editing. See new tab in custom code area.

* Change: When SCSS and minification is enabled, MT also shows unminified compiled CSS file.
* After exporting, Microthemer loads the manage packs dialog instead of simply closing the export dialog.
* Frontend toolbar displays by default in MT site preview. This can still be hidden via the preferences.

* Bugs fixed: IE specific stylesheets can be used in draft mode too.
* Inactive code loads IE stylesheets too if necessary.
* Under some circumstances IE specific stylesheets editors could get cleared when switching between different IE specific editors.
* Replaced special &raquo; arrow character with regular >> characters in active-styles.css CSS comments (as char encoding issues could invalidate the CSS code).

= 4.9.7.1 (July 10th, 2016) =
* Added support for custom JavaScript!
* IE specific stylesheets can be used in draft mode too.
* Under some circumstances IE specific stylesheets editors could get cleared when switching between different IE specific editors.

= 4.9.6.8 (July 8th, 2016) =
* Added missing snippets to ACE code editor and removed previous version of ACE.

= 4.9.6.7 (July 7th, 2016) =
* Change: Updated the getting started video.
* UTF-8 enforced for custom editor character encoding.

* Enhancement: Reduced the number of translated JS text strings output in the head of the preview iframe.
* Added a temporary icon for indicating common device preview feature at top left of rulers, better icon to follow.
* Servers running PHP 5.4 or newer will load the latest version of scssphp, which requires PHP 5.4. Older versions of PHP will continue to load the older version of scssphp, which doesn't support the very latest SCSS syntax but works for most purposes.

* Bugs fixed: Exit to frontend menu link didn't work if clicked on first visit to Microthemer's interface.
* 'Microthemer' link appears in the WP toolbar immediately after installing (with no need to visit MT interface once).
* Layout issues for preferences form fields on smaller screens.
* Manually setting !important for various CSS3 properties didn't work, including border radius, gradients, text-shadow, and box-shadow.
* On the manage packs page a blank (uneditable) pack could be created under some circumstances.

= 4.9.5.7 (July 5th, 2016) =
* UTF-8 enforced for custom editor character encoding.
* Fixed layout issues for preferences form fields on smaller screens.
* Added a temporary icon for indicating common device preview feature at top left of rulers, better icon to follow.

= 4.9.5.4 (July 1st, 2016) =
* Export button didn't work as a result of 4.9.5.3 update earlier today.

= 4.9.5.3 (June 29th, 2016) =
* Entering rgba values in the new embedded custom code editor caused issues.
* Single and double quotes were rendering as their character codes in the custom code editors (e.g. &quot;).

= 4.9.5.1 (June 21th, 2016) =
* Renaming folders or selectors caused problems for new GUI embedded code editor.
* Deleting forward in the new GUI code area could delete what should be read-only code.
* Highlighting and dragging text has been disabled in gui editor for the same reason.
* Selecting a mixture of read-only and editable lines and then deleting could remove what should be read-only lines too.

= 4.9.4.7 (June 18th, 2016) =
* Minification isn't turned on by default. This may be a temporary measure.
* Removed deprecated get_currentuserinfo() function.
* Nested SCSS selectors didn't work in new GUI code editor.
* The new CSS minification PHP script uses syntax introduced in PHP 5.3. So PHP version 5.3 is required to make use of this new minification feature. Microthemer now inserts a note about upgrading PHP at the top of min.active-styles.css rather than breaking on servers running older versions of PHP.

= 4.9.4.3  (June 17th, 2016) =
* Some of the general preferences have been moved to a new 'SCSS/CSS' tab, which replaces the 'CSS Units' tab.
* Added support for draft mode.
* Added support for SCSS in custom code editor.
* Added support for CSS minification.
* Optional dark theme available for custom code editor.
* Custom code can be added to GUI selectors via the <> code icon at the start of the property group icons.
* View generated CSS now displayed with syntax highlighting and tabs for SCSS/CSS/Minified.
* 'Edit with Microthemer' option in frontend WP toolbar now loads last frontend page viewed in site preview.
* New menu at top right with labels and toggle switches.
* New menu: option to manually set preview url (replaces option in preferences window).
* New menu: quick links to demo video, responsive tutorial, and forum.
* New menu: exit link to frontend as well as WP dashboard.

= 4.9.3.1  (April 22nd, 2016) =
* New internal CSS reference with links to dedicated tutorials for most CSS properties.

= 4.9.3.0  (April 12th (pm), 2016) =
* Major translation updates rolled back. Small update included to make Spanish and Hebrew translations work better.

= 4.9.2.9  (April 12th, 2016) =
* The 4.9.2.7/8 update to the translation system yesterday caused more problems that it solved. This release addresses that.

= 4.9.2.8  (April 11th (pm), 2016 =
* On new installs of Microthemer, the responsive tabs didn't auto-adjust the preview screen width.

= 4.9.2.7  (April 11th, 2016) =
* Resizing the height of the custom code editor is now smooth and quick. More improvements on the way there.
* When restoring settings, new responsive tabs are added to the interface if they are needed to display the settings correctly - the same thing that already happens when importing settings.
* Translated versions of Microthemer didn't load properly, amd import with merge didn't work.
* Site preview could have an extra top margin on screen sizes below 767px. This was due to the margins WordPress applies when it is expecting to show an admin bar on the frontend.
* Disabling a folder didn't have the desired effect for responsive tabs (these styles were not disabled).
* Clearing a folder, selector, tab, or property group didn't disable any chain icons for syncing related fields.
* Import with merge option - responsive style could overwrite instead of merging if importing a pack from a different installation (with different keys for the same media query). Importing and merge has been troublesome in version 4. This final problem prompted a very thorough audit of data management, resulting in many fixes that improve the stability of the import/export features.
* Responsive tab values could be output to the active-style.css stylesheet in the wrong order i.e. not reflecting the order of the folders and selectors in the UI.
* When selectively exporting a folder, extra responsive tab styles from unchecked folders could end up in the export as junk data. These styles would not show in the UI however, and would be discarded without causing issues on the first save after importing. Cleaner to remove them nonetheless.
* When new media query tabs were auto-added to the interface (e.g. after an import), they didn't adjust the preview screen width like they should (unless the media queries were subsequently saved via the 'Edit media queries' popup).
* Tab feathers that indicate if the tab has any styles didn't always update correctly after adding/removing a single style.
* Auto-save didn't trigger after copying a folder or selector. This meant the copy action wasn't added to the history table.
* If the last viewed media query is deleted, Microthemer defaults to the 'All Devices' tab (rather than no tab being selected).
* Removed legacy PHP conditions for microloader.

= 4.9.1.3  (March 31st, 2016) =
* When creating a new selector, Microthemer defaults to the last used property group (e.g. Shadow) rather than Font.
* Using the 'Content' CSS property triggered a JavaScript error.

= 4.9.1.1 (March 27th (pm), 2016) =
* Feather icons that signal the presence of styles were not updating when using the clear option for folders, selectors, tabs, or property groups.

= 4.9.1.0  (March 27th, 2016) =
* Memory limit check to handle GB unit better introduced a different problem for other users.

= 4.9.0.9 (March 26th, 2016) =
* Export dialog was using the similar import icon.
* Memory limit check handles reported memory in GB unit better.
* 4.9.0.5 introduced a bug with the device preview feature at the top left of the rulers. Screen width was not adjusted.
* When clicking a previously clicked option in the device preview, thus unselecting it, the screen width does not reset to the current tab. The user is still hovering over the device option, and so the hover preview functionality should remain.

= 4.9.0.5  (March 23rd, 2016) =
* Renamed some JS files.
* For Firefox, Microthemer must display the preview at 0.3 pixels less than the max-width set in a media query. So if the media query defines a max-width of 979px. Microthemer must set the preview width to 918.7px. This has been the case for a while. But now Chrome requires this same hack.
* Also, under some circumstances the .3px hack was not applied when switching between tabs.

= 4.9.0.2  (March 10th (eve), 2016) =
* Computed CSS hover tip could display unintentionally if the user's mouse moved over the trigger and then rested where the tip appears. The half second delay was not having the desired effect of keeping tips away when they're not needed. This could be annoying when trying to use the ruler and accidentally triggering tips.

= 4.9.0.1 (March 10th - pm, 2016) =
* MAJOR BUG: when importing data that includes new media queries, the new queries were imported but not the styles added to them.

= 4.9.0 (March 10th, 2016) =
* Added selector highlight icons for hover preview. Having that functionality accidentally trigger on selector names in the main menu was annoying.
* Increased free trial selector limit from 9 to 15.
* The computed CSS tooltip for individual properties has changed. It is now a quick-options menu that may display other things like the mixed computed CSS table (which could display unintentionally previously). Also, accessing the CSS reference for the property is now triggered by clicking the property name in the quick options menu.
* 'Check All' checkbox on export dialog is not checked by default. So on first click, it checks all rather than unchecks all.
* Removed WP 2.x compatibility functions.
* Microthemer revision restore now provides more precise information about the save point.
* Folders, selectors, responsive tabs, and property groups can be disabled using an icon. For tabs and property groups, hover over the tab/label (e.g. All Devices/PADDING).
* Folders, selectors, responsive tabs, and property groups can also be cleared of styles using the clear icon.
* Switching on the chain icon next to related fields (e.g. padding) synchronises their values. Double-clicking a field synchronise values still works (although this won't work on border color, which uses a color picker).
* Minor improvements to the sortability of folders and selectors.
* Tooltips either say 'add' or 'remove' rather than add/remove, and update dynamically.
* Imported media queries used raw media query code for label.
* Internal server error in preview when WordPress has it's own sub-directory.
* Double-clicking related fields (e.g. all padding fields) to set them all to the same value could overwrite values on a separate media query tab.
* If highlighting was turned on then off using the icon in the top right, it would come back on after adjusting the screen size (e.g. using the ruler or clicking a tab).

= 4.7.5 (Jan 16th, 2015) =
* LazyLoad given own name space tvrLazyLoad in order to reduce the chance of conflict with other scripts using lazy load.

= 4.7.4 (Jan 15th, 2015) =
* Formatting of 'Update your jQuery' message.
* Fixed erroneous memory limit message by accommodating -1 as a return value.
* Media query sets were repeated in dropdown on main UI (not standalone preferences page).

= 4.7.1 (Dec 11th, 2015) =
* Microthemer now works well with Autoptimize even with CSS minification and concatenation enabled.
* Import and merge appends numbers to imported folders that have the same name (like it did before we made some internationalisation improvements to the folders).
* Folder quick edit and main menu popdowns don't auto-close after manually adding/editing a selector. Nicer when updating multiple selectors. The single selector quick edit popdown still auto-closes.
* Main menu and quick edit popdowns provide more room for editing folders and selectors (up to the full height of the screen).
* Background position/size fields can have default units set, including auto-conversion (e.g. px to em).
* Background color no longer overrides gradient if both are specified alongside a background image. The stacking order is background (top) image, gradient (middle), background color (bottom).

= 4.6.4 (Nov 18th, 2015) =
* Microthemer detects when an error (e.g. plugin/theme conflict) is preventing it from completing an action and provides self-help tips.
* CSS units could not all be set in one go on the standalone preferences page.
* The name of the last modified pack on the manage packs popup wasn't being output.
* Clicking the scrollbars when quick editing a folder or selector closed the quick edit pop-down.
* Clicking a tab row but missing an actual tab loaded blank content.
* 4.5.6 bug fix didn't deal with stripslashes() removing \ chars effectively. This has been addressed more thoroughly now. If Microthemer generated unwanted \ characters in the last 2 weeks, please delete them. They won't come back now.

= 4.5.9 (Nov 2nd, 2015) =
* Microthemer appends a number to active-styles.css?mts=1 relating to the number of saves. This ensures site visitors don't get an out-dated cached version of active-styles.css. They always see what you see in the preview.
* Easier to apply CSS default unit sets, more options available.
* Cleaned up some minor debug output displayed in browser consoles.

= 4.5.6 (Oct 28th 2015) =
* stripslashes() function was used twice in active-styles.css which removed legitimate backslashes (\) needed for things like Font Awesome.
* New CSS property 'Content' added to behaviour group (pending icon).
* Plain numeric values were not being converted to pixels behind the scenes if 'px (implicit)' wasn't selected as the default CSS unit (a unitless number is only valid CSS for line-height). This caused problems when switching between different default units.
* CSS unit sets were not available on the standalone preferences page.
* There is no restriction on the format of folder names (non-alphanumeric chars will not be stripped out).
* New tab on the preferences for language settings.
* Auto-capitalizing folder, selector and design pack names can be turned off on language settings tab.
* CSS syntax for properties can be shown in the tooltips in addition to the label e.g. Tamaño de tipografía / font-size (useful for non-English versions).
* The default folder names have been internationalised.

= 4.4.7 (Oct 2nd, 2015) =
* Re-added the preferences save button to the standalone preferences page.
* Final internationalisation bug fixes.

= 4.4.6 (Sept 29th, 2015) =
* Re-added the preferences save button to the standalone preferences page.

= 4.4.5 (Sept 28th, 2015) =
* Textareas are used for editing media query code instead on single line input fields.
* The selector description disappeared when trying to edit it.

= 4.4.3 (Sept 25th, 2015) =
* Only icons that switch the popup view are shown in the footer of popups.
* Removed extra inline save button for preferences, import, and export popups leaving just one action button at the bottom right of the popups.
* Support for 'px to rem' auto-conversion.
* A new 'Inactive' tab has been added to the preferences. Specify options relating to data deletion upon uninstall, and get code for using Microthemer styles when deactivated/uninstalled here. The code snippet can be pasted into your theme's functions.php file.
* No notification was shown when unlocking Microthemer (success or failure) following 4.2.8 update at the end of August.
* The export notification contained unnecessary dev notices which obscured the main notice: export success.
* Both 'Yes' and 'No' radio buttons were checked when choosing to overwrite current media queries with a set (instead of just the 'Yes' radio button).
* Setting a Google font worked the first time, but then updating it didn't work (live).

= 4.3.5 (Sept 18th, 2015) =
* MAJOR BUG: Under some circumstances, responsive settings could get lost when importing a design pack to a different WordPress install, or if the media queries were manually edited in between the export and import. This happened because the responsive tab index keys could become out of sync.
* Clicking to the right of the selector wizard tabs would result in Microthemer switching to a blank tab.
* Import/export fields resized down when they gained focus, this was unintentional.
* The Hebrew translation of Microthemer didn't save preferences properly and showed English labels for CSS properties.

= 4.3.1 (Sept 15th, 2015) =
* The responsive tabs didn't resize the preview screen when no selectors existed in the interface.

= 4.3.0 (Sept 4th, 2015) =
* Box-shadow blur wasn't given a pixel unit if set to implicit pixels. This could prevent box-shadow from working properly.
* The selector wizard folder field shrunk when it gained focus like the input fields.

= 4.2.8 (Aug 26th, 2015)=
* The input fields for text-shadow and box-shadow have been reordered to reflect the current order defined in the CSS specs. Also, additional properties 'spread' and 'inset' have been added to the box-shadow fields.
* Text-shadow no longer defaults to a grey color (#CCC) if no color is specified. The specs say that the value of color (font color) should be used if no color is specified for text-shadow. Microthemer allows this behaviour now.
* Unnecessary error message about not being able to create the revisions table on new installs.
* The 'Error saving settings' message was a bit scrambled as a result of improper internationalisation. Also, the error reports folder went missing.
* Text or box shadow reported CSS was messed up. Internet explorer reported styles in the wrong place, and RGBA values for shadow color caused problems.
* All CSS properties now have a description in the CSS reference.
* Input fields grow as you type.
* Excel-like formulas can be used in style fields for auto converting pixels to percentages or ems. Enter =%(200) into the width field (for instance) and Microthemer will calculate 200 pixels as a percentage of the parent element's width. You can also use =em(36, 2). If the font-size context was 12, Microthemer would convert this to 3em. The extra '2' parameter is optional. If specified, the context of the nth element would be used if the selector matches multiple elements (rather the defaulting to the first element in the selection).
* This auto-conversion behaviour can also be 'turned on' via the default unit options in the preferences. So if you set 'px to em' for padding fields and then enter the number 20, with no unit specified, Microthemer will convert this to 1.25em (assuming the font-size context was 16px). Microthemer's ability to query font-size and parent width contexts makes the auto-convert features extra useful.
* Microthemer reports color values as hex as well as RGB/A.
* Microthemer notifications in the top right can be dismissed.
* The vertical-align property has been added. Finally. It's an infuriating property so I've taken time to explain it's quirks in the CSS reference.
* Added more values to the display property e.g. display:table-cell.
* Improved the notification system in the top right.

= 4.1.4 (Aug 4th, 2015) =
* On multisite, the Microthemer URL in the admin toolbar could be invalid.

= 4.1.3 (July 28th - later on) =
* (Major bug) Zero values for styles (e.g. padding-top:0) were not being redisplayed in the interface. This meant they were easily lost.
* In Firefox (in particular) the tooltips would get stuck and couldn't be cleared under some conditions.
* The highlighting could get stuck too on when auto-closing the quick edit menu (a feature added in the last version 4.1.0)

= 4.1.1 (July 28th - later on) =
* In Firefox (in particular) the tooltips would get stuck and couldn't be cleared under some conditions.

= 4.1.0 (July 28th) =
* Under some circumstances the key for identifying the last used responsive tab could become out of date. This caused a javascript error that prevented the interface from loading properly (spinning wheel of death).
* The main/quick edit menus closes automatically after adding or editing a selector. It feels more inline with user expectation.

= 4.0.8 (July 21st) =
* Landscape dimensions for common phone previews added.
* Fallback added for getting Microthemer's stylesheet when a 3rd party plugin strips out it's id.
* A cap on the number of elements (20) Microthemer will highlight and analyse has been added. This prevents broad selectors applied to pages with large amounts of HTML from overloading the browser.
* Admin bar in the preview can be optionally shown. I discovered a situation where hiding the admin bar with CSS could artificially interfere with the page layout. Also, some users might prefer to make use of the admin bar if it helps their workflow.
* To make the admin bar more useful for those that enable it, Microthemer now follows links to the admin area (rather than warning against it). The difference now is that following an admin link in the preview will direct the whole Microthemer interface to a new page, not just in the preview.
* More auto-saves have been added to the following actions so that leaving the Microthemer interface (potentially by accident) doesn't result in the loss of settings. Auto-save now happens when a folder or selector is: created, deleted, moved, or renamed.
* Setting the shortcut to Microthemer in the admin bar wasn't having an effect on admin pages (only the admin bar on the frontend of the site). Overall it was a bit glitchy.
* The common screen previews at the top left of the rulers were not disappearing properly when hiding the interface with the logo toggle.

= 4.0 (July 12th) =

New Features
* Easier to add responsive styles.
* Improved color picker.
* Pixel rulers on the X and Y axis.
* Quick preview feature for common devices added to top left corner of the rulers
* Ems/rems used in media queries now preview at the correct width on the responsive tabs
* Specify default CSS units e.g. ems, vw, % instead of implicitly defaulting to pixels.
* Full screen mode.
* Collapse or expand the Microthemer interface with the logo.
* Preview selectors when hovering over selector names.

Design Changes
* The left toolbar icons have been moved to the top right of the interface. Some have been grouped together. Related options display on hover.
* The folder and selector management options have been moved to the top left.
* The responsive slider has been replaced by the rulers. Drag the rulers or click on a point to adjust the screen width. Rulers shading shows the scope of the current responsive tab.
* The media query tabs are now above the CSS property groups and are always visible. They can be hidden via the Edit Media Queries popup.
* The selector wizard options all display to the right of the page. The advanced options are always visible. The selector wizard does not replace the normal editing options. It appears above them.
* Little blue or white feather icons are used to indicate when styles have been added to a selector, media query tab, or property group.
* The color picker has been updated. It now supports RGB/A and HSL/A color codes.
* Default computed colors are show by a bottom border on the new color picker field (which is a small square now).

Functional Changes
* Microthemer doesn't use the crosshair mouse icon anymore because this was artificially changing the computed CSS for the mouse cursor property.
* The media query tabs do not lock the screen width slider at a minimum or maximum screen width. The shading shows the scope of the media query conditions. And if the user drags outside the scope of the media query a warning icon is displayed in the top left of the rulers.
* Hovering over the selector's name in the top toolbar temporarily triggers highlighting and auto-scrolls to the right place in the page.
* Continuity has been given precedence. When switching between property groups (e.g. font to padding) the responsive tab never changes. This holds true when switching between selectors. When switching between selectors, Microthemer no longer remembers the property group that was last edited on that selector. It favours continuity and stays on the same property group the previous selector was on.

3.9 Beta Bugs fixed
* Color picker had some annoying glitches when dragging the picker outside the bounds of the box
* Comma separated CSS selectors weren't highlighting properly (only the first in the list would highlight)

= 3.9.2 (beta) (July 1, 2015) =
* A fresh install of the new beta version could cause an Javascript error because the frontend script tried to load a non-existent stylesheet.
* The dynamic javascript wasn't enqueued in the correct way which prevented the interface from fully loading.

= 3.9.0 (beta) (June 26, 2015) =
* Many new updates. A full description will come when we're past the beta stage.

= 3.7.5 (May 24, 2015) =
* Microthemer is now translation ready following JoseLuís' sterling work.
* Added more thorough directory path analysis for advanced WordPress configurations.

= 3.7.3 (May 9, 2015) =
* Plain http requests to Google fonts caused issues on SSL sites.
* Fixed path to languages folder

= 3.7.2 (May 6, 2015) =
* New selector wizard targeting system trialed in edge mode has become permanent
* First phase of translation: various text strings are now translatable. Thanks to JoseLuís for providing this: https://github.com/joseluis/
* Improved compatibility with any font awesome stylesheets that load on the Microthemer UI page (via another plugin)

= 3.6.9 (May 5, 2015) =
* The last 3.6.7 release introduced a bug with the unlock process.

= 3.6.8 (May 4, 2015) =
* Major Bug fixed. When importing with "Merge", any responsive tab settings being imported would be lost. So too would any custom !important declarations.

= 3.6.7 (Apr 23, 2015) =
* Microthemer conflicted with the Contact Form Maker plugin.
* Single or double-clicking form submit buttons didn't work as a result of the 3.5.9 update.
* Microthemer would follow links if they were the parent of a double-clicked grandchild element.
* Microthemer wouldn't allow styling links that lead back to the admin area (this was an unintended consequence of preventing single-click navigation to the admin area).

= 3.6.3 (Apr 20, 2015) =
* The computed CSS appears when hovering over the CSS property LABEL instead of the form field. We think tooltips should get out of the way of input fields. And we think it's neater to show the label and computed value alongside each other e.g. "Font Weight: bold".
* The color picker would not disappear on blur following the last 3.5.9 update (you had to click the close button).
* The styling of selector suggestions on hover poses less confusion about which suggestion is actually selected. They have a grey background on hover and the current selector continues to look like an editable textarea until another one is clicked.
* Information icons appear on hover for the selector wizard suggestions for showing the tooltip without the tooltip getting in the way of the code.

= 3.5.9 (Apr 19, 2015) =
* An 'Edge mode' option has been added to the preferences. You can enable this to try out experimental new features and have your say on them before they become permanent. Useful for those that want to take an active role in shaping Microthemer.
* Custom tooltips have been added to the interface. You can configure these via the preferences.
* Selectors suggestions on the targeting tab have more descriptive explanations and show quickly with the new tooltip.
* The inside label on the folder field of the selector wizard had a glitch
* jQuery version checking could be inaccurate under some circumstances.
* Targeting inputs by type wasn't working
* Microthemer could follow links to plain images and find itself at an impasse.
* Microthemer could follow links to the admin and then possibly back to Microthemer.
* Microthemer now waits for 700ms instead of 300ms for a second click when a user double-clicks something. Some people were naturally double-clicking with less than 300ms between each click. I will make the delay time configurable if people request this.
* The selector targeting tab has a regular scrollbar on the right instead of a vertical slider. Switching between the options is be done by hovering your mouse over them (for quick preview) and then clicking the suggestion you want.
3.5 (Apr 10, 2015)
* jQuery version checking could be inaccurate under some circumstances.

= 3.4.9 (Apr 7, 2015) =
* An undefined index PHP error could show when upgrading from a previous version to version 3.4.4 (when the WP admin shortcut link was added)
* Some undefined errors could be generated on the UI page. These were hidden behind the interface but could result in a slow page load if present.

= 3.4.7 (Apr 4, 2015) =
* Chrome could fail when trying to load the selector wizard if it encountered any computed CSS values with rgba opacity set to more than 2 decimal places e.g. 0.745.
* Double-clicking an already highlighted element closes the selector wizard instead of showing a warning.
* On multi-site, Microthemer creates the micro-themes folder in /wp-content/uploads/sites/ if the blogs.dir directory doesn't already exist (modern multi-site installs don't create the blogs.dir folder).


= 3.4.4 (Apr 3, 2015) =
* Added an option for accessing Microthemer from the WP admin bar. This can be turned off via the preferences page if you don't want it cluttering your admin bar.
* There is an import icon next to each design pack on the Manage & Install design packs page. This takes you to the import page and preselects the right design pack.
* The 'clear styles but leave folders & selectors intact' option didn't clear styles applied on responsive tabs.

= 3.4.1 (Mar 11, 2015) =
* Double-clicking an element with text no longer highlights the actual word clicked, which resulted in confusing highlighting.
* Microthemer initially uses home_url() to load the site preview as site_url() can sometimes be incorrect.
* Possibility of an undefined variable $logs on line 1110 of tvr-microthemer.php
* Possibility of an undefined index disable_parent_css on line 5515 of tvr-microthemer.php

= 3.3.7 (Feb 15, 2015) =
* Folders and selector are APPENDED instead of PRE-PENDED when added to the interface. Rationale: It keeps folders and selectors in the chronological order that they were created, the back and forward quick nav buttons work more intuitively, if two selectors have equal specificity the latter will override the previously created one.
* For consistency, the same goes for custom media queries. They are appended, and the 'NEW' button has been moved below them.
* Only folders that have 1 or more selectors are auto-checked on the settings export screen.
* All folders/selectors/custom media queries would flash for a split second when adding a new item to them.
* There is a known bug in firefox where media queries don't take effect on the exact pixel specified. Styles set within a media query tab didn't always seem to take an effect at 767px for instance when the media query specified a max-width of 767px (as it does on the 'Tablet & Phone' media query). Only at 766.7px do the styles work. For now, I've implemented a fix for this (automatically subtracting 0.3px from the preview screen width). I am following this bug on bugzilla. I will remove the temporary fix when it is no longer necessary.
* Unnecessary console.logs functions for debugging were included in the previous release which could cause problems for IE9.
* The media query tabs can be added by clicking the actual text in the tab management menu (not just the + icon). This feels more natural.
* The folder >> Selector breadcrumbs arrows have the default mouse cursor on hover to indicate that they're not clickable.
* Microthemer would get stuck when deleting the last selector while in 'quick edit folder' view.
* The new 'media query sets' loading feature had some teething problems.
* Using the following CSS pseudo selectors caused problems: :before, ::before, :after, ::after. Thanks again to Antonio for spotting this.
* The screen-width slider didn't show with the selector wizard 100% of the time.
* The computed CSS values for the single double-clicked element were not recalculated following a screen width refresh.

= 3.2.4 (Feb 14, 2015) =
* When saving different styles in quick succession, the latest style change wasn't always saved if a save was already in progress. Now the saves queue up to ensure that the latest setting applies.
* The selector wizard could fail to show if other Javascripts altered the format of the computed CSS data jQuery returned.
* The selector wizard could also fail to show after double-clicking in Chrome under some circumstances.

= 3.2.1 (Feb 10, 2015 - later in the afternoon) =
* The selector wizard displays link :pseudo classes in the correct order (that corresponds to the position of the slider handle)
* An undefined variable could throw a warning with strict error reporting server settings enabled.
* Unnecessary debug output was being generated behind the scenes. And unnecessary source file for a polyfill were included.
* The selector wizard caused the manual 'Add Selector' options to be expanded when they needn't be.
* Manual selector values were not being cleared from the input fields upon 'cancel'

= 3.1.6 (Feb 10, 2015) =
* Microthemer remembers your preference for showing/unshowing the advanced options of the selector wizard. No need for the checkbox now.
* Microthemer remembers which tab of the advanced wizard you last used.
* Microthemer remembers your preference for having the left toolbar expanded or closed.
* Microthemer remembers the last viewed selector when reloading the page, even if you didn't apply styles to it.
* The link back to the WordPress dashboard is a real link so that you can open it in a new tab with right-click.
* The media query tabs editing menu options are more similar to the format used for editing folders and selectors. An additional 'clear' option has been added for clearing all the styles for a style group at once.

= 3.1 (Feb 8, 2015)
* Some alternative media query 'sets' can be loaded. These encourage the use of mobile-first/semantic breakpoints.
* Deleting all media queries will actually reset the default media queries (rather than just purporting to)
* Hovering your mouse over a media query tab shows the underlying media query code.
* The color picker didn't allow RGB or RGBA values if there was a space before the brackets e.g. "RGBA ()".
* Navigating to selector from the main menu or quick edit menus closes the open menu
* The 'Double-click an element to create editing options for it' title attribute is no longer dynamically added to the <body> element of the preview iframe.
* The in-program docs now link to the new online support index page, taking this version out of beta.
* Each CSS property has a direct link to the online CSS reference by clicking the CSS property icon
* Microthemer recalculates and reports the correct computed CSS following actions that change the preview screen width (e.g. adjusting the slider or switching between media query tabs). Thanks for reporting this Rob.
* Selector highlighting is recalculated instantly when a new style is applied that affects the dimensions of the targets element(s). Thanks again to Rob for spotting this.
* Cursor options no longer have a scrollbar in the dropdown menu, which partially obscured the options.

= 3.0.16 (beta) =
* The pre-populated selector name value for all selectors in a folder was overwritten by the most recent selector created via the selector wizard. Thanks for spotting this Antonio!
* Importing a design pack made with Microthemer 1.x (before media query tabs were added) would result in PHP errors.

= 3.0.14 (beta) =
* Improved the icon and description for the media query tab management menu. A few more improvements for this feature are on the way.
* If a media query tab (e.g. "Phone") was used in the absence of the default "All Devices" tab, settings applied to the media query tab would not save.
* When importing 2.x settings, media query tabs did not always display correctly
* Dropdown menu toggle arrows were misaligned by one pixel in Firefox.

= 3.0.11 (beta)
* The appearance of the slider handle for the selector wizard element targeting tab also needed fixing in WP 4.1
* The notification about disabling highlighting when double-clicking something that is already highlighted was confusing.
* In rare cases Microthemer was not remembering the last frontend page viewed in the preview window.

= 3.0.8 (beta) =
* On multi-site, the "back to WordPress dashboard" icon in the left toolbar took the user back to the root admin dashboard instead of the intended blog dashboard.
* With WordPress 4.1 there were a few display issues relating to jQuery UI widgets like sliders and pseudo select comboboxes.
- The preview screen width slider handle was not correctly styled (it was too big).
- The dropdown menus looked a bit ugly and it wasn't possible to specify an empty value to clear the field.
* With jquery versions older than 1.9, a javascript error could prevent the selector wizard from loading when double-clicking an element. Now Microthemer warns you to update jQuery.
* Microthemer was sometimes creating a debug-save.txt file in the root /micro-themes/ folder. This caused a blank design pack to be displayed on the manage design packs page that could not be deleted via the delete button. If you installed version 3.0 and you see a nameless design pack on the manage packs page, please delete the following file via FTP: /wp-content/micro-themes/debug-save.txt (or ask Themeover for help with this).
* Microthemer will not run with versions earlier than 3.6 (it will warn you to upgrade WordPress)
* The reported CSS could sometimes be too big for the input field and looked messy. If there is not enough room the value is truncated with a ... suffix. The full computed CSS value can still be viewed by hovering your mouse over the input field.
* The icons for text-shadow X and Y offset were wrong. "Spread" will be added to these shadow options soon.
* An innocuous javascript error was generated if exporting the first design pack when no others exist.

= 3.0 (beta) =
* Note: this is a beta because it was released without updated documentation
* Much nicer icon-based UI with far more space available for seeing the site your designing and NO overlap of editing options.
* Everything is accessible from the Microthemer UI page (e.g. design pack installation and management, updating global preferences and media queries)
* Much easier management of sections (now called folders) and selectors. You can copy and move selectors between folders with drag and drop too.
* Code editor with syntax highlighting for those that still like to program. You can still see the frontend site while you write your code. Clicking control+S to save means that you see your changes instantly.
* Some new style options (e.g. box-sizing, background-size) with more (animation/transition) options on the way in a later release.
* Background images are now managed via the wordpress media manager. On installing a pack with images, they are extracted to the library and image paths are updated automatically. When you download a pack, linked imaged are downloaded from the image library and included in the zip package. It should make working with background images much easier.
* The selector wizard is now easier to use. It has a slider for tweaking your targeting instead of the dropdown menu. And computed CSS is reported at the wizard stage too. In a later release the HTML inspection will be improved further.
* Import/Export of settings has been improved.
* limits caused by PHP's max_input_vars settings which could cause problems saving your settings if the number of input vars exceeded the limit (typically 1000) is no longer an issue. Microthemer serializes input values into one and then splits them back to normal on the server side.
* background images can have spaces in the names e.g. "my images with spaces.jpg"
* Resetting, importing, and restoring settings used to pass parameters in the URL. Refreshing the page (which some of us do habitually) could cause unwanted old actions (like resetting the interface) to be repeated accidentally. Now all actions are submitted via ajax and the Microthemer URL remains clean at all times.
* Microthemer doesn't set viewport to 1 by default. If you plan to make use of the media query feature please set this to 1 on the media queries management page.
* CSS3 PIE isn't turned on globally by default


= 2.8.2 (Sept 16, 2014 =
* The helps links to the videos, tutorials, and forum were not working on the Preferences or Manage Themes pages.
* Microthemer no longer displays your email address on the unlock page once you have successfully validated your email address.
This is useful if you have purchased a developer license and you do not want your clients to see your email address.
* Also, the free trial notice disappears after unlocking the program.
* The "Free Trial Example Section" is now just called "Example Section" to avoid confusion over whether or not the program is really unlocked after validating your email address.

= 2.7.8 (Sept 8, 2014) =
* Text-shadow colour could not be set to "none" to effectively disable any existing text-shadow values.
* RGB AND RGBA colour values could not be set without Microthemer auto-adjusting them to solid hex values. RGB/RGBA values can now be manually added. The color picker will receive some proper attention in the near future to ensure maximum flexibility and ease of use.
* A call to an undefined javascript function caused an error in the browser console. Although the error didn't seem to disrupt normal functioning of the program.

= 2.7.5 (Sept 1, 2014) =
* The new feature of computing the CSS could slow, and potentially crash the browser. This could happen when analysing high numbers of page elements (e.g. 30 links on the page) combined with lots of properties having mixed values (e.g. a font-size of 12px, 18px, 21px). As A quick fix, we have set the maximum number of elements on the page that can be scanned to 10 (instead of 50). We will increase this figure (to around 30) when we release version 3 in about one month. Version 3 will segment the display of property groups (e.g. just padding or just behaviour) rather than displaying all properties at once and so will be able to analyse more elements on the page without resulting in performance issues.
* Also, related to the above, Microthemer now excludes the WP admin bar from restyling for performance reasons.
* If a selector contained the :link pseudo selector, this wasn't correctly filtered when constructing selector highlighting divs.

= 2.7.3 (Aug 8, 2014) =
* Computed CSS reporting failed if the CSS selector code contained one of the following pseudo selectors - :hover, :active, :visited

= 2.7.2 (Aug 06, 2014) =
* Google font subsets e.g. "subset=latin,latin-ext" can now be set on the Microthemer > Preferences page
* An error occurred when using single or double quotes in selectors e.g. input[type="text"]

= 2.7.1 =
* Microthemer can now be used as a substitute for firebug as a tool for analysing an element's existing computed CSS values. Microthemer now shows the computed values as overlays on the editing options so you can view CSS value reporting and make an edit in exactly the same place.
* Font weight can be applied as a century number from 100 to 900.

* The little "i"s for manually applying the !important CSS declaration got lost for a while.
* When exporting to a theme, it was possible to not select anything from the dropdown menu.
* Custom google font still rendered if the field wasn't cleared before switching back to a regular web safe font in the dropdown.
* Auto-save was a bit sketchy with Google Fonts too
* Microthemer auto-saves when property options are deleted or a selector is modified now to more accurately present the state of things.
* Microthemer now includes the background-color in the CSS3 gradient declaration. It will always be trumped by the gradient but not doing this resulting in incorrect reporting of the background-color property (now that Microthemer reports this information)

= 2.6.3 =
* Style changes appear much quicker now (almost immediately). As such, auto-save is now the default mode (although it can be disabled). Also, auto-save is trggered when you finish typing into text fields (after a 700ms delay, rather than when focus is removed). 
* Microthemer remembers the last page you viewed when you return to the visual view site preview

= 2.6.1.1 =
* Found another call to the missing json class the previous version aimed to fix (2.6.1).

= 2.6.1 =
* When exporting settings to a settings pack, or invoking any function that used the json class, an error message was thrown in WordPress 3.9.

= 2.6.0 =
* Various PHP notices that could display on servers with strict error reporting have been fixed.

= 2.5.8 = 
* E_STRICT PHP error warnings could occur with PHP 5.4 due to code aimed at maintaining compatibility with PHP 4. This code has been removed. PHP 4 is no longer supported.

= 2.5.7 =
* There is now only one important "i" icon next to the last text-shadow input field. This makes much more sense.
* wordpress.org only - a file wasn't checked in which was necessary for the new responsive screen width slider to appear correctly.

= 2.5.6 =
* Media queries could be re-ordered but re-ordering did not have an effect with regards to the order the media queries were written to the active-style.css styleheet.

= 2.5.5 =
* Added a major new responsive design feature to the visual view. Preview the frontend in screen widths that correspond to min and max width values specified in your media queries. Also, you can easily adjust the preview screen size manually user a slider. You still have full editorial control over Microthemers default media queries.
* Some CSS tweaks to further improve the design with WordPress 3.8.
* Under some conditions discarding a media query tab in the style editing options could result in the editing options for the next tab that comes into focus remaining hidden.

= 2.5.2 =
* Various design improvements to ensure compatibility with WordPress 3.8

= 2.5.1 =
* PHP warning error when importing a settings pack that was made before Microthemer introduced media queries. Only affected Microthemer 2.5.

= 2.5 = 
* Major bug with device-specific CSS styles disappearing. Previously saved media query styles were overwritten by new ones if the section or selector was closed. This bug was masked prior to the last release (2.4.7) because sections and selectors remained open unless explicitly closed.
* When importing a theme pack that uses device specific css, the tabs could get messed up it focus wasn't left on 'All-devices'.
* Increased the CSS-specificity of Microthemer's own CSS styles on hidden Elements to ensure normal Javascript functioning too.

= 2.4.7 = 
* Under some conditions saving settings could result in an error. Servers that have a value in php.ini for max_input_vars (usually 1000) would sometimes truncate the data Microthemer sends to the server, resulting in a save error. Microthemer now warns you in advance if you are approaching your data-sending limits and suggest an easy fix - just hit the SpeedUp button in the right-hand menu.
* By default, Microthemer no longer remembers open sections/selectors when you return to the UI page. Doing so increased the likelihood of the data-limit error described above. However, you can adjust this behaviour via a new option on the preferences page.

= 2.4.5 = 
* Four additional Raw CSS Code textareas added for specifically targeting versions of Internet Explorer. Microthemer only includes these additional stylesheets if you make use of the new textareas so no unecessary stylesheets are ever included.

= 2.4.4 = 
* Option added to preferences page to set the viewport zoom level for any device to "1". This is on by default as it is necessary for the media queries to affect mobile and tablet devices correctly.

= 2.4.3 = 
* MAJOR BUG FIXED - Style values of zero (0) were ignored (not written to the CSS stylesheet) in the last version of Microthemer (2.4.1). 

= 2.4.1 = 
* Various bugs relating to media queries and illegal string offsets with PHP 5.4 were fixed

= 2.3.8 = 
* Microthemer now supports media queries for designing responsively

= 2.3.5 = 
* Email validation method now more reliable.
* Google Font variations can now be correctly used (click the variation before clicking the "Use this Font" link)
* Google Font url uses https if necessary to prevent mixed content warnings on SSL sites.

= 2.3.2 = 
- Works with MP6
- Transparency on mouseout can now be configured

= 2.2.9 = 
- Added support for Google Web Fonts - visual font-browser

= 2.2.3 = 
- Custom CSS style properties can now be added to Selectors in the CSS Selector textarea. Microthemer will look for the use of curly braces and include any CSS properties it finds in between the curly braces.

= 2.2.2 = 
The first release of Microthemer Lite on wordpress.org
