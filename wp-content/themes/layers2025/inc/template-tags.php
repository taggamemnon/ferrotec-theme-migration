<?php
/**
 * Custom Template Tags
 *
 * @package Layers2025
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Display posted on date
 */
if ( ! function_exists( 'layers2025_posted_on' ) ) {
    function layers2025_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( DATE_W3C ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( DATE_W3C ) ),
            esc_html( get_the_modified_date() )
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x( 'Posted on %s', 'post date', 'layers2025' ),
            '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

/**
 * Display posted by author
 */
if ( ! function_exists( 'layers2025_posted_by' ) ) {
    function layers2025_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x( 'by %s', 'post author', 'layers2025' ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

/**
 * Display entry footer (categories, tags, edit link)
 */
if ( ! function_exists( 'layers2025_entry_footer' ) ) {
    function layers2025_entry_footer() {
        // Hide category and tag text for pages.
        if ( 'post' === get_post_type() ) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list( esc_html__( ', ', 'layers2025' ) );
            if ( $categories_list ) {
                /* translators: 1: list of categories. */
                printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'layers2025' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'layers2025' ) );
            if ( $tags_list ) {
                /* translators: 1: list of tags. */
                printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'layers2025' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }

        if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'layers2025' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post( get_the_title() )
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Edit <span class="screen-reader-text">%s</span>', 'layers2025' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post( get_the_title() )
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
}

/**
 * Display post thumbnail
 */
if ( ! function_exists( 'layers2025_post_thumbnail' ) ) {
    function layers2025_post_thumbnail() {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }

        if ( is_singular() ) :
            ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div>
            <?php
        else :
            ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail( 'post-thumbnail', array(
                    'alt' => the_title_attribute( array(
                        'echo' => false,
                    ) ),
                ) );
                ?>
            </a>
            <?php
        endif;
    }
}

/**
 * Display breadcrumb navigation
 */
if ( ! function_exists( 'layers2025_breadcrumb' ) ) {
    function layers2025_breadcrumb() {
        if ( is_front_page() ) {
            return;
        }

        echo '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'layers2025' ) . '">';
        echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'layers2025' ) . '</a>';
        echo ' <span class="separator">&gt;</span> ';

        if ( is_category() || is_single() ) {
            the_category( ' <span class="separator">&gt;</span> ' );
            if ( is_single() ) {
                echo ' <span class="separator">&gt;</span> ';
                the_title();
            }
        } elseif ( is_page() ) {
            if ( wp_get_post_parent_id( get_the_ID() ) ) {
                $parent_id  = wp_get_post_parent_id( get_the_ID() );
                $breadcrumbs = array();
                while ( $parent_id ) {
                    $page = get_page( $parent_id );
                    $breadcrumbs[] = '<a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . esc_html( get_the_title( $page->ID ) ) . '</a>';
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse( $breadcrumbs );
                foreach ( $breadcrumbs as $crumb ) {
                    echo $crumb . ' <span class="separator">&gt;</span> '; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                }
            }
            the_title();
        } elseif ( is_search() ) {
            echo esc_html__( 'Search results for: ', 'layers2025' ) . get_search_query();
        } elseif ( is_404() ) {
            echo esc_html__( 'Error 404', 'layers2025' );
        }

        echo '</nav>';
    }
}
