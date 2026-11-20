<?php
/**
 * Enqueue styles and scripts for HPO Flatsome Child Theme.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'hpo_asset_version' ) ) {
    function hpo_asset_version( $relative_path ) {
        $full_path = HPO_THEME_DIR . $relative_path;
        return file_exists( $full_path ) ? (string) filemtime( $full_path ) : HPO_VERSION;
    }
}

function hpo_enqueue_scripts() {
    // 1. CSS Layer Order AFTER flatsome-main
    wp_enqueue_style(
        'hpo-variables',
        HPO_THEME_URI . '/assets/css/hpo-variables.css',
        array( 'flatsome-main' ),
        hpo_asset_version( '/assets/css/hpo-variables.css' )
    );

    wp_enqueue_style(
        'hpo-common',
        HPO_THEME_URI . '/assets/css/hpo-common.css',
        array( 'hpo-variables' ),
        hpo_asset_version( '/assets/css/hpo-common.css' )
    );

    wp_enqueue_style(
        'hpo-ds-headings',
        HPO_THEME_URI . '/assets/css/hpo-ds-headings.css',
        array( 'hpo-common' ),
        hpo_asset_version( '/assets/css/hpo-ds-headings.css' )
    );

    wp_enqueue_style(
        'hpo-elements',
        HPO_THEME_URI . '/assets/css/hpo-elements.css',
        array( 'hpo-ds-headings' ),
        hpo_asset_version( '/assets/css/hpo-elements.css' )
    );

    // 2. Core JS in footer with defer
    wp_enqueue_script(
        'flatsome-chunk-popups',
        get_template_directory_uri() . '/assets/js/chunk.popups.js',
        array( 'flatsome-js' ),
        '3.19.11',
        true
    );

    wp_enqueue_script(
        'hpo-main-js',
        HPO_THEME_URI . '/assets/js/hpo-main.js',
        array( 'jquery' ),
        hpo_asset_version( '/assets/js/hpo-main.js' ),
        array(
            'in_footer' => true,
            'strategy'  => 'defer',
        )
    );

    wp_enqueue_script(
        'hpo-header-footer-js',
        HPO_THEME_URI . '/assets/js/hpo-header-footer.js',
        array(),
        hpo_asset_version( '/assets/js/hpo-header-footer.js' ),
        array(
            'in_footer' => true,
            'strategy'  => 'defer',
        )
    );

    // 3. Hook for M2-M5 module stylesheets (dep: array('hpo-elements')) & deferred JS
    do_action( 'hpo_enqueue_module_assets' );
}
add_action( 'wp_enqueue_scripts', 'hpo_enqueue_scripts', 20 );
