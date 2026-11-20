<?php
/**
 * Setup, shortcodes, menu filters, and global UI hooks for HPO Flatsome Child Theme.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function hpo_cleanup_wordpress_bloat() {
    // Tắt WP Emoji gây chậm trang
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );

    // Bỏ tạo thẻ <p> tự động trong Contact Form 7 để giữ nguyên cấu trúc HTML gốc
    add_filter( 'wpcf7_autop_or_not', '__return_false' );
}
add_action( 'init', 'hpo_cleanup_wordpress_bloat' );

// Gỡ CSS Gutenberg Block trên Frontend nếu trang dùng hoàn toàn UX Builder
add_action( 'wp_enqueue_scripts', function() {
    if ( ! is_single() ) {
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
    }
}, 100 );

/**
 * Unhook WooCommerce footer payment icons (parent loads WC hooks after child functions.php).
 */
add_action( 'after_setup_theme', function() {
    remove_action( 'flatsome_absolute_footer_secondary', 'flatsome_footer_payment_icons', 10 );
}, 20 );

/**
 * Helper: Check whether a menu item points to the site home URL.
 */
function hpo_is_home_menu_item( $item ) {
    if ( empty( $item ) || empty( $item->url ) ) {
        return false;
    }
    $item_url = untrailingslashit( strtok( $item->url, '?#' ) );
    $home_url = untrailingslashit( home_url( '/' ) );
    return ( $item_url === $home_url ) || in_array( 'menu-item-home', (array) $item->classes, true );
}

/**
 * Utility Shortcode: [hpo_topbar_left]
 */
function hpo_shortcode_topbar_left( $atts ) {
    $a = shortcode_atts( array(
        'address' => '176 Thế Lữ, Tân Nhựt, TP. Hồ Chí Minh',
        'hours'   => 'T2 — T7: 7h30 — 17h30',
    ), $atts, 'hpo_topbar_left' );

    ob_start();
    ?>
    <div class="hpo-topbar-left-wrap topbar-left">
      <span class="topbar-item">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
          <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
          <circle cx="12" cy="10" r="3" />
        </svg>
        <span><?php echo esc_html( $a['address'] ); ?></span>
      </span>
      <span class="topbar-item hpo-topbar-hours">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
          <circle cx="12" cy="12" r="10" />
          <polyline points="12 6 12 12 16 14" />
        </svg>
        <span><?php echo esc_html( $a['hours'] ); ?></span>
      </span>
    </div>
    <?php
    return trim( ob_get_clean() );
}
add_shortcode( 'hpo_topbar_left', 'hpo_shortcode_topbar_left' );

/**
 * Utility Shortcode: [hpo_topbar_right]
 */
function hpo_shortcode_topbar_right( $atts ) {
    $a = shortcode_atts( array(
        'phone'    => '028.36.362.362',
        'tel'      => '02836362362',
        'email'    => 'tuyensinh@hpo.edu.vn',
        'facebook' => 'https://www.facebook.com/profile.php?id=61579767334341',
        'youtube'  => 'https://youtube.com/@hiepphat2727',
        'tiktok'   => 'https://hpo.edu.vn/thong-bao',
    ), $atts, 'hpo_topbar_right' );

    $tel_href = 'tel:' . preg_replace( '/[^0-9+]/', '', $a['tel'] );

    ob_start();
    ?>
    <div class="hpo-topbar-right-wrap topbar-right">
      <a href="<?php echo esc_attr( $tel_href ); ?>" class="topbar-item topbar-hotline">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z" />
        </svg>
        <span>Tổng đài: <?php echo esc_html( $a['phone'] ); ?></span>
      </a>
      <a href="mailto:<?php echo esc_attr( $a['email'] ); ?>" class="topbar-item">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
          <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
          <polyline points="22,6 12,13 2,6" />
        </svg>
        <span><?php echo esc_html( $a['email'] ); ?></span>
      </a>
      <div class="topbar-social">
        <?php if ( ! empty( $a['facebook'] ) ) : ?>
        <a href="<?php echo esc_url( $a['facebook'] ); ?>" target="_blank" rel="noopener" aria-label="Facebook">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
          </svg>
        </a>
        <?php endif; ?>
        <?php if ( ! empty( $a['youtube'] ) ) : ?>
        <a href="<?php echo esc_url( $a['youtube'] ); ?>" target="_blank" rel="noopener" aria-label="YouTube">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58zM9.75 15.02V8.98L15.5 12l-5.75 3.02z" />
          </svg>
        </a>
        <?php endif; ?>
        <?php if ( ! empty( $a['tiktok'] ) ) : ?>
        <a href="<?php echo esc_url( $a['tiktok'] ); ?>" target="_blank" rel="noopener" aria-label="TikTok">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.34-6.34V8.69a8.29 8.29 0 0 0 4.83 1.54V6.79a4.85 4.85 0 0 1-1.07-.1z" />
          </svg>
        </a>
        <?php endif; ?>
      </div>
    </div>
    <?php
    return trim( ob_get_clean() );
}
add_shortcode( 'hpo_topbar_right', 'hpo_shortcode_topbar_right' );

/**
 * Utility Shortcode: [hpo_nav_phone]
 */
function hpo_shortcode_nav_phone( $atts ) {
    $a = shortcode_atts( array(
        'label' => 'Tổng đài',
        'phone' => '028.36.362.362',
        'tel'   => '02836362362',
    ), $atts, 'hpo_nav_phone' );

    $tel_href = 'tel:' . preg_replace( '/[^0-9+]/', '', $a['tel'] );

    ob_start();
    ?>
    <a href="<?php echo esc_attr( $tel_href ); ?>" class="nav-phone" aria-label="<?php echo esc_attr( $a['label'] . ': ' . $a['phone'] ); ?>">
      <span class="nav-phone-icon">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z" />
        </svg>
      </span>
      <span class="nav-phone-text">
        <small><?php echo esc_html( $a['label'] ); ?></small>
        <strong><?php echo esc_html( $a['phone'] ); ?></strong>
      </span>
    </a>
    <?php
    return trim( ob_get_clean() );
}
add_shortcode( 'hpo_nav_phone', 'hpo_shortcode_nav_phone' );

/**
 * Filter WP Menu <li> classes for HPO primary & mobile menus.
 */
function hpo_nav_menu_css_class( $classes, $item, $args, $depth ) {
    $theme_location = isset( $args->theme_location ) ? $args->theme_location : '';
    if ( ! in_array( $theme_location, array( 'primary', 'primary_mobile' ), true ) ) {
        return $classes;
    }

    if ( 0 === (int) $depth ) {
        $classes[] = 'nav-item';
        if ( hpo_is_home_menu_item( $item ) ) {
            $classes[] = 'hpo-nav-home-item';
            if ( is_front_page() ) {
                $classes[] = 'active';
            }
        }
    }

    return array_unique( $classes );
}
add_filter( 'nav_menu_css_class', 'hpo_nav_menu_css_class', 10, 4 );

/**
 * Filter WP Menu <a> attributes.
 * IMPORTANT: Never set $atts['class'] for FlatsomeNavDropdown depth-0 items because
 * FlatsomeNavDropdown::start_el() appends ` class="nav-top-link"` afterwards.
 */
function hpo_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
    $theme_location = isset( $args->theme_location ) ? $args->theme_location : '';
    if ( ! in_array( $theme_location, array( 'primary', 'primary_mobile' ), true ) ) {
        return $atts;
    }

    $is_home = hpo_is_home_menu_item( $item );
    if ( in_array( 'current-menu-item', (array) $item->classes, true ) || ( $is_home && is_front_page() ) ) {
        $atts['aria-current'] = 'page';
    }

    if ( 0 === (int) $depth && isset( $args->walker ) && class_exists( 'FlatsomeNavDropdown' ) && $args->walker instanceof FlatsomeNavDropdown ) {
        if ( $is_home ) {
            $atts['aria-label'] = 'Cổng thông tin điện tử – Trang chủ';
            $atts['title']      = 'Trang chủ';
        }
    }

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'hpo_nav_menu_link_attributes', 10, 4 );

/**
 * Filter WP Menu item titles:
 * - FlatsomeNavDropdown: Home SVG + .nav-home-label, .nav-label[data-label], and .dd-dot for children.
 * - FlatsomeNavSidebar: Home item uses "Trang chủ" label.
 */
function hpo_nav_menu_item_title( $title, $item, $args, $depth ) {
    if ( ! isset( $args->walker ) ) {
        return $title;
    }

    $is_home = hpo_is_home_menu_item( $item );

    if ( class_exists( 'FlatsomeNavDropdown' ) && $args->walker instanceof FlatsomeNavDropdown ) {
        if ( 0 === (int) $depth ) {
            if ( $is_home ) {
                $home_svg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m3 10 9-7 9 7" /><path d="M5.5 9v11h13V9M9.5 20v-6h5v6" /></svg>';
                return $home_svg . '<span class="nav-home-label">' . esc_html( wp_strip_all_tags( $title ) ) . '</span>';
            }
            $plain = wp_strip_all_tags( $title );
            return '<span class="nav-label" data-label="' . esc_attr( $plain ) . '">' . esc_html( $plain ) . '</span>';
        }

        return '<span class="dd-dot" aria-hidden="true"></span>' . esc_html( wp_strip_all_tags( $title ) );
    }

    if ( class_exists( 'FlatsomeNavSidebar' ) && $args->walker instanceof FlatsomeNavSidebar ) {
        if ( 0 === (int) $depth && $is_home ) {
            return esc_html( wp_strip_all_tags( $title ) );
        }
    }

    return $title;
}
add_filter( 'nav_menu_item_title', 'hpo_nav_menu_item_title', 10, 4 );

/**
 * Fallback: ensure mobile drawer menu contains "Thông tin" (https://hpo.edu.vn/thong-tin/)
 * if primary_mobile menu is not assigned or lacks the item.
 */
function hpo_mobile_menu_fallback_thong_tin( $items, $args ) {
    if ( ! isset( $args->walker ) || ! class_exists( 'FlatsomeNavSidebar' ) || ! ( $args->walker instanceof FlatsomeNavSidebar ) ) {
        return $items;
    }

    foreach ( $items as $existing ) {
        if ( isset( $existing->url ) && false !== strpos( $existing->url, 'thong-tin' ) ) {
            return $items;
        }
    }

    $post_obj = (object) array(
        'ID'                    => 999001,
        'db_id'                 => 999001,
        'menu_item_parent'      => '0',
        'object_id'             => 999001,
        'object'                => 'custom',
        'type'                  => 'custom',
        'type_label'            => 'Custom Link',
        'title'                 => 'Thông tin',
        'url'                   => 'https://hpo.edu.vn/thong-tin/',
        'target'                => '',
        'attr_title'            => '',
        'description'           => '',
        'classes'               => array( 'menu-item', 'menu-item-type-custom', 'menu-item-object-custom', 'hpo-mobile-thong-tin' ),
        'xfn'                   => '',
        'current'               => false,
        'current_item_ancestor' => false,
        'current_item_parent'   => false,
        'menu_order'            => count( $items ) + 1,
        'post_type'             => 'nav_menu_item',
        'status'                => 'publish',
    );
    $synthetic = new WP_Post( $post_obj );

    $result   = array();
    $inserted = false;
    foreach ( $items as $item ) {
        if ( ! $inserted && 0 === (int) $item->menu_item_parent && false !== mb_stripos( $item->title, 'Ôn tập' ) ) {
            $result[] = $synthetic;
            $inserted = true;
        }
        $result[] = $item;
    }
    if ( ! $inserted ) {
        $result[] = $synthetic;
    }

    return $result;
}
add_filter( 'wp_nav_menu_objects', 'hpo_mobile_menu_fallback_thong_tin', 10, 2 );

/**
 * Render Global Floating Actions Dock (Gọi tư vấn, Đăng ký học, Lên đầu trang).
 */
function hpo_render_floating_actions() {
    $register_url = get_theme_mod( 'header_button_2_link', 'https://gateway.hpo.edu.vn/signup' );
    ?>
    <div class="floats" aria-label="Hỗ trợ nhanh">
      <button type="button" class="float-btn float-top" title="Lên đầu trang" aria-label="Lên đầu trang">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <polyline points="18 15 12 9 6 15" />
        </svg>
      </button>
      <a href="tel:02836362362" class="float-btn float-phone" title="Gọi tư vấn" aria-label="Gọi tư vấn">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z" />
        </svg>
        <span class="float-label">Gọi tư vấn</span>
      </a>
      <a href="<?php echo esc_url( $register_url ); ?>" class="float-btn float-register" title="Đăng ký học" aria-label="Đăng ký học">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
          <circle cx="9" cy="7" r="4" />
          <line x1="20" y1="8" x2="20" y2="14" />
          <line x1="23" y1="11" x2="17" y2="11" />
        </svg>
        <span class="float-label">Đăng ký học</span>
      </a>
    </div>
    <?php
}
add_action( 'wp_footer', 'hpo_render_floating_actions', 20 );

/**
 * Dynamic overrides for Sticky Header, Drawer Close & Footer Branch Headings.
 */
add_action( 'wp_enqueue_scripts', function() {
    $custom_css = '
        html body .header-wrapper.stuck { transform: none !important; }
        @media (min-width: 783px) { body.admin-bar .header-wrapper.stuck { top: 32px !important; } }
        .mfp-wrap.mfp-removing, .mfp-wrap.mfp-removing .mfp-content, .mfp-wrap.mfp-removing #main-menu { display: none !important; visibility: hidden !important; }
        html body .footer-loc strong { text-transform: none !important; }
        @media screen and (max-width: 849px) {
            html body div#wpadminbar, html #wpadminbar, body #wpadminbar { display: block !important; }
        }
        @media screen and (max-width: 782px) {
            html { margin-top: 46px !important; }
            body.admin-bar #header { margin-top: 46px !important; }
            body.admin-bar .header-wrapper.stuck { top: 46px !important; }
            body.admin-bar #main-menu { top: 46px !important; height: calc(100% - 46px) !important; }
            body.admin-bar .mfp-wrap.off-canvas .mfp-content { top: 46px !important; }
            body.admin-bar button.mfp-close { top: 46px !important; }
        }
        @media screen and (min-width: 783px) and (max-width: 849px) {
            html { margin-top: 32px !important; }
            body.admin-bar #header { margin-top: 32px !important; }
            body.admin-bar .header-wrapper.stuck { top: 32px !important; }
            body.admin-bar #main-menu { top: 32px !important; height: calc(100% - 32px) !important; }
            body.admin-bar .mfp-wrap.off-canvas .mfp-content { top: 32px !important; }
            body.admin-bar button.mfp-close { top: 32px !important; }
        }
    ';
    wp_add_inline_style( 'hpo-elements', $custom_css );
}, 99 );

/**
 * Filter shortcode outputs to ensure eager image loading for above-the-fold/critical assets.
 */
add_filter( 'do_shortcode_tag', function( $output, $tag ) {
    if ( 'hpo_platform' === $tag ) {
        $output = preg_replace(
            '/(<img[^>]*?thuc-hanh-mo-phong-sa-hinh\.webp[^>]*?)(loading="lazy"[^>]*?decoding="async"|loading="lazy")/i',
            '$1data-skip-lazy="1" loading="eager"',
            $output
        );
    }
    return $output;
}, 20, 2 );

