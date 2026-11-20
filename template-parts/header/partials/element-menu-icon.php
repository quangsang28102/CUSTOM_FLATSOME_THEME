<?php
/**
 * Menu icon element (HPO 3-bar burger preserving Flatsome off-canvas trigger).
 *
 * @package Flatsome\Templates
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<li class="nav-icon has-icon">
  <a href="#"
     data-open="#main-menu"
     data-pos="<?php echo esc_attr( get_theme_mod( 'mobile_overlay', 'right' ) ); ?>"
     data-bg="main-menu-overlay"
     data-color="<?php echo esc_attr( get_theme_mod( 'mobile_overlay_color', '' ) ); ?>"
     class="nav-burger"
     id="burger"
     aria-label="<?php esc_attr_e( 'Mở menu', 'flatsome-child' ); ?>"
     aria-controls="main-menu"
     aria-expanded="false">
    <span></span><span></span><span></span>
  </a>
</li>
