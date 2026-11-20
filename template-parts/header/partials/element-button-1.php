<?php
/**
 * Button 1 element (HPO Login CTA).
 *
 * @package Flatsome\Templates
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$text        = get_theme_mod( 'header_button_1', 'Đăng nhập' );
$link        = get_theme_mod( 'header_button_1_link', 'https://gateway.hpo.edu.vn/signin' );
$target      = get_theme_mod( 'header_button_1_link_target', '_self' );
$rel         = get_theme_mod( 'header_button_1_link_rel', '' );
$color       = get_theme_mod( 'header_button_1_color', 'primary' );
$style       = get_theme_mod( 'header_button_1_style', 'outline' );
$size        = get_theme_mod( 'header_button_1_size', '' );
$letter_case = get_theme_mod( 'header_button_1_letter_case', '' );

if ( '' === trim( (string) $text ) ) {
    $text = 'Đăng nhập';
}
if ( '' === trim( (string) $link ) ) {
    $link = 'https://gateway.hpo.edu.vn/signin';
}
if ( function_exists( 'flatsome_smart_links' ) ) {
    $link = flatsome_smart_links( $link );
}

$classes = array( 'btn', 'btn-login', 'button' );
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
<li class="html header-button-1">
  <div class="header-button">
    <a href="<?php echo esc_url( $link ); ?>"<?php echo $target_attr . $rel_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
        <path d="m10 17 5-5-5-5" />
        <path d="M15 12H3" />
      </svg>
      <span><?php echo esc_html( $text ); ?></span>
    </a>
  </div>
</li>
