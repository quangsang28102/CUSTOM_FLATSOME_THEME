<?php
/**
 * Flatsome Child Theme Functions
 * Project: HPO
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'HPO_THEME_DIR', get_stylesheet_directory() );
define( 'HPO_THEME_URI', get_stylesheet_directory_uri() );
define( 'HPO_VERSION', '1.1.0' );

// 1. Nạp cấu hình hệ thống, Enqueue Assets, Helpers & CPT
require_once HPO_THEME_DIR . '/inc/setup.php';
require_once HPO_THEME_DIR . '/inc/enqueue.php';
require_once HPO_THEME_DIR . '/inc/helpers.php';

if ( file_exists( HPO_THEME_DIR . '/inc/cpt-acf.php' ) ) {
    require_once HPO_THEME_DIR . '/inc/cpt-acf.php';
}

// 2. Tự động nạp các module tính năng (M2–M5)
$hpo_modules = glob( HPO_THEME_DIR . '/inc/modules/*.php' );
if ( is_array( $hpo_modules ) ) {
    foreach ( $hpo_modules as $module_file ) {
        require_once $module_file;
    }
}

// 3. Tự động nạp tất cả các file Shortcode Render trong thư mục /shortcodes/
$hpo_shortcodes = glob( HPO_THEME_DIR . '/shortcodes/*.php' );
if ( is_array( $hpo_shortcodes ) ) {
    foreach ( $hpo_shortcodes as $shortcode_file ) {
        require_once $shortcode_file;
    }
}

// 4. Tự động nạp tất cả cấu hình UX Builder Elements trong thư mục /inc/ux-elements/
add_action( 'ux_builder_setup', function() {
    if ( ! function_exists( 'add_ux_builder_shortcode' ) ) {
        return;
    }
    $hpo_ux_elements = glob( HPO_THEME_DIR . '/inc/ux-elements/*.php' );
    if ( is_array( $hpo_ux_elements ) ) {
        foreach ( $hpo_ux_elements as $ux_element_file ) {
            require_once $ux_element_file;
        }
    }
});
