/**
 * FTC Product UI - Admin JavaScript
 *
 * @package FTC_Product_UI
 * @since 1.0.0
 */

(function($) {
	'use strict';

	/**
	 * Admin functionality
	 */
	const FTCAdmin = {

		/**
		 * Initialize
		 */
		init: function() {
			this.bindEvents();
			this.initTooltips();
		},

		/**
		 * Bind events
		 */
		bindEvents: function() {
			// Reset to defaults button
			$('#ftc-reset-defaults').on('click', this.handleResetDefaults.bind(this));

			// Form change detection
			$('#ftc-feature-flags-form input').on('change', this.handleFormChange.bind(this));

			// AJAX form submission (optional enhancement)
			// $('#ftc-feature-flags-form').on('submit', this.handleFormSubmit.bind(this));
		},

		/**
		 * Handle reset to defaults
		 */
		handleResetDefaults: function(e) {
			e.preventDefault();

			if (!confirm(ftcAdmin.strings.confirm)) {
				return;
			}

			// Get site-specific defaults based on current site
			const siteUrl = window.location.hostname;
			const defaults = this.getSiteDefaults(siteUrl);

			// Update checkboxes
			$('#ftc-feature-flags-form input[type="checkbox"]').each(function() {
				const name = $(this).attr('name');
				const match = name.match(/ftc_tabs\[([^\]]+)\]/);

				if (match && match[1]) {
					const tabSlug = match[1];
					$(this).prop('checked', defaults[tabSlug] || false);
				}
			});

			// Show notification
			this.showNotification('success', 'Defaults applied. Click "Save Changes" to save.');
		},

		/**
		 * Get site-specific defaults
		 */
		getSiteDefaults: function(siteUrl) {
			// Default configuration
			const defaults = {
				specs: true,
				features: true,
				modeling: false,
				ordering: true,
				downloads: true,
				spare_parts: false,
				quote: true,
				cad: false
			};

			// Thermal site gets Modeling tab
			if (siteUrl.includes('thermal.ferrotec.com')) {
				defaults.modeling = true;
			}

			// Seals site gets Spare Parts tab
			if (siteUrl.includes('seals.ferrotec.com')) {
				defaults.spare_parts = true;
			}

			// Info-only sites
			const infoOnlySites = [
				'www.ferrotec.com',
				'quartz.ferrotec.com',
				'ceramics.ferrotec.com',
				'temescal.ferrotec.com'
			];

			if (infoOnlySites.some(site => siteUrl.includes(site))) {
				defaults.ordering = false;
				defaults.quote = false;
			}

			return defaults;
		},

		/**
		 * Handle form change
		 */
		handleFormChange: function() {
			// Mark form as changed
			$(document.body).addClass('ftc-form-changed');

			// Update enabled count
			this.updateEnabledCount();
		},

		/**
		 * Update enabled tabs count
		 */
		updateEnabledCount: function() {
			const enabledCount = $('#ftc-feature-flags-form input[type="checkbox"]:checked').length;
			const totalCount = $('#ftc-feature-flags-form input[type="checkbox"]').length;

			$('.ftc-stat-number').text(enabledCount + ' / ' + totalCount);
		},

		/**
		 * Handle form submit (optional AJAX enhancement)
		 */
		handleFormSubmit: function(e) {
			// Uncomment to enable AJAX submission
			/*
			e.preventDefault();

			const $form = $(e.target);
			const formData = $form.serialize();

			this.showLoading($form);

			$.ajax({
				url: ftcAdmin.ajaxUrl,
				type: 'POST',
				data: {
					action: 'ftc_save_feature_flags',
					nonce: ftcAdmin.nonce,
					tabs: this.getFormData($form)
				},
				success: function(response) {
					if (response.success) {
						this.showNotification('success', response.data.message);
						$(document.body).removeClass('ftc-form-changed');
					} else {
						this.showNotification('error', response.data.message);
					}
				}.bind(this),
				error: function() {
					this.showNotification('error', ftcAdmin.strings.error);
				}.bind(this),
				complete: function() {
					this.hideLoading($form);
				}.bind(this)
			});
			*/
		},

		/**
		 * Get form data as object
		 */
		getFormData: function($form) {
			const data = {};

			$form.find('input[type="checkbox"]').each(function() {
				const name = $(this).attr('name');
				const match = name.match(/ftc_tabs\[([^\]]+)\]/);

				if (match && match[1]) {
					data[match[1]] = $(this).is(':checked') ? '1' : '0';
				}
			});

			return data;
		},

		/**
		 * Show loading state
		 */
		showLoading: function($element) {
			$element.closest('.ftc-card').addClass('ftc-loading');
		},

		/**
		 * Hide loading state
		 */
		hideLoading: function($element) {
			$element.closest('.ftc-card').removeClass('ftc-loading');
		},

		/**
		 * Show notification
		 */
		showNotification: function(type, message) {
			// Remove existing notifications
			$('.ftc-notification').remove();

			// Create notification
			const $notification = $('<div>')
				.addClass('notice ftc-notification is-dismissible')
				.addClass(type === 'success' ? 'notice-success' : 'notice-error')
				.html('<p>' + message + '</p>');

			// Add to page
			$('.ftc-admin-wrap h1').after($notification);

			// Scroll to notification
			$('html, body').animate({
				scrollTop: $notification.offset().top - 50
			}, 300);

			// Make dismissible
			if (typeof wp !== 'undefined' && wp.notices) {
				wp.notices.init();
			}

			// Auto-dismiss after 5 seconds
			setTimeout(function() {
				$notification.fadeOut(300, function() {
					$(this).remove();
				});
			}, 5000);
		},

		/**
		 * Initialize tooltips
		 */
		initTooltips: function() {
			// Add jQuery UI tooltips if available
			if ($.fn.tooltip) {
				$('[title]').tooltip({
					position: {
						my: 'center bottom-10',
						at: 'center top'
					}
				});
			}
		},

		/**
		 * Warn about unsaved changes
		 */
		warnUnsavedChanges: function() {
			$(window).on('beforeunload', function() {
				if ($(document.body).hasClass('ftc-form-changed')) {
					return 'You have unsaved changes. Are you sure you want to leave?';
				}
			});
		}
	};

	/**
	 * Network Admin functionality
	 */
	const FTCNetworkAdmin = {

		/**
		 * Initialize
		 */
		init: function() {
			this.initSiteFilters();
			this.initBulkActions();
		},

		/**
		 * Initialize site filters
		 */
		initSiteFilters: function() {
			// Add search/filter functionality for sites
			const $search = $('<input>')
				.attr({
					type: 'search',
					placeholder: 'Search sites...',
					class: 'ftc-site-search'
				})
				.css({
					marginBottom: '20px',
					padding: '8px 12px',
					width: '300px'
				});

			$('.ftc-network-sites').before($search);

			$search.on('input', function() {
				const searchTerm = $(this).val().toLowerCase();

				$('.ftc-site-card').each(function() {
					const siteName = $(this).find('h3').text().toLowerCase();
					const siteDomain = $(this).find('.ftc-site-domain').text().toLowerCase();

					if (siteName.includes(searchTerm) || siteDomain.includes(searchTerm)) {
						$(this).show();
					} else {
						$(this).hide();
					}
				});
			});
		},

		/**
		 * Initialize bulk actions (future enhancement)
		 */
		initBulkActions: function() {
			// TODO: Add bulk enable/disable functionality
		}
	};

	/**
	 * Initialize when document is ready
	 */
	$(document).ready(function() {
		// Check if we're on the FTC admin page
		if ($('.ftc-admin-wrap').length) {
			FTCAdmin.init();
		}

		// Check if we're on the network admin page
		if ($('.ftc-network-wrap').length) {
			FTCNetworkAdmin.init();
		}
	});

})(jQuery);
