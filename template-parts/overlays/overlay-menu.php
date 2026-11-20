<?php
/**
 * The overlay menu (HPO Mobile Drawer preserving Flatsome Customizer & hooks).
 *
 * @package Flatsome\Templates
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$flatsome_mobile_overlay         = get_theme_mod( 'mobile_overlay', 'right' );
$flatsome_mobile_sidebar_classes = array( 'mobile-sidebar', 'no-scrollbar', 'mfp-hide' );
$flatsome_nav_classes            = array( 'nav', 'nav-sidebar', 'nav-vertical', 'mobile-menu-list' );
$flatsome_levels                 = 0;

if ( 'center' === $flatsome_mobile_overlay ) {
    $flatsome_nav_classes[] = 'nav-anim';
}

if (
    'center' !== $flatsome_mobile_overlay &&
    'slide' === get_theme_mod( 'mobile_submenu_effect' )
) {
    $flatsome_levels = (int) get_theme_mod( 'mobile_submenu_levels', '1' );

    $flatsome_mobile_sidebar_classes[] = 'mobile-sidebar-slide';
    $flatsome_nav_classes[]            = 'nav-slide';

    for ( $level = 1; $level <= $flatsome_levels; $level++ ) {
        $flatsome_mobile_sidebar_classes[] = "mobile-sidebar-levels-{$level}";
    }
}

$logo_mod = get_theme_mod( 'site_logo' );
if ( is_numeric( $logo_mod ) ) {
    $logo_url = hpo_get_image_url( (int) $logo_mod, 'large', HPO_THEME_URI . '/assets/images/logo.png' );
} elseif ( is_string( $logo_mod ) && '' !== trim( $logo_mod ) ) {
    $logo_url = $logo_mod;
} else {
    $logo_url = HPO_THEME_URI . '/assets/images/logo.png';
}

$btn1_text   = get_theme_mod( 'header_button_1', 'Đăng nhập' );
$btn1_link   = get_theme_mod( 'header_button_1_link', 'https://gateway.hpo.edu.vn/signin' );
$btn1_target = get_theme_mod( 'header_button_1_link_target', '_self' );
$btn2_text   = get_theme_mod( 'header_button_2', 'Đăng ký học' );
$btn2_link   = get_theme_mod( 'header_button_2_link', 'https://gateway.hpo.edu.vn/signup' );
$btn2_target = get_theme_mod( 'header_button_2_link_target', '_self' );

if ( function_exists( 'flatsome_smart_links' ) ) {
    $btn1_link = flatsome_smart_links( $btn1_link );
    $btn2_link = flatsome_smart_links( $btn2_link );
}
?>
<div id="main-menu" class="<?php echo esc_attr( implode( ' ', $flatsome_mobile_sidebar_classes ) ); ?>"<?php echo $flatsome_levels ? ' data-levels="' . esc_attr( $flatsome_levels ) . '"' : ''; ?>>

  <?php do_action( 'flatsome_before_sidebar_menu' ); ?>

  <div class="sidebar-menu mobile-menu-panel no-scrollbar <?php if ( 'center' === $flatsome_mobile_overlay ) echo 'text-center'; ?>">

    <div class="mobile-menu-head hpo-mobile-menu-head">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
        <div class="logo-mark">
          <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
        </div>
      </a>
      <button type="button" class="mobile-menu-close" id="hpoMobileClose" aria-label="<?php esc_attr_e( 'Đóng menu', 'flatsome-child' ); ?>">×</button>
    </div>

    <?php do_action( 'flatsome_before_sidebar_menu_elements' ); ?>

    <ul class="<?php echo esc_attr( implode( ' ', $flatsome_nav_classes ) ); ?>" data-tab="1">
      <?php flatsome_header_elements( 'mobile_sidebar', 'sidebar' ); ?>
    </ul>

    <div class="mobile-menu-foot hpo-mobile-menu-foot">
      <a href="tel:02836362362" class="btn btn-outline">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z" />
        </svg>
        <span>028.36.362.362</span>
      </a>
      <a href="<?php echo esc_url( $btn2_link ?: 'https://gateway.hpo.edu.vn/signup' ); ?>"<?php echo ( '_blank' === $btn2_target ) ? ' target="_blank" rel="noopener"' : ''; ?> class="btn btn-primary">
        <span><?php echo esc_html( $btn2_text ?: 'Đăng ký học' ); ?></span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M5 12h14M13 5l7 7-7 7" />
        </svg>
      </a>
      <a href="<?php echo esc_url( $btn1_link ?: 'https://gateway.hpo.edu.vn/signin' ); ?>"<?php echo ( '_blank' === $btn1_target ) ? ' target="_blank" rel="noopener"' : ''; ?> class="btn btn-login">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
          <path d="m10 17 5-5-5-5" />
          <path d="M15 12H3" />
        </svg>
        <span><?php echo esc_html( $btn1_text ?: 'Đăng nhập' ); ?></span>
      </a>
    </div>

    <?php do_action( 'flatsome_after_sidebar_menu_elements' ); ?>

  </div>

  <?php do_action( 'flatsome_after_sidebar_menu' ); ?>

</div>
