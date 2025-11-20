<?php
/**
 * Content Section Block Template
 *
 * Replaces the old ACF 'rows' repeater field with a modern Gutenberg block.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 *
 * @package Layers_Gutenberg
 * @since 1.0.0
 */

// Get ACF field values
$content_html = get_field( 'content' );
$bk_color     = get_field( 'background_color' );
$bk_class     = get_field( 'background_class' );

// Support for block alignment (wide, full, etc.)
$align_class = ! empty( $block['align'] ) ? 'align' . $block['align'] : '';

// Support for custom anchor ID
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Support for custom CSS class
$class_name = '';
if ( ! empty( $block['className'] ) ) {
    $class_name = $block['className'];
}

// Build inline styles
$style = '';
if ( $bk_color ) {
    $style = 'style="background-color:' . esc_attr( $bk_color ) . '"';
}

// Build wrapper classes (matches original repeater output)
$wrapper_classes = array(
    'container-wrapper',
    'content-padding',
    $bk_class,
    $align_class,
    $class_name,
);
$wrapper_classes = array_filter( $wrapper_classes ); // Remove empty values
$wrapper_class_string = implode( ' ', $wrapper_classes );
?>

<div <?php echo $anchor; ?>class="<?php echo esc_attr( $wrapper_class_string ); ?>" <?php echo $style; ?>>
    <div class="container">
        <?php if ( $content_html ) : ?>
            <?php echo wp_kses_post( $content_html ); ?>
        <?php else : ?>
            <p style="color: #999; font-style: italic;">
                <?php esc_html_e( 'Add content to this section...', 'layers-gutenberg' ); ?>
            </p>
        <?php endif; ?>
    </div>
</div>
