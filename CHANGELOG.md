# Change Log

All notable changes to this project will be documented in this file. See [standard-version](https://github.com/conventional-changelog/standard-version) for commit guidelines.

<a name="1.15.0"></a>
# [1.15.0](https://github.com/hgnm/hgnm-2014/compare/v1.14.0...v1.15.0) (2018-12-03)


### Architecture
* Improve component loading, using `include_once` and calling functions by default ([323493d](https://github.com/hgnm/hgnm-2014/commit/323493d))


### Front-end

* **style:** Remove mobile menu button round corners ([3864e56](https://github.com/hgnm/hgnm-2014/commit/3864e56))
* **style:** Break site title nicely on 720–1008px screens ([993b57a](https://github.com/hgnm/hgnm-2014/commit/993b57a))
* **style:** Update “off-white” variable to match shade of background pattern ([827e2ee](https://github.com/hgnm/hgnm-2014/commit/827e2ee))


### Project management

* Use [`@masonite/wp-project-version-sync`](https://github.com/masonitedoors/wp-project-version-sync) to automatically update theme version number in `scss/style.scss` on `npm version` ([dd60743](https://github.com/hgnm/hgnm-2014/commit/dd60743)), closes [#24](https://github.com/hgnm/hgnm-2014/issues/24)
* Use `standard-version` to cut new releases ([03ddf63](https://github.com/hgnm/hgnm-2014/commit/03ddf63))
* Configure package to use `commitizen` and `commitlint` ([d3000c2](https://github.com/hgnm/hgnm-2014/commit/d3000c2), [67b3146](https://github.com/hgnm/hgnm-2014/commit/67b3146))
* Don’t store `style.css` in repo ([9ee084f](https://github.com/hgnm/hgnm-2014/commit/9ee084f))
* Use `sass-lint` to enforce SASS code style ([22ad76a](https://github.com/hgnm/hgnm-2014/commit/22ad76a))
* Improve build scripts ([599ce44](https://github.com/hgnm/hgnm-2014/commit/599ce44), [599ce44](https://github.com/hgnm/hgnm-2014/commit/5f9ca8d))
* Document project subdirectory structure ([739f61d](https://github.com/hgnm/hgnm-2014/commit/739f61d), [4efa811](https://github.com/hgnm/hgnm-2014/commit/4efa811))



<a name="1.14.0"></a>
# [1.14.0](https://github.com/HGNM/hgnm-2014/compare/v1.13.0...v1.14.0) (2018-09-23)


Although visually the theme appears unchanged, this release marks a substantial overhaul of the codebase, refactoring templating and styling to make it more maintainable going forward.

#### Key changes

* Add `functions/component-loader.php` allowing re-usable templates to be called using `component()` (see [Architecture docs](ARCHITECTURE.md#components))
* Write component files and use `component()` to refactor templates and make code less repetitive
* Use `php-cs-fixer` to tidy PHP and make code style consistent
* Write [`ARCHITECTURE.md`](ARCHITECTURE.md), documenting theme structure and functionality
* Refactor `style.scss` to be more maintainable, and use `sass-lint` to enfore consistent code style. (Removing unused or repeated style rules has knocked almost 25% off the output file size.)
* Add PostCSS and Autoprefixer to the build flow to allow CSS vendor prefixes to be handled automatically

For more details [see the commit list on GitHub](https://github.com/HGNM/hgnm-2014/compare/v1.13.0...v1.14.0)



<a name="1.13.0"></a>
# [1.13.0](https://github.com/HGNM/hgnm-2014/compare/v1.12.1...v1.13.0) (2018-09-15)

* Refactor `functions.php` into several large chunks to make it a little easier to understand (c3f90f5)
* Refactor `scss/style.scss` to import SASS variables and normalize.css from partials (1638524, 47091fb)
* Display icons for custom post types in the ‘At a Glance’ dashboard module (861a30f)
* Disable `wp-emoji` (1973e80)
* Remove “Browse Happy” warnings for old versions of IE (37e0361)
* Use `rel="preload"` for fonts and site background image (649a1af)
* Update [Modernizr](https://modernizr.com/) and use as small a build as possible (7f6689c)



<a name="1.12.1"></a>
## [1.12.1](https://github.com/HGNM/hgnm-2014/compare/v1.12.0...v1.12.1) (2018-09-14)

* Fix out-of-sync version tags (`package.json` and git tag vs `style.css`) (7e44c51)



<a name="1.12.0"></a>
# [1.12.0](https://github.com/HGNM/hgnm-2014/compare/v1.11.0...v1.12.0) (2018-09-14)

* Eliminate jQuery use, replacing `magnific-popup` with `baguetteBox.js` (73f038d)
* Set retry options on wget call to download fonts in `install-dependencies.sh` (89feb2a) 



<a name="1.11.0"></a>
# [1.11.0](https://github.com/HGNM/hgnm-2014/compare/v1.10.2...v1.11.0) (2018-09-14)

* Fix media display on composer pages (085c980)
* Fix PHP warnings (2d6bbe7, 2364d69)
* Upgrade dependencies (b17289f)
* Improve colloquium filter on composer pages (cbd9dfa)
* Add `.woff2` version of icon font and tidy up `@font-face` declaration (c9ef1d5, 14a44e5)
* Update README to reflect changes in `hgnm-wp-dev` (2ab0902)
* Clean up miscellaneous whitespace (83f24a2)



<a name="1.10.2"></a>
## [1.10.2](https://github.com/HGNM/hgnm-2014/compare/v1.10.1...v1.10.2) (2017-10-29)

* Use `hgnm-thumb` image size for thumbnails on composers page.



<a name="1.10.1"></a>
## [1.10.1](https://github.com/HGNM/hgnm-2014/compare/v1.10.0...v1.10.1) (2017-09-11)

* 🐛 Fix custom field conditional logic rules for compatibility with ACF Pro update.
* Restore Miscellaneous Event post type instructions custom field.
* Improve custom field registration logic.



<a name="1.10.0"></a>
# [1.10.0](https://github.com/HGNM/hgnm-2014/compare/v1.9.0...v1.10.0) (2017-09-06)

* Removes dependency on Per Søderlind’s [Date & Time Picker field](https://github.com/soderlind/acf-field-date-time-picker) and switches to using the [ACF Pro time picker](https://www.advancedcustomfields.com/resources/time-picker/) (ACF Pro >= `5.3.9`).
* Simplified Travis builds and refreshed deploy token.
* Clean up PHP warnings in `archive-concert.php`, `archive-member.php`,
`header.php`, and `single-member.php`.



<a name="1.9.0"></a>
# [1.9.0](https://github.com/HGNM/hgnm-2014/compare/v1.8.3...v1.9.0) (2017-09-04)

#### 🎉 Back to School 2017
* Update `node-sass` command used in build script to output compressed CSS (#10).
* Consolidate CSS assets by bundling `magnific-popup.css` into main `style.css` on build (#11).
* Update colloquia location:
  - Change `Davison Room` to `Room 6` on front page and events page.
  - Remove location note from archives.
  - Remove room indication on single colloquium pages.
* Update development dependencies:
  - `bestzip`: `^1.1.3` → `^1.1.4`
  - `node-sass`: `^3.7.0` → `^4.5.3`
  - `rimraf`: `^2.5.2` → `^2.6.1`



<a name="1.8.3"></a>
## [1.8.3](https://github.com/HGNM/hgnm-2014/compare/v1.8.2...v1.8.3) (2016-06-11)

* Fix theme directory naming bug (#12).
* Improve build scripts (#9).



<a name="1.8.2"></a>
## [1.8.2](https://github.com/HGNM/hgnm-2014/compare/v1.8.1...v1.8.2) (2016-06-10)

* Switch to Travis-deployed downloads in theme update checker, closing #7.



<a name="1.8.1"></a>
## [1.8.1](https://github.com/HGNM/hgnm-2014/compare/v1.8.0...v1.8.1) (2016-06-10)

* Introduces more extensive build chain.
* Introduces compatibility with Travis CI.



<a name="1.8.0"></a>
# [1.8.0](https://github.com/HGNM/hgnm-2014/compare/v1.7.2...v1.8.0) (2016-06-10)

* Add update check functionality: enables WordPress to check against GitHub repository for more recent versions



<a name="1.7.2"></a>
## [1.7.2](https://github.com/HGNM/hgnm-2014/compare/v1.7.1...v1.7.2) (2016-06-09)

* Rewrite `assign_menu_location()`, closing #5.
* Fix bug in `my_dtstart_orderby()` that blocked WP customizer.



<a name="1.7.1"></a>
## [1.7.1](https://github.com/HGNM/hgnm-2014/compare/v1.7.0...v1.7.1) (2016-06-05)

* Add top padding to `.site-header`, as requested in #2.



<a name="1.7.0"></a>
# [1.7.0](https://github.com/HGNM/hgnm-2014/compare/v1.6.0...v1.7.0) (2016-06-03)

* Try to assign menu location in `function.php` (failing) :warning:
* Set ACF field groups from `functions.php` rather than via GUI
* Create [npm](https://npmjs.com/) `package.json` & build/watch scripts to process `scss/style.scss`, using `npm start` :tada:
* Update `@font-face` CSS with latest code from [Commercial Type](https://commercialtype.com/)
* Document development environment in README
* Move changelog from README to dedicated file



<a name="1.6.0"></a>
# [1.6.0](https://github.com/HGNM/hgnm-2014/compare/v1.5.0...v1.6.0) (2016-01-04)

* Fix for compatibility with Advanced Custom Fields 5.3.x in single-concert.php
* Set blending mode to “multiply” for colloquium & composer page featured images



<a name="1.5.0"></a>
# [1.5.0](https://github.com/HGNM/hgnm-2014/compare/v1.4.3...v1.5.0) (2015-03-09)

* Added 404 error page



<a name="1.4.3"></a>
## [1.4.3](https://github.com/HGNM/hgnm-2014/compare/v1.4.2...v1.4.3) (2015-03-01)

* Quickfix for miscellaneous event display (on front page & upcoming events) that didn’t take end dates into account



<a name="1.4.2"></a>
## [1.4.2](https://github.com/HGNM/hgnm-2014/compare/v1.4.1...v1.4.2) (2015-02-05)

* Quick fix for missing bottom margin on list items listing miscellaneous events



<a name="1.4.1"></a>
## [1.4.1](https://github.com/HGNM/hgnm-2014/compare/v1.4.0...v1.4.1) (2015-02-05)

* Quick fix for missing bullets on `<ul>` items in description texts (composer bios, concert & miscellaneous event posts)



<a name="1.4.0"></a>
# [1.4.0](https://github.com/HGNM/hgnm-2014/compare/v1.3.0...v1.4.0) (2015-01-28)

* If a concert description and poster (as image file) exist, now displays the poster alongside description text on concert posts
* Now sets default medium image size (300 x 550px) on theme activation to suit styling of the poster — N.B. requires [regeneration of images](https://wordpress.org/plugins/regenerate-thumbnails/)
* Switched footer divider from pipe to bullet



<a name="1.3.0"></a>
# [1.3.0](https://github.com/HGNM/hgnm-2014/compare/v1.2.1...v1.3.0) (2015-01-20)

* Customised wp-login.php appearance
* Added file type and size meta information to related documents display on concert posts



<a name="1.2.1"></a>
## [1.2.1](https://github.com/HGNM/hgnm-2014/compare/v1.2.0...v1.2.1) (2015-01-16)

* Quick fix for multimedia section on individual composer pages. Now floats around sidebar correctly.



<a name="1.2.0"></a>
# [1.2.0](https://github.com/HGNM/hgnm-2014/compare/v1.1.0...v1.2.0) (2015-01-16)

* Added audio & video to individual composer pages
* Improved `<title>` tags for individual concert and colloquium pages
* Tidied up microformat tagging
* Fixed missing bottom margin on miscellaneous event sections



<a name="1.1.0"></a>
# [1.1.0](https://github.com/HGNM/hgnm-2014/compare/v1.0.0...v1.1.0) (2014-09-11)

* Added styling for blockquotes
* Added favicons



<a name="1.0.0"></a>
# [1.0.0](https://github.com/HGNM/hgnm-2014/compare/v0.7-beta.0...v1.0.0) (2014-09-10)

**First full production release.**

* Minimized style.css
* Tweaked miscellaneous styling and generic copy
* Added colloquium flyer field for single colloquium pages
* Restricted contact form width on larger screens and tweaked styling



# Beta versions

## 0.7-beta.0
* Added bundled fallback profile images that are called on member archive pages when no member photo exists
* Added styling for contact form (Grunion, via plugin)
* Added Facebook page link to home page
* Switched colloquium location map to Google Maps
* Display map in a lightbox on large screens
* Added location marker icon to icon font (for map links)



## 0.6-beta.0
* Added support indications to single concert pages
* Added custom titling for custom archive types
* Styling tweaks



## 0.5-beta.1
* Bug fix: sortable columns query alteration triggering on post edit pages



## 0.5-beta.0
* Added custom post types to ‘At a Glance’ dashboard module
* Added web-font support for Dala Floda (bold)
 * N.B. font files are ignored by git — need adding separately



## 0.4-beta.0
* Added theme preview screenshot
* Fixed missing echo function on upcoming event link



## 0.3-beta.1
* Fix for missing semi-colon breaking composers archive



## 0.3-beta.0
* Added fallbacks for member and event archives for when no content exists
* Minor fixes



## 0.2-beta.0
* Deleted redundant files
* Removed script calls used in dev testing
* Hid comments section from admin menu
* Added core options set-up on theme load
* Added custom, sortable date-start column on event admin pages



## 0.1-beta.0

**Initial theme release for implementation testing.**

#### Functionality

* Sets up custom post types (members, concerts, colloquia, misc. events)
* Creates archives that show group members, past events and future events
* Creates home page with upcoming events & current members list
* Fully styled
