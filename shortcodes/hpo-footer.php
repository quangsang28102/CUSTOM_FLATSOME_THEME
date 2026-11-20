<?php
/**
 * Shortcode Render: [hpo_footer]
 * Renders main HPO footer grid inside UX Block 25 (KSES-safe for SVGs & iframe).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function hpo_shortcode_footer( $atts ) {
    $a = shortcode_atts( array(
        'logo_image'       => '',
        'company_license'  => "Công ty TNHH Ô Tô Hiệp Phát\nGCNKD số 0309987279, do Sở KH&ĐT TP.HCM\ncấp lần đầu ngày 11/05/2010.",
        'address'          => '176 Thế Lữ, Ấp 1, xã Tân Nhựt, TP. Hồ Chí Minh',
        'phone'            => '028.36.362.362',
        'tel'              => '02836362362',
        'email'            => 'tuyensinh@hpo.edu.vn',
        'facebook_url'     => 'https://www.facebook.com/profile.php?id=61579767334341',
        'youtube_url'      => 'https://youtube.com/@hiepphat2727',
        'tiktok_url'       => 'https://hpo.edu.vn/thong-bao',
        'branches_heading' => 'Cơ sở',
        'branch1_title'    => '1. Trụ sở chính',
        'branch1_address'  => '176 Thế Lữ, Tân Nhựt, TP. HCM',
        'branch1_phone'    => '028.36.362.362',
        'branch2_title'    => '2. Cơ sở Vĩnh Lộc',
        'branch2_address'  => '271 Đường số 1, Phường Bình Tân',
        'branch2_phone'    => '028.36.201.199',
        'branch3_title'    => '3. VP Tuyển Sinh',
        'branch3_address'  => '276 Minh Phụng, Phường Minh Phụng, TP. HCM',
        'branch3_phone'    => '0912.799.129',
        'apps_heading'     => 'Tải ứng dụng',
        'app_desc'         => 'Trải nghiệm ngay trên Hiệp Phát Edu.',
        'chplay_url'       => 'https://play.google.com/store/apps/details?id=com.hpo.edugo',
        'chplay_image'     => '',
        'appstore_url'     => 'https://apps.apple.com/vn/app/hiep-phat-edu/id6748065752',
        'appstore_image'   => '',
        'map_heading'      => 'Bản đồ',
        'map_embed_url'    => 'https://www.google.com/maps?q=C%C3%B4ng%20ty%20TNHH%20%C3%94%20T%C3%B4%20Hi%E1%BB%87p%20Ph%C3%A1t%20176%20%C4%90%C6%B0%E1%BB%9Dng%20Th%E1%BA%BF%20L%E1%BB%AF%20T%C3%A2n%20Nh%E1%BB%B1t%20TP.HCM&output=embed',
        'bct_url'          => 'http://online.gov.vn/Website/chi-tiet-135372',
        'bct_image'        => '',
    ), $atts, 'hpo_footer' );

    $logo_url     = hpo_get_image_url( $a['logo_image'], 'full', HPO_THEME_URI . '/assets/images/logo-white.png' );
    $chplay_img   = hpo_get_image_url( $a['chplay_image'], 'full', HPO_THEME_URI . '/assets/images/CHPlay.png' );
    $appstore_img = hpo_get_image_url( $a['appstore_image'], 'full', HPO_THEME_URI . '/assets/images/AppStore.png' );
    $bct_img      = hpo_get_image_url( $a['bct_image'], 'full', HPO_THEME_URI . '/assets/images/bo-cong-thuong.png' );

    $main_tel = 'tel:' . preg_replace( '/[^0-9+]/', '', $a['tel'] );
    $branches = array(
        array(
            'title'   => $a['branch1_title'],
            'address' => $a['branch1_address'],
            'phone'   => $a['branch1_phone'],
        ),
        array(
            'title'   => $a['branch2_title'],
            'address' => $a['branch2_address'],
            'phone'   => $a['branch2_phone'],
        ),
        array(
            'title'   => $a['branch3_title'],
            'address' => $a['branch3_address'],
            'phone'   => $a['branch3_phone'],
        ),
    );

    $license_html = nl2br( wp_kses_post( str_replace( array( '\n', '|' ), "\n", $a['company_license'] ) ) );

    ob_start();
    ?>
    <div class="hpo-footer-wrapper footer" id="lien-he">
      <div class="container">
        <div class="footer-grid">
          <div class="footer-brand">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" aria-label="Hiệp Phát">
              <div class="logo-mark">
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="Hiệp Phát" />
              </div>
            </a>
            <p class="footer-desc"><?php echo $license_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
            <div class="footer-contact">
              <div class="footer-contact-item">
                <span class="footer-contact-icon">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                    <circle cx="12" cy="10" r="3" />
                  </svg>
                </span>
                <span><?php echo esc_html( $a['address'] ); ?></span>
              </div>
              <div class="footer-contact-item">
                <span class="footer-contact-icon">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                  </svg>
                </span>
                <a href="<?php echo esc_attr( $main_tel ); ?>"><?php echo esc_html( $a['phone'] ); ?></a>
              </div>
              <div class="footer-contact-item">
                <span class="footer-contact-icon">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                    <polyline points="22,6 12,13 2,6" />
                  </svg>
                </span>
                <a href="mailto:<?php echo esc_attr( $a['email'] ); ?>"><?php echo esc_html( $a['email'] ); ?></a>
              </div>
            </div>
            <div class="footer-social">
              <?php if ( ! empty( $a['facebook_url'] ) ) : ?>
              <a href="<?php echo esc_url( $a['facebook_url'] ); ?>" target="_blank" rel="noopener" aria-label="Facebook">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                </svg>
              </a>
              <?php endif; ?>
              <?php if ( ! empty( $a['youtube_url'] ) ) : ?>
              <a href="<?php echo esc_url( $a['youtube_url'] ); ?>" target="_blank" rel="noopener" aria-label="YouTube">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58zM9.75 15.02V8.98L15.5 12l-5.75 3.02z" />
                </svg>
              </a>
              <?php endif; ?>
              <?php if ( ! empty( $a['tiktok_url'] ) ) : ?>
              <a href="<?php echo esc_url( $a['tiktok_url'] ); ?>" target="_blank" rel="noopener" aria-label="TikTok">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.34-6.34V8.69a8.29 8.29 0 0 0 4.83 1.54V6.79a4.85 4.85 0 0 1-1.07-.1z" />
                </svg>
              </a>
              <?php endif; ?>
            </div>
          </div>

          <div class="footer-col">
            <h4><?php echo esc_html( $a['branches_heading'] ); ?></h4>
            <?php foreach ( $branches as $branch ) : ?>
              <?php if ( ! empty( $branch['title'] ) ) : ?>
              <div class="footer-loc">
                <strong><?php echo esc_html( $branch['title'] ); ?></strong>
                <p><?php echo esc_html( $branch['address'] ); ?></p>
                <a href="<?php echo esc_attr( 'tel:' . preg_replace( '/[^0-9+]/', '', $branch['phone'] ) ); ?>"><?php echo esc_html( $branch['phone'] ); ?></a>
              </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>

          <div class="footer-col">
            <h4><?php echo esc_html( $a['apps_heading'] ); ?></h4>
            <p class="footer-app-desc"><?php echo esc_html( $a['app_desc'] ); ?></p>
            <div class="footer-app">
              <?php if ( ! empty( $a['chplay_url'] ) ) : ?>
              <a href="<?php echo esc_url( $a['chplay_url'] ); ?>" target="_blank" rel="noopener" data-badge="android" aria-label="Tải Hiệp Phát Edu trên Google Play">
                <img src="<?php echo esc_url( $chplay_img ); ?>" alt="Tải trên Google Play" />
              </a>
              <?php endif; ?>
              <?php if ( ! empty( $a['appstore_url'] ) ) : ?>
              <a href="<?php echo esc_url( $a['appstore_url'] ); ?>" target="_blank" rel="noopener" data-badge="ios" aria-label="Tải Hiệp Phát Edu trên App Store">
                <img src="<?php echo esc_url( $appstore_img ); ?>" alt="Tải trên App Store" />
              </a>
              <?php endif; ?>
            </div>
          </div>

          <div class="footer-col footer-map-col">
            <h4><?php echo esc_html( $a['map_heading'] ); ?></h4>
            <?php if ( ! empty( $a['map_embed_url'] ) ) : ?>
            <div class="footer-map">
              <iframe
                title="Bản đồ Công ty TNHH Ô Tô Hiệp Phát"
                src="<?php echo esc_url( $a['map_embed_url'] ); ?>"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen
              ></iframe>
            </div>
            <?php endif; ?>
            <?php if ( ! empty( $a['bct_url'] ) ) : ?>
            <a class="footer-gov" href="<?php echo esc_url( $a['bct_url'] ); ?>" target="_blank" rel="noopener" aria-label="Thông tin website Hiệp Phát trên Bộ Công Thương">
              <img src="<?php echo esc_url( $bct_img ); ?>" alt="Đã thông báo Bộ Công Thương" width="160" />
            </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <?php
    return trim( ob_get_clean() );
}
add_shortcode( 'hpo_footer', 'hpo_shortcode_footer' );
