/**
 * FTC Product UI - Main JavaScript
 *
 * @package FTC_Product_UI
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Initialize when DOM is ready
     */
    $(document).ready(function() {
        FTC_ProductUI.init();
    });

    /**
     * Main FTC Product UI object
     */
    window.FTC_ProductUI = {

        /**
         * Initialize all components
         */
        init: function() {
            this.initTabs();
            this.initPrintView();
        },

        /**
         * Initialize product tabs
         */
        initTabs: function() {
            // Bootstrap 5 tabs are initialized automatically
            // Custom tab behavior can be added here

            // Example: Track tab clicks
            $('.ftc-product-tabs .nav-link').on('click', function() {
                const tabName = $(this).data('tab-name');
                console.log('Tab clicked:', tabName);
            });
        },

        /**
         * Initialize print view
         */
        initPrintView: function() {
            // Check if we're in print mode
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('print') === '1') {
                this.preparePrint();
            }

            // Add print button functionality
            $('.ftc-print-button').on('click', function(e) {
                e.preventDefault();
                window.print();
            });
        },

        /**
         * Prepare page for printing
         */
        preparePrint: function() {
            // Show all tab content (not just active tab)
            $('.ftc-product-tabs .tab-pane').addClass('show active');

            // Convert charts to images before print
            window.addEventListener('beforeprint', function() {
                FTC_ProductUI.convertChartsToImages();
            });

            // Restore charts after print
            window.addEventListener('afterprint', function() {
                FTC_ProductUI.restoreCharts();
            });
        },

        /**
         * Convert Chart.js canvases to static images for print
         */
        convertChartsToImages: function() {
            $('.ftc-chart-container canvas').each(function() {
                const canvas = this;
                const img = document.createElement('img');
                img.src = canvas.toDataURL('image/png', 1.0);
                img.style.maxWidth = '100%';
                img.className = 'ftc-print-chart-image';

                // Hide canvas, show image
                canvas.style.display = 'none';
                canvas.parentNode.insertBefore(img, canvas);
            });
        },

        /**
         * Restore Chart.js canvases after print
         */
        restoreCharts: function() {
            $('.ftc-print-chart-image').each(function() {
                const img = this;
                const canvas = img.nextSibling;

                if (canvas && canvas.tagName === 'CANVAS') {
                    canvas.style.display = 'block';
                }

                img.remove();
            });
        }
    };

})(jQuery);
