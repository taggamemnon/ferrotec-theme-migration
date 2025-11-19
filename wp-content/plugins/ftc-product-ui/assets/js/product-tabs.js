/**
 * Product Tabs JavaScript
 *
 * Handles tab interactions and enhancements
 *
 * @package FTC_Product_UI
 * @since 1.0.0
 */

(function($) {
	'use strict';

	/**
	 * Product Tabs functionality
	 */
	const FTC_Product_Tabs = {

		/**
		 * Initialize
		 */
		init: function() {
			this.setupTabs();
			this.setupDeepLinking();
			this.setupPrintHandlers();
			this.setupTableSorting();
		},

		/**
		 * Setup tab click handlers
		 */
		setupTabs: function() {
			const tabs = $('.woocommerce-tabs .tabs');
			const panels = $('.woocommerce-tabs .woocommerce-Tabs-panel');

			// Enhanced tab switching with fade effect
			tabs.on('click', 'a', function(e) {
				e.preventDefault();

				const $this = $(this);
				const $tab = $this.parent();
				const target = $this.attr('href');

				// Update active states
				tabs.find('li').removeClass('active');
				$tab.addClass('active');

				// Show target panel with fade effect
				panels.hide();
				$(target).fadeIn(300);

				// Update URL hash without scrolling
				if (history.pushState) {
					history.pushState(null, null, target);
				}

				// Trigger resize for charts
				$(window).trigger('resize');
			});
		},

		/**
		 * Setup deep linking (URL hash support)
		 */
		setupDeepLinking: function() {
			const hash = window.location.hash;

			if (hash && $(hash).length) {
				// Wait for DOM to be ready
				setTimeout(function() {
					$('.woocommerce-tabs .tabs a[href="' + hash + '"]').trigger('click');

					// Scroll to tabs after activation
					$('html, body').animate({
						scrollTop: $('.woocommerce-tabs').offset().top - 100
					}, 500);
				}, 100);
			}
		},

		/**
		 * Setup print handlers
		 */
		setupPrintHandlers: function() {
			// Add print button to tabs
			$('.woocommerce-tabs').each(function() {
				const $tabs = $(this);

				if (!$tabs.find('.ftc-print-tab').length) {
					const $printButton = $('<button>')
						.addClass('ftc-print-tab button btn btn-sm btn-outline-secondary')
						.html('<span class="dashicons dashicons-printer"></span> Print')
						.css({
							'float': 'right',
							'margin-top': '-40px',
							'display': 'flex',
							'align-items': 'center',
							'gap': '0.5rem'
						});

					$printButton.on('click', function(e) {
						e.preventDefault();
						window.print();
					});

					$tabs.prepend($printButton);
				}
			});

			// Handle print media queries
			if (window.matchMedia) {
				const mediaQueryList = window.matchMedia('print');

				mediaQueryList.addListener(function(mql) {
					if (mql.matches) {
						// Before print
						FTC_Product_Tabs.beforePrint();
					} else {
						// After print
						FTC_Product_Tabs.afterPrint();
					}
				});
			}

			// Fallback for older browsers
			window.onbeforeprint = this.beforePrint;
			window.onafterprint = this.afterPrint;
		},

		/**
		 * Before print handler
		 */
		beforePrint: function() {
			// Show all tab panels for printing
			$('.woocommerce-tabs .woocommerce-Tabs-panel').show();

			// Add print-specific class
			$('body').addClass('ftc-printing');
		},

		/**
		 * After print handler
		 */
		afterPrint: function() {
			// Hide non-active panels
			const activeTab = $('.woocommerce-tabs .tabs li.active a').attr('href');
			$('.woocommerce-tabs .woocommerce-Tabs-panel').hide();
			$(activeTab).show();

			// Remove print-specific class
			$('body').removeClass('ftc-printing');
		},

		/**
		 * Setup table sorting functionality
		 */
		setupTableSorting: function() {
			// Add sorting to spare parts table
			$('.ftc-spare-parts-table thead th').each(function(index) {
				const $th = $(this);

				if (index < 3) { // Don't make action column sortable
					$th.css('cursor', 'pointer')
					   .attr('title', 'Click to sort')
					   .on('click', function() {
						   FTC_Product_Tabs.sortTable($(this), index);
					   });
				}
			});
		},

		/**
		 * Sort table by column
		 *
		 * @param {jQuery} $th The table header element
		 * @param {number} columnIndex The column index to sort
		 */
		sortTable: function($th, columnIndex) {
			const $table = $th.closest('table');
			const $tbody = $table.find('tbody');
			const rows = $tbody.find('tr').toArray();

			// Determine sort direction
			const isAscending = !$th.hasClass('sorted-asc');

			// Remove all sort indicators
			$table.find('thead th').removeClass('sorted-asc sorted-desc');

			// Add new sort indicator
			$th.addClass(isAscending ? 'sorted-asc' : 'sorted-desc');

			// Sort rows
			rows.sort(function(a, b) {
				const aValue = $(a).find('td').eq(columnIndex).text().trim();
				const bValue = $(b).find('td').eq(columnIndex).text().trim();

				// Try numeric comparison first
				const aNum = parseFloat(aValue);
				const bNum = parseFloat(bValue);

				if (!isNaN(aNum) && !isNaN(bNum)) {
					return isAscending ? aNum - bNum : bNum - aNum;
				}

				// Fallback to string comparison
				if (isAscending) {
					return aValue.localeCompare(bValue);
				} else {
					return bValue.localeCompare(aValue);
				}
			});

			// Reorder rows in DOM
			$.each(rows, function(index, row) {
				$tbody.append(row);
			});
		}
	};

	/**
	 * Chart.js enhancements
	 */
	const FTC_Chart_Enhancements = {

		/**
		 * Initialize
		 */
		init: function() {
			if (typeof Chart === 'undefined') {
				return;
			}

			this.setupResponsiveCharts();
			this.setupChartExport();
		},

		/**
		 * Make charts responsive
		 */
		setupResponsiveCharts: function() {
			// Chart.js is already responsive by default
			// This is a placeholder for additional responsive enhancements

			$(window).on('resize', function() {
				// Charts will auto-resize, but we can add custom logic here
				console.log('Window resized - charts updating');
			});
		},

		/**
		 * Add export functionality to charts
		 */
		setupChartExport: function() {
			// Add export button to chart containers
			$('.ftc-chart-container').each(function() {
				const $container = $(this);

				if (!$container.find('.ftc-export-chart').length) {
					const $exportButton = $('<button>')
						.addClass('ftc-export-chart button btn btn-sm btn-outline-secondary')
						.text('Export as PNG')
						.css({
							'position': 'absolute',
							'top': '10px',
							'right': '10px',
							'z-index': '10'
						});

					$exportButton.on('click', function(e) {
						e.preventDefault();
						FTC_Chart_Enhancements.exportChart($container.find('canvas')[0]);
					});

					$container.css('position', 'relative');
					$container.append($exportButton);
				}
			});
		},

		/**
		 * Export chart as image
		 *
		 * @param {HTMLCanvasElement} canvas The chart canvas element
		 */
		exportChart: function(canvas) {
			if (!canvas) {
				return;
			}

			try {
				const link = document.createElement('a');
				link.download = 'thermal-performance-chart.png';
				link.href = canvas.toDataURL('image/png');
				link.click();
			} catch (error) {
				console.error('Error exporting chart:', error);
				alert('Error exporting chart. Please try again.');
			}
		}
	};

	/**
	 * Download tab enhancements
	 */
	const FTC_Download_Enhancements = {

		/**
		 * Initialize
		 */
		init: function() {
			this.trackDownloads();
			this.enhanceFileLinks();
		},

		/**
		 * Track file downloads
		 */
		trackDownloads: function() {
			$('.ftc-download-button, .ftc-file-link').on('click', function() {
				const fileName = $(this).closest('.ftc-download-item').find('.ftc-file-link').text().trim();

				// Send to analytics if available
				if (typeof gtag !== 'undefined') {
					gtag('event', 'file_download', {
						'event_category': 'Downloads',
						'event_label': fileName
					});
				}

				if (typeof ga !== 'undefined') {
					ga('send', 'event', 'Downloads', 'file_download', fileName);
				}
			});
		},

		/**
		 * Enhance file links with file type icons
		 */
		enhanceFileLinks: function() {
			$('.ftc-file-link').each(function() {
				const $link = $(this);
				const href = $link.attr('href');

				if (!href) {
					return;
				}

				// Add file type indicator if not already present
				const extension = href.split('.').pop().toLowerCase();
				const fileTypeMap = {
					'pdf': 'PDF',
					'step': 'STEP',
					'stp': 'STEP',
					'stl': 'STL',
					'dwg': 'DWG',
					'dxf': 'DXF',
					'zip': 'ZIP'
				};

				if (fileTypeMap[extension] && !$link.find('.file-type-badge').length) {
					$link.append(' <span class="file-type-badge badge badge-secondary" style="font-size: 0.7em; margin-left: 0.5rem;">' + fileTypeMap[extension] + '</span>');
				}
			});
		}
	};

	/**
	 * Initialize when document is ready
	 */
	$(document).ready(function() {
		FTC_Product_Tabs.init();
		FTC_Chart_Enhancements.init();
		FTC_Download_Enhancements.init();
	});

})(jQuery);
