/**
 * Navigation Scripts
 *
 * @package Layers2025
 * @since 1.0.0
 */

(function() {
    'use strict';

    // Mobile menu toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileNavigation = document.querySelector('#mobile-navigation');

    if (mobileMenuToggle && mobileNavigation) {
        mobileMenuToggle.addEventListener('click', function() {
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !expanded);
            mobileNavigation.classList.toggle('toggled');
        });
    }

    // Submenu toggles for touch devices
    const menuItemsWithChildren = document.querySelectorAll('.menu-item-has-children');

    menuItemsWithChildren.forEach(function(item) {
        const link = item.querySelector('a');
        const submenu = item.querySelector('.sub-menu');

        if (link && submenu) {
            link.addEventListener('click', function(e) {
                // On touch devices, first tap opens submenu
                if ('ontouchstart' in window) {
                    if (!item.classList.contains('submenu-open')) {
                        e.preventDefault();
                        item.classList.add('submenu-open');
                    }
                }
            });
        }
    });

    // Close mobile menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileNavigation && mobileNavigation.classList.contains('toggled')) {
            mobileMenuToggle.setAttribute('aria-expanded', 'false');
            mobileNavigation.classList.remove('toggled');
        }
    });

})();
