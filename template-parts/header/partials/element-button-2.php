<?php
/**
 * Button 2 element (HPO Register CTA).
 *
 * @package Flatsome\Templates
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$text        = get_theme_mod( 'header_button_2', 'Đăng ký học' );
$link        = get_theme_mod( 'header_button_2_link', 'https://gateway.hpo.edu.vn/signup' );
$target      = get_theme_mod( 'header_button_2_link_target', '_self' );
$rel         = get_theme_mod( 'header_button_2_link_rel', '' );
$color       = get_theme_mod( 'header_button_2_color', 'primary' );
$style       = get_theme_mod( 'header_button_2_style', '' );
$size        = get_theme_mod( 'header_button_2_size', '' );
$letter_case = get_theme_mod( 'header_button_2_letter_case', '' );

if ( '' === trim( (string) $text ) ) {
    $text = 'Đăng ký học';
}
if ( '' === trim( (string) $link ) ) {
    $link = 'https://gateway.hpo.edu.vn/signup';
}
if ( function_exists( 'flatsome_smart_links' ) ) {
    $link = flatsome_smart_links( $link );
}

$classes = array( 'btn', 'btn-primary', 'button' );
if ( $color ) {
    $classes[] = sanitize_html_class( $color );
}
if ( $style ) {
    $classes[] = 'is-' . sanitize_html_class( $style );
}
if ( $size ) {
    $classes[] = sanitize_html_class( $size );
}
if ( $letter_case ) {
    $classes[] = sanitize_html_class( $letter_case );
}

$target_attr = ( '_blank' === $target ) ? ' target="_blank"' : '';
$rel_val     = trim( $rel . ( '_blank' === $target && false === strpos( $rel, 'noopener' ) ? ' noopener' : '' ) );
$rel_attr    = $rel_val ? ' rel="' . esc_attr( $rel_val ) . '"' : '';
?>
<li class="html header-button-2">
  <div class="header-button">
    <a href="<?php echo esc_url( $link ); ?>"<?php echo $target_attr . $rel_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
      <span><?php echo esc_html( $text ); ?></span>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M5 12h14M13 5l7 7-7 7" />
      </svg>
    </a>
  </div>
</li>
