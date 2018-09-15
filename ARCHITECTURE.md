# Architecture

<!-- TOC depthFrom:2 depthTo:3 withLinks:1 updateOnSave:1 orderedList:0 -->

- [Data Structure](#data-structure)
	- [`member`](#member)
	- [`colloquium`](#colloquium)
	- [`concert`](#concert)
	- [`miscevent`](#miscevent)
- [Template Structure](#template-structure)
	- [Template concatenation flow](#template-concatenation-flow)
	- [A note on “archive” pages](#a-note-on-archive-pages)
- [Theme functionality](#theme-functionality)
	- [Component Loading](#component-loading)
- [Build & release infrastructure](#build-release-infrastructure)

<!-- /TOC -->

## Data Structure

WordPress stores all its data in a MySQL database with the standard tables containing posts, pages, and various other things. `hgnm-2014` implements several [custom post types](https://codex.wordpress.org/Post_Types#Custom_Post_Types) to match the types of content required by HGNM and uses the [Advanced Custom Fields Pro](https://www.advancedcustomfields.com/pro/) (ACF) plugin to provide a custom UI and data structure for each of these post types.

The custom post types are declared in [`functions/custom-post-types.php`](functions/custom-post-types.php) and are as follows:

- [`member`](#member), which represents an individual HGNM member
- [`colloquium`](#colloquium), which represents a Monday colloquium
- [`concert`](#concert), which represents an HGNM concert
- [`miscevent`](#miscevent), which represents a miscellaneous concert, lecture, or other event not covered by the `concert` or `colloquium` post types

Each of these post types has custom properties set using ACF that can be retrieved in templates using [`get_field()` and other functions][acfdocs]. The ACF fields are declared in [`functions/acf-field-groups.php`](functions/acf-field-groups.php) and are documented below.

  [acfdocs]: https://www.advancedcustomfields.com/resources/code-examples/



### `member`

The `member` post type has a standard body field for biographical information and a featured image field for the member’s photo. The member’s name is stored as the post title.

property  | represents                              | required? | example
----------|-----------------------------------------|:---------:|---------------------
`dtstart` | The date the member joined HGNM         |     ✔︎     | `20120901`
`dtend`   | The date the member left HGNM/graduated |           | `20190701`
`url`     | URL for the member’s personal website   |           | `http://example.com`



### `colloquium`

The speaker’s name is stored as the post title.

property  | represents                              | required? | value
----------|-----------------------------------------|:----:|-----
`colloquium_type` | What type of colloquium this is | ✔︎ |  `HGNM Member`, `Guest Speaker` or `Post-Concert Discussion`
`fname` | A `member` post object if `colloquium_type` is `HGNM Member` | |
`concert_rel` | A `concert` post object if `colloquium_type` is `Post-Concert Discussion` | |
`url`     | URL for a guest speaker’s website   |   | `http://example.com`
`dtstart` | The date the colloquium takes place | ✔︎ |`29/9/2017`
`photo` | Image object for the colloquium announcement flyer | |



### `concert`

The name of the performer(s) is stored as the post title.

property  | represents                              | required? | value
----------|-----------------------------------------|:----:|-----
`dtstart` | The date the concert takes place      | ✔︎ |`29/9/2017`
`start_time` | The time the concert takes place   |   | `20:00`
`location` | Where the concert takes place | ✔︎
`support` | Is the concert Fromm- or Goldberg-supported? | ✔︎ | `Neither`, `Fromm` or `Goldberg`
`performer_url` | URL for the performer(s)
`facebook_url`  | URL for the Facebook event
`summary` | Text describing the event/performers
`a_v`  | Show/hide embed options in backend | ✔︎ |  `true`/`false`
`programme` | An array of “piece” objects ([see below][ppo])
`programme_plus` | An array of “piece” objects ([see below][pppo])
`programme_pdf` | A file object for the concert’s programme booklet
`poster_pdf`   | A file object for the concert’s poster
`gallery`   | A gallery of images

  [ppo]: #programme-piece-objects
  [pppo]: #programme-plus-piece-objects

#### `programme` piece objects

property  | represents                              | required? | value
----------|-----------------------------------------|:----:|---
`composer` | A `member` post object for the piece’s composer | ✔︎ |
`work_title` | A string for the piece’s title   | ✔︎ |
`embed_link`  | URL to SoundCloud, YouTube, etc. |  |
`a_or_v`  | Is `embed_link` audio or video? | ✔︎ | `none`, `Audio`, or `Video`

#### `programme_plus` piece objects

property  | represents                              | required? | value
----------|-----------------------------------------|:----:|---
`composer` | A string for the piece’s composer’s name | ✔︎ |
`work_title` | A string for the piece’s title   | ✔︎ |
`embed_link`  | URL to SoundCloud, YouTube, etc. |  |
`a_or_v`  | Is `embed_link` audio or video? | ✔︎ | `none`, `Audio`, or `Video`



### `miscevent`

The name/title of the event is stored as the post title

property     | represents                             | required? | value
-------------|----------------------------------------|:---------:|------------
`dtstart`    | The date the event takes place         |     ✔︎     | `29/9/2017`
`start_time` | The time the event takes place         |           | `20:00`
`dtend`      | The date the event ends                |           | `30/9/2017`
`details`    | An ACF “flexible content” field object |           |

#### `details` object

All properties are optional. Each property is a “row” of the details object with varying numbers of properties. For those with only one property, such as `details` > `description` > `summary`, that is shown in this table. For those with multiple properties those are detailed below.

property      | represents
--------------|-------------------------------------------------------------
`description` | An HTML string describing the event under the key `summary`
`location`    | [An object][lo] with properties describing the event location
`link`        | [A link object][lio] for the event
`photos`      | A photo gallery object under the key `gallery`
`videos`      | An array of [videos objects][vo] under the key `videos`
`documents`   | An array of [document objects][do] under the key `document`

  [lo]: #location-object
  [lio]: #link-object
  [vo]: #videos-object
  [do]: #document-object

##### `link` object

property | represents
---------|-------------------------------------------------------------
`url`    | URL to an external website
`title`  | Display text for `link` button, default: `See event website`

##### `location` object

property         | represents
-----------------|---------------------------------------------
`fn`             | The venue name
`street-address` | The street name and number of the venue
`locality`       | The town/city the venue is in, e.g. `Boston`
`region`         | The state/region the venue is in, e.g. `MA`
`postal-code`    | ZIP/Post Code
`country-name`   | The country the venue is in

##### `videos` object

property         | represents
-----------------|---------------------------------------------
`embed_link`     | URL to SoundCloud, YouTube, etc.

##### `document` object

property         | represents
-----------------|---------------------------------------------
`file`           | A file object for the uploaded document
`file_name`      | The name of the file to display




## Template Structure

A template is a PHP file, which loads data from the MySQL database and renders it to HTML on the server before sending that to the user who requested it. WordPress automatically combines PHP templates based on their filename and the URL requested. For example, for every page, WordPress loads `header.php`, adds the appropriate template for the body of that page, and closes with `footer.php`.

[WP Hierarchy][wph] is a useful tool for understanding how WordPress parses template filenames.

  [wph]: https://wphierarchy.com/


### Template concatenation flow

1. `header.php` **[always loaded]** Includes code for the start of the HTML document and the top of each page, including the navigation menu

2. Wordpress tests to see what kind of page we’re on and loads the relevant template:

  - The website home page → loads `front-page.php`

  - A 404 error → loads `404.php`

  - An “archive” page ([see below][anoap]) → looks for a template beginning with `archive`:

    - slug is `events` → post type is `colloquium` → loads `archive-colloquium.php`

    - slug is `archives` → post type is `concert` → loads `archive-concert.php`

    - slug is `composers` → post type is `member` → loads `archive-member.php`

  - A single post → looks for a template beginning with `single`:

    - slug is `colloquium` → post type is `colloquium` → loads `single-colloquium.php`

    - slug is `concert` → post type is `concert` → loads `single-concert.php`

    - slug is `composer` → post type is `member` → loads `single-member.php`

    - slug is `other-events` → post type is `miscevent` → loads `single-miscevent.php`

  - The page doesn’t match any of the above → loads `index.php` (a generic standard template used only for the contact page on hgnm.org)

3. `footer.php` **[always loaded]** Closes any HTML tags left open by `header.php`, loads any low-priority Javascript, and closes the HTML document

  [anoap]: #a-note-on-archive-pages


### A note on “archive” pages

Normally, WordPress uses archive pages to display a list of posts for a certain date range, e.g. all your blog posts for a given month. `hgnm-2014` hacks that system to display its **Events** and **Archives** pages, which results in template naming that is a little counterintuitive.

- The `colloquium` custom post type has its archive slug set to `events`, meaning that [the upcoming events page][events] is in fact loading the `archive-colloquium.php` template.

- The `concert` custom post type has its archive slug set to `archives`, and all [the archive pages][archives] load the `archive-concert.php` template.

- The `member` custom post type has its archive slug set to `composers`, and — less confusingly — `archive-member.php` displays the list of all HGNM members.

  [events]: http://hgnm.org/events/
  [archives]: http://hgnm.org/archives/

To accomplish season-by-season archives instead of calendar year archives, a custom URL parser extracts the year from a `/archives/<YEAR>` path and `<YEAR>` is treated as the year in which a season starts, so `/archives/2015` shows the events for the 2015–16 season. The logic for this can be found in [`functions/configure-archives.php`](functions/configure-archives.php).




## Theme functionality

Besides the templates described above, WordPress themes provide much of their custom functionality via their [`functions.php`](functions.php) file. To try to break code up into more easily digestible chunks, `hgnm-2014` has a [`functions`](functions) directory with many separate PHP files for specific areas of functionality that are included by `functions.php` using PHP’s `include()` method.


### Component Loading

To break up the large page templates described above, some layouts that are re-used are stored in the [`components`](components) directory and included in the main templates using the `component()` method declared in [`functions/component-loader.php`](functions/component-loader.php).

For example, `footer.php` includes a copyright string that updates its date range automatically and is defined in `components/copyright.php`. To include a component call `component()` with the component file name as the only argument:

```php
<?php component('copyright') ?>
```

If the component needs to be passed additional data, this can be achieved via the `component` method’s second argument:

```php
<?php component('colloquium_location_link', array( "location_only" => true )) ?>
```



## Build & release infrastructure

This repository uses Node.js and npm to implement a simple build pipeline that compiles `scss/style.scss` to `style.css` and bundles the entire theme into a ZIP archive.

When a new release is pushed to GitHub (see [‘Releasing a version’][version] in the README), [Travis-CI][travis] automatically detects the release tag, builds the ZIP archive, and attaches it to the appropriate [GitHub release][releases].

  [version]: README.md#releasing-a-version
  [travis]: https://travis-ci.org/HGNM/hgnm-2014
  [releases]: https://github.com/HGNM/hgnm-2014/releases

[`functions/theme-update-checker.php`][ftuc] allows WordPress instances with `hgnm-2014` installed to check whether there is a more recent version of the theme available from the GitHub releases.

  [ftuc]: functions/theme-update-checker.php
