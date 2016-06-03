# hgnm-2014

Repository for WordPress theme development for <http://hgnm.org>.

## Development

### Set-up

1. Use [`hgnm-wp-dev`](https://github.com/HGNM/hgnm-wp-dev) to set up a development environment & bootstrap dependencies (including this theme repo).

2. Once `hgnm-wp-dev` is up and running, `cd` to the theme directory:
  ```sh
  cd wordpress/wp-content/themes/hgnm-2014
  ```

3. Install development dependencies (requires [Node/npm](https://nodejs.org/)):
  ```sh
  npm install
  ```

### Build CSS
- Watch `scss/style.scss` and auto-compile when it changes:

  ```sh
  npm start
  ```

That’s it! Using the `hgnm-wp-dev` environment, a fully functional WordPress install can be found at <http://hgnm.dev>. Log in as `admin` with password `vagrant`.

Changes to any of the `php` files can be seen simply by refreshing your browser.

To change `css` styling, edit `scss/style.scss`, which will auto-compile if `npm start` is running.

## Dependencies

_These are automatically installed if you use the `hgnm-wp-dev` environment._

- Elliot Condon’s [Advanced Custom Fields {v5}](https://github.com/AdvancedCustomFields/acf5-beta)
Used to manage complex custom back-end input fields, which will be displayed within the theme.
- [Date & Time Picker field](https://github.com/yanknudtskov/acf-field-date-time-picker) plug-in for ACF5

## [Changelog](CHANGELOG.md)
