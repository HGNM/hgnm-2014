# Changelog

### v1.8.0
* Add update check functionality: enables WordPress to check against GitHub repository for more recent versions

### v1.7.2
* Rewrite `assign_menu_location()`, closing #5.
* Fix bug in `my_dtstart_orderby()` that blocked WP customizer.

### v1.7.1
* Add top padding to `.site-header`, as requested in #2.

### v1.7.0
* Try to assign menu location in `function.php` (failing) :warning:
* Set ACF field groups from `functions.php` rather than via GUI
* Create [npm](https://npmjs.com/) `package.json` & build/watch scripts to process `scss/style.scss`, using `npm start` :tada:
* Update `@font-face` CSS with latest code from [Commercial Type](https://commercialtype.com/)
* Document development environment in README
* Move changelog from README to dedicated file

### v1.6.0
* Fix for compatibility with Advanced Custom Fields 5.3.x in single-concert.php
* Set blending mode to “multiply” for colloquium & composer page featured images

### v1.5.0
* Added 404 error page

### v1.4.3
* Quickfix for miscellaneous event display (on front page & upcoming events) that didn’t take end dates into account

### v1.4.2
* Quick fix for missing bottom margin on list items listing miscellaneous events

### v1.4.1
* Quick fix for missing bullets on `<ul>` items in description texts (composer bios, concert & miscellaneous event posts)

### v1.4.0
* If a concert description and poster (as image file) exist, now displays the poster alongside description text on concert posts
* Now sets default medium image size (300 x 550px) on theme activation to suit styling of the poster — N.B. requires [regeneration of images](https://wordpress.org/plugins/regenerate-thumbnails/)
* Switched footer divider from pipe to bullet

### v1.3.0
* Customised wp-login.php appearance
* Added file type and size meta information to related documents display on concert posts

### v1.2.1
* Quick fix for multimedia section on individual composer pages. Now floats around sidebar correctly.

### v1.2.0
* Added audio & video to individual composer pages
* Improved `<title>` tags for individual concert and colloquium pages
* Tidied up microformat tagging
* Fixed missing bottom margin on miscellaneous event sections

### v1.1.0
* Added styling for blockquotes
* Added favicons

### v1.0.0

**First full production release.**

* Minimized style.css
* Tweaked miscellaneous styling and generic copy
* Added colloquium flyer field for single colloquium pages
* Restricted contact form width on larger screens and tweaked styling

### v0.7-beta.0
* Added bundled fallback profile images that are called on member archive pages when no member photo exists
* Added styling for contact form (Grunion, via plugin)
* Added Facebook page link to home page
* Switched colloquium location map to Google Maps
* Display map in a lightbox on large screens
* Added location marker icon to icon font (for map links)

### v0.6-beta.0
* Added support indications to single concert pages
* Added custom titling for custom archive types
* Styling tweaks

### v0.5-beta.1
* Bug fix: sortable columns query alteration triggering on post edit pages

### v0.5-beta.0
* Added custom post types to ‘At a Glance’ dashboard module
* Added web-font support for Dala Floda (bold)
 * N.B. font files are ignored by git — need adding separately

### v0.4-beta.0
* Added theme preview screenshot
* Fixed missing echo function on upcoming event link

### v0.3-beta.1
* Fix for missing semi-colon breaking composers archive

### v0.3-beta.0
* Added fallbacks for member and event archives for when no content exists
* Minor fixes

### v0.2-beta.0
* Deleted redundant files
* Removed script calls used in dev testing
* Hid comments section from admin menu
* Added core options set-up on theme load
* Added custom, sortable date-start column on event admin pages

### v0.1-beta.0

**Initial theme release for implementation testing.**

#### Functionality

* Sets up custom post types (members, concerts, colloquia, misc. events)
* Creates archives that show group members, past events and future events
* Creates home page with upcoming events & current members list
* Fully styled
