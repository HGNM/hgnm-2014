// Mobile menu functionality (pattern from http://a11yproject.com/)
(function (document, window) {
  'use strict'

  // Vars
  var header = document.querySelector('.js-header')
  var menu = document.querySelector('.js-menu')
  var menuButton = document.createElement('button')

  // Button properties
  menuButton.classList.add('menu-button')
  menuButton.setAttribute('id', 'menu-button')
  menuButton.setAttribute('aria-label', 'Menu')
  menuButton.setAttribute('aria-expanded', 'false')
  menuButton.setAttribute('aria-controls', 'menu')
  menuButton.innerHTML = '<span aria-hidden="true">Menu</span>'

  // Menu properties
  menu.setAttribute('aria-hidden', 'true')
  menu.setAttribute('aria-labelledby', 'menu-button')

  // Add button to page
  header.insertBefore(menuButton, menu)

  // Handle button click event
  menuButton.addEventListener('click', function () {
    // If active...
    if (menu.classList.contains('active')) {
      // Hide
      header.classList.remove('active')
      menu.classList.remove('active')
      menu.setAttribute('aria-hidden', 'true')
      menuButton.setAttribute('aria-expanded', 'false')
      menuButton.classList.remove('active')
    } else {
      // Show
      header.classList.add('active')
      menu.classList.add('active')
      menu.setAttribute('aria-hidden', 'false')
      menuButton.setAttribute('aria-expanded', 'true')
      menuButton.classList.add('active')

      // Set focus on first link
      menu.children[0].children[0].children[0].focus()
    }
  }, false)
})(document, window)

// Replace jQuery’s $(document).ready
function ready (fn) {
  if (document.attachEvent ? document.readyState === 'complete' : document.readyState !== 'loading') {
    fn()
  } else {
    document.addEventListener('DOMContentLoaded', fn)
  }
}
