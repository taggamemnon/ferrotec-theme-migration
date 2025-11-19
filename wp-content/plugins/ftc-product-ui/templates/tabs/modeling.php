<?php
/**
 * Modeling Tab Template (Thermal Products Only)
 *
 * Displays performance curves using Chart.js.
 * Renders thermal performance data from ACF repeater field.
 *
 * @package FTC_Product_UI
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! $product ) {
	return;
}

$product_id = $product->get_id();

// Get performance data from ACF repeater
$performance_data = get_field( 'thermal_performance_data', $product_id );
$modeling_content = get_field( 'thermal_modeling_content', $product_id );
$modeling_notes = get_field( 'thermal_modeling_notes', $product_id );
?>

<div class="ftc-modeling-tab">

	<?php if ( $modeling_content ) : ?>
		<div class="ftc-modeling-intro">
			<?php echo wp_kses_post( $modeling_content ); ?>
		</div>
	<?php endif; ?>

	<?php if ( $performance_data && is_array( $performance_data ) ) : ?>
		<div class="ftc-performance-charts">
			<h3><?php esc_html_e( 'Performance Curves', 'ftc-product-ui' ); ?></h3>

			<div class="ftc-chart-container">
				<canvas id="ftc-thermal-performance-chart"></canvas>
			</div>

			<script>
			(function($) {
				'use strict';

				$(document).ready(function() {
					// Wait for Chart.js to load
					if (typeof Chart === 'undefined') {
						console.error('Chart.js not loaded');
						return;
					}

					const ctx = document.getElementById('ftc-thermal-performance-chart');
					if (!ctx) {
						return;
					}

					// Prepare chart data from ACF
					const datasets = [];
					<?php foreach ( $performance_data as $index => $dataset ) : ?>
						<?php
						$label = isset( $dataset['dataset_label'] ) ? $dataset['dataset_label'] : 'Dataset ' . ( $index + 1 );
						$x_values = isset( $dataset['x_values'] ) ? $dataset['x_values'] : '';
						$y_values = isset( $dataset['y_values'] ) ? $dataset['y_values'] : '';
						$color = isset( $dataset['line_color'] ) ? $dataset['line_color'] : '#' . substr( md5( $label ), 0, 6 );

						// Parse values (assume comma-separated)
						$x_array = array_map( 'trim', explode( ',', $x_values ) );
						$y_array = array_map( 'trim', explode( ',', $y_values ) );

						// Create data points
						$data_points = array();
						for ( $i = 0; $i < min( count( $x_array ), count( $y_array ) ); $i++ ) {
							$data_points[] = array(
								'x' => floatval( $x_array[ $i ] ),
								'y' => floatval( $y_array[ $i ] ),
							);
						}
						?>

						datasets.push({
							label: <?php echo json_encode( $label ); ?>,
							data: <?php echo json_encode( $data_points ); ?>,
							borderColor: <?php echo json_encode( $color ); ?>,
							backgroundColor: 'transparent',
							borderWidth: 2,
							tension: 0.4,
							pointRadius: 3,
							pointHoverRadius: 5
						});
					<?php endforeach; ?>

					// Initialize chart
					new Chart(ctx, {
						type: 'line',
						data: {
							datasets: datasets
						},
						options: {
							responsive: true,
							maintainAspectRatio: true,
							aspectRatio: 2,
							interaction: {
								mode: 'index',
								intersect: false,
							},
							plugins: {
								legend: {
									position: 'top',
								},
								title: {
									display: true,
									text: '<?php echo esc_js( get_the_title( $product_id ) ); ?> - <?php esc_html_e( 'Performance Curves', 'ftc-product-ui' ); ?>'
								},
								tooltip: {
									callbacks: {
										label: function(context) {
											let label = context.dataset.label || '';
											if (label) {
												label += ': ';
											}
											label += '(' + context.parsed.x.toFixed(2) + ', ' + context.parsed.y.toFixed(2) + ')';
											return label;
										}
									}
								}
							},
							scales: {
								x: {
									type: 'linear',
									position: 'bottom',
									title: {
										display: true,
										text: '<?php echo esc_js( $performance_data[0]['x_axis_label'] ?? 'Temperature Difference (°C)' ); ?>'
									}
								},
								y: {
									type: 'linear',
									title: {
										display: true,
										text: '<?php echo esc_js( $performance_data[0]['y_axis_label'] ?? 'Cooling Capacity (W)' ); ?>'
									}
								}
							}
						}
					});
				});
			})(jQuery);
			</script>
		</div>
	<?php else : ?>
		<div class="ftc-no-performance-data">
			<p><?php esc_html_e( 'Performance curves are not available for this product.', 'ftc-product-ui' ); ?></p>
		</div>
	<?php endif; ?>

	<?php if ( $modeling_notes ) : ?>
		<div class="ftc-modeling-notes">
			<h4><?php esc_html_e( 'Notes', 'ftc-product-ui' ); ?></h4>
			<?php echo wp_kses_post( $modeling_notes ); ?>
		</div>
	<?php endif; ?>

</div>
