// topnav-active-page.js

document.addEventListener('DOMContentLoaded', function() {
  // Get the current page URL
  var currentUrl = window.location.href;

  // Select all navbar links and dropdown items
  var navLinks = document.querySelectorAll('.navbar-nav a');
  var dropdownItems = document.querySelectorAll('.dropdown-menu a');

  // Function to set active class to the current page link
  function setActivePage() {
    // Loop through navbar links
    navLinks.forEach(function(link) {
      if (link.href === currentUrl) {
        link.classList.add('active');
      } else {
        link.classList.remove('active');
      }
    });

    // Loop through dropdown items
    dropdownItems.forEach(function(item) {
      if (item.href === currentUrl) {
        item.classList.add('active');
        // If a dropdown item is active, also mark its parent as active
        var dropdownParent = item.closest('.nav-item');
        if (dropdownParent) {
          dropdownParent.querySelector('a.nav-link').classList.add('active');
        }
      } else {
        item.classList.remove('active');
      }
    });
  }

  // Initial call to set active page on page load
  setActivePage();
});
