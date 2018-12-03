# hgnm-2014

[![GitHub release](https://img.shields.io/github/release/hgnm/hgnm-2014.svg?maxAge=2592000)](https://github.com/HGNM/hgnm-2014/releases/latest) [![Build Status](https://travis-ci.org/HGNM/hgnm-2014.svg?branch=master)](https://travis-ci.org/HGNM/hgnm-2014)

Repository for WordPress theme development for <http://hgnm.org>.



## Set-up

1. Use [`hgnm-wp-dev`](https://github.com/HGNM/hgnm-wp-dev) to set up a development environment & bootstrap dependencies (including this theme repo).

2. Once `hgnm-wp-dev` is up and running, `cd` to the theme directory:
    ```sh
    cd ~/Local\ Sites/hgnm/app/public/wp-content/themes/hgnm-2014
    ```

3. Install development dependencies (requires [Node/npm](https://nodejs.org/)):
    ```sh
    npm install
    ```

That’s it! Using the `hgnm-wp-dev` set-up with Local by Flywheel, a fully functional WordPress install can be found at <http://hgnm.local>.

Changes to any of the PHP theme files can be seen by refreshing your browser.



## Development

### Working on stylesheets
`hgnm-2014`’s stylesheets are written using [SASS](https://sass-lang.com/) and can be found in the `scss` directory. These need to be compiled to a CSS file to be used in the browser. There are two ways to achieve this:

1. Compile to CSS once:
    ```sh
    npm run css:build
    ```
  
2. Watch the `scss` directory and auto-compile to CSS when something changes:
    ```sh
    npm run css:watch
    ```

> ⚠️ If SCSS files do not follow the style rules set in `.sass-lint.yml`, you will see build errors

> 💡 Use [Atom](https://atom.io/) with [`linter`](https://atom.io/packages/linter) and [`linter-sass-lint`](https://atom.io/packages/linter-sass-lint) to see feedback about style errors while you edit


### Committing changes

`hgnm-2014` uses the [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0-beta.2/) standard for commit messages. This enables automatic changelog generation and easier semantic versioning.

To ensure your commits conform to this format, use the [Commitizen](http://commitizen.github.io/cz-cli/) command line tool instead of `git commit`:

```sh
npx git-cz
```

Commitizen will show you a series of prompts to fill out and format your responses into a tidy commit message.

⚠️ _If a commit message does not conform to the standard, `commitlint` will reject it on the command line and on Travis-CI._


### Releasing a version

1. Bump version numbers, update the changelog, and tag a new release:
    ```sh
    npm run release
    ```

3. Push your changes including the newly created tag to GitHub:
    ```sh
    git push --follow-tags
    ```

    After you have pushed your tag, Travis CI will build `hgnm-2014.zip` and attach it to the GitHub release. This archive is used by automatic theme updates in WordPress.

4. Copy the changes listed in `CHANGELOG.md` to the release notes on GitHub.


### Bundling the theme archive

To build the theme, producing a bundled `hgnm-2014.zip` theme archive, run:

```sh
npm run build
```



## Architecture

For more details on how `hgnm-2014` is structured and implements its functionality, see [ARCHITECTURE](ARCHITECTURE.md).



## Dependencies

_These are automatically installed if you use the `hgnm-wp-dev` environment._

- Elliot Condon’s [Advanced Custom Fields {v5}](https://www.advancedcustomfields.com/pro/)

  Used to manage complex custom back-end input fields, which will be displayed within the theme.



## [Changelog](CHANGELOG.md)
