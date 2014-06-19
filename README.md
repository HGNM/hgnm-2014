# HGNM

Repository for WordPress theme development for new HGNM website.

## Roadmap

- [ ] WordPress core
	- [ ] style.css
		- [X] Theme Header
		- [ ] screen styling
		- [ ] print styling
	- [ ] index.php
		- [X] call header
		- [ ] call content
		- [X] call footer
- [ ] header.php
	- [X] `<head>`
	- [ ] responsive HGNM title
	- [ ] responsive menu
- [ ] content types
- [ ] footer.php
- [ ] functions.php

## Dependencies

[These are provisional and may change.]

- Elliot Condon’s [Advanced Custom Fields {v5}](https://github.com/AdvancedCustomFields/acf5-beta)
Used to manage complex custom back-end input fields, which will be displayed within the theme.
- [Custom URL field](https://github.com/delucis/acf-url-field) plug-in for ACF5

## Testing

Clone this repository to the themes directory of a vanilla [WordPress](http://wordpress.org) install.

Clone [ACF5](https://github.com/AdvancedCustomFields/acf5-beta) and [acf-url-field](https://github.com/delucis/acf-url-field) to the plugins directory.