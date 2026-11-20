<?php
/**
 * Module: M3 Showcase Sections & Shared Image Lightbox (#imgLb)
 * Covers Features F10–F14: Awards Slider, Brand Protection Certificates,
 * Technical Infrastructure Stage, Intro Video, and Shared Lightbox.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'hpo_showcase_resolve_image' ) ) {
    /**
     * Resolve an image attribute (WP Attachment ID, URL, or relative theme path)
     * with a fallback path under assets/images/.
     *
     * @param int|string $value
     * @param string     $fallback_rel_path
     * @return string
     */
    function hpo_showcase_resolve_image( $value, $fallback_rel_path ) {
        if ( is_numeric( $value ) && (int) $value > 0 ) {
            $attachment_url = wp_get_attachment_image_url( (int) $value, 'full' );
            if ( ! empty( $attachment_url ) ) {
                return $attachment_url;
            }
        } elseif ( is_string( $value ) && trim( $value ) !== '' ) {
            $trimmed = trim( $value );
            if ( preg_match( '#^(https?:)?//#i', $trimmed ) || 0 === strpos( $trimmed, '/' ) || 0 === strpos( $trimmed, 'data:' ) ) {
                return $trimmed;
            }
            if ( 0 === strpos( $trimmed, 'assets/' ) ) {
                return HPO_THEME_URI . '/' . ltrim( $trimmed, '/' );
            }
            return HPO_THEME_URI . '/assets/images/' . ltrim( $trimmed, '/' );
        }

        return HPO_THEME_URI . '/assets/images/' . ltrim( $fallback_rel_path, '/' );
    }
}

/**
 * Enqueue M3 showcase CSS (after hpo-elements) and deferred JS.
 */
function hpo_showcase_enqueue_assets() {
    wp_enqueue_style(
        'hpo-showcase',
        HPO_THEME_URI . '/assets/css/hpo-showcase.css',
        array( 'hpo-elements' ),
        hpo_asset_version( '/assets/css/hpo-showcase.css' )
    );

    wp_enqueue_script(
        'hpo-showcase-js',
        HPO_THEME_URI . '/assets/js/hpo-showcase.js',
        array(),
        hpo_asset_version( '/assets/js/hpo-showcase.js' ),
        array(
            'in_footer' => true,
            'strategy'  => 'defer',
        )
    );
}
add_action( 'hpo_enqueue_module_assets', 'hpo_showcase_enqueue_assets' );

/**
 * Render global #imgLb.img-lb shared image lightbox once in wp_footer.
 */
function hpo_showcase_render_img_lightbox() {
    static $rendered = false;
    if ( $rendered || is_admin() ) {
        return;
    }
    $rendered = true;
    ?>
    <div
      class="img-lb"
      id="imgLb"
      role="dialog"
      aria-modal="true"
      aria-label="Xem ảnh"
    >
      <button
        type="button"
        class="img-lb-close"
        id="imgLbClose"
        aria-label="Đóng (ESC)"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round">
          <line x1="18" y1="6" x2="6" y2="18" />
          <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
      </button>
      <button
        type="button"
        class="img-lb-prev"
        id="imgLbPrev"
        aria-label="Ảnh trước (←)"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="15 18 9 12 15 6" />
        </svg>
      </button>
      <button
        type="button"
        class="img-lb-next"
        id="imgLbNext"
        aria-label="Ảnh kế (→)"
      >
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="9 18 15 12 9 6" />
        </svg>
      </button>
      <div class="img-lb-content">
        <img class="img-lb-img" id="imgLbImg" src="" alt="" />
        <div class="img-lb-counter" id="imgLbCounter">1 / 1</div>
      </div>
    </div>
    <?php
}
add_action( 'wp_footer', 'hpo_showcase_render_img_lightbox', 25 );
