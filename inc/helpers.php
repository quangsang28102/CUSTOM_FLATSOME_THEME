<?php
/**
 * Helper functions for HPO Flatsome Child Theme.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Truncate text by character length with ellipsis.
 *
 * @param string $text
 * @param int $length
 * @param string $append
 * @return string
 */
function hpo_truncate_text( $text, $length = 100, $append = '...' ) {
    $text = wp_strip_all_tags( $text );
    if ( mb_strlen( $text ) > $length ) {
        $text = mb_substr( $text, 0, $length );
        $text .= $append;
    }
    return $text;
}

/**
 * Get attachment image url with fallback.
 *
 * @param int $attachment_id
 * @param string $size
 * @param string $fallback_url
 * @return string
 */
function hpo_get_image_url( $attachment_id, $size = 'full', $fallback_url = '' ) {
    if ( ! empty( $attachment_id ) ) {
        $src = wp_get_attachment_image_url( $attachment_id, $size );
        if ( $src ) {
            return $src;
        }
    }
    return $fallback_url;
}
