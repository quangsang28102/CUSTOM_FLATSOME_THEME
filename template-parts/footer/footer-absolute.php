<?php
/**
 * Absolute footer (HPO 3-column legal bar).
 *
 * @package Flatsome\Templates
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$align = 'small-text-center';
if ( 'center' === get_theme_mod( 'footer_bottom_align', '' ) ) {
    $align = 'text-center';
}

ob_start();
do_action( 'flatsome_absolute_footer_secondary' );
$flatsome_absolute_footer_secondary = trim( ob_get_clean() );

$flatsome_footer_left_text  = trim( (string) get_theme_mod( 'footer_left_text', '© 2025 Công Ty TNHH Ô Tô Hiệp Phát. Tất cả quyền được bảo lưu.' ) );
$flatsome_footer_right_text = trim( (string) get_theme_mod( 'footer_right_text', 'GCNKD: 0309987279 — Cấp ngày 11/05/2010<br />Sở KH&amp;ĐT TP. Hồ Chí Minh' ) );
?>
<div class="absolute-footer <?php echo esc_attr( get_theme_mod( 'footer_bottom_text', 'dark' ) ); ?> <?php echo esc_attr( $align ); ?>">
  <div class="container">
    <div class="footer-bottom hpo-footer-bottom">
      <div class="footer-primary">
        <div class="copyright-footer">
          <?php echo wp_kses_post( do_shortcode( $flatsome_footer_left_text ) ); ?>
        </div>
        <?php do_action( 'flatsome_absolute_footer_primary' ); ?>
      </div>

      <div class="footer-bottom-links">
        <?php if ( has_nav_menu( 'footer' ) ) : ?>
          <?php
          wp_nav_menu( array(
              'theme_location' => 'footer',
              'menu_class'     => 'links footer-nav',
              'container'      => false,
              'depth'          => 1,
              'fallback_cb'    => false,
          ) );
          ?>
        <?php else : ?>
          <a href="<?php echo esc_url( home_url( '/chinh-sach-bao-mat/' ) ); ?>">Chính sách bảo mật</a>
        <?php endif; ?>
      </div>

      <div class="footer-bottom-legal footer-secondary">
        <?php if ( $flatsome_footer_right_text ) : ?>
          <span class="footer-text"><?php echo wp_kses_post( do_shortcode( $flatsome_footer_right_text ) ); ?></span>
        <?php endif; ?>
        <?php if ( $flatsome_absolute_footer_secondary ) : ?>
          <?php echo $flatsome_absolute_footer_secondary; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
