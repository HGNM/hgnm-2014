# scss

The `scss` directory contains theme style files written in [SASS][sass].

`style.scss` contains the main theme style, including the important initial
comment block that passes metadata about our theme to WordPress. It is processed
 to generate `style.css` (see [“Build CSS”][build] in the main README).

Filenames beginning with an underscore are treated as “partials” by SASS and do
not generate their own CSS files. Instead they are imported in `style.scss` with
the `@import` directive.

`_vars.scss` contains all the variables used by `style.scss`. They can be used
for example to a change a colour throughout the theme.

## Code style

SASS files should follow the conventions specified in [`.sass-lint.yml`][lint].
Running `npm t` will test whether everything conforms and builds will fail if
they don’t.

[build]: ../README.md#build-css
[sass]: https://sass-lang.com/guide
[lint]: ../.sass-lint.yml
