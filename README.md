# HGNM

Repository for WordPress theme development for new HGNM website.

## Roadmap

- [ ] WordPress core
	- [ ] [style.css](/style.css)
		- [X] Theme Header
		- [ ] screen styling
			- [ ] small screens (mobile first)
				- [X] site title & menu
			- [ ] larger screens
				- [X] site title
				- [X] menu
		- [ ] print styling
	- [ ] [front-page.php](/front-page.php)
		- [X] call header
		- [X] call content
			- [X] Blurb
			- [X] Upcoming Events
				- [X] Concerts
					- [ ] Tweak for date-time functionality (currently only date)
				- [X] Colloquia
				- [X] Others
				- [X] Link to all upcoming events
			- [X] Current Members
				- [X] ordered alphabetically
		- [X] call footer
- [X] [header.php](/header.php)
	- [X] `<head>`
	- [X] responsive site title
	- [X] responsive menu
- [ ] content single post templates
	- [ ] HGNM Member ([single-member.php](/single-member.php))
		- [X] Add last updated indication
		- [ ] Display related a/v
		- [ ] Display related events
			- [X] Upcoming
			- [ ] Past
	- [X] Concert Post ([single-concert.php](/single-concert.php))
		- [X] More sophisticated programme display logic
		- [X] Archival material
			- [X] A/V
			- [X] Photos
				- [X] Implement [Magnific Popup](http://dimsemenov.com/plugins/magnific-popup/)
			- [X] Poster & Programme
	- [ ] Colloquium Post ([single-colloquium.php](/single-colloquium.php))
- [ ] archive templates
	- [X] Members ([archive-member.php](/archive-member.php))
	- [X] Archives ([archive-concert.php](/archive-concert.php))
		- [X] Year navigation
	- [X] Events ([archive-colloquium.php](/archive-colloquium.php))
- [X] [footer.php](/footer.php)
- [ ] [functions.php](/functions.php)
	- [X] Enable featured image for custom post types
	- [X] Register custom post types (bundling functionality w/ theme)
	- [X] Remove default post type from admin area
- [ ] Custom fields: use/develop date-time picker for concert post types

## Dependencies

[These are provisional and may change.]

- Elliot Condon’s [Advanced Custom Fields {v5}](https://github.com/AdvancedCustomFields/acf5-beta)
Used to manage complex custom back-end input fields, which will be displayed within the theme.
- [Custom URL field](https://github.com/delucis/acf-url-field) plug-in for ACF5

## Testing

Clone this repository to the themes directory of a vanilla [WordPress](http://wordpress.org) install.

Clone [ACF5](https://github.com/AdvancedCustomFields/acf5-beta) and [acf-url-field](https://github.com/delucis/acf-url-field) to the plugins directory.
