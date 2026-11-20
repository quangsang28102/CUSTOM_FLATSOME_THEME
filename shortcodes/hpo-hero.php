<?php
/**
 * Shortcode: [hpo_hero]
 * Render Frontend for HPO Hero Slider
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function hpo_hero_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'welcome_text'   => 'Chào mừng các bạn đến với Hiệp Phát',
        'title_line_1'   => 'KỶ NGUYÊN AI',
        'title_line_2'   => 'TRONG ĐÀO TẠO LÁI XE',
        'description'    => 'Hệ sinh thái chuyển đổi số toàn diện cho đào tạo lái xe ô tô thông minh',
        'detail_text'    => '',
        'ring_image'     => '',
        'banner_heading' => 'GIỚI THIỆU CÔNG TY',
        'banner_motto'   => 'Đào tạo và sát hạch cùng một địa điểm',
        'banner_image'   => '',
        'website_url'    => 'https://hpo.edu.vn/',
    ), $atts, 'hpo_hero' );

    // Resolve Ring Image
    $ring_url = HPO_THEME_URI . '/assets/images/hero/hpo-system-circle.webp';
    if ( ! empty( $atts['ring_image'] ) ) {
        $custom_ring = wp_get_attachment_image_url( $atts['ring_image'], 'full' );
        if ( $custom_ring ) {
            $ring_url = $custom_ring;
        }
    }

    // Resolve Banner Image
    $banner_url = HPO_THEME_URI . '/assets/images/banner/company-campus-gate-building-collage.webp';
    if ( ! empty( $atts['banner_image'] ) ) {
        $custom_banner = wp_get_attachment_image_url( $atts['banner_image'], 'full' );
        if ( $custom_banner ) {
            $banner_url = $custom_banner;
        }
    }

    $facilities_img = HPO_THEME_URI . '/assets/images/banner/h3.png';

    ob_start();
    ?>
    <div class="company-slider" role="region" aria-roledescription="carousel" aria-label="Giới thiệu HPO">
      <div class="company-slider-track" id="companySliderTrack" tabindex="0" aria-label="Vuốt hoặc dùng phím mũi tên để chuyển slide">

        <!-- SLIDE 1: KỶ NGUYÊN AI TRONG ĐÀO TẠO LÁI XE -->
        <section class="hpo-digital-hero is-active" role="group" aria-label="1 / 2: Kỷ nguyên AI trong đào tạo lái xe">
          <div class="hpo-digital-hero-inner">
            <div class="hpo-digital-left">
              <?php if ( ! empty( $atts['welcome_text'] ) ) : ?>
                <p class="hpo-hero-welcome"><?php echo esc_html( $atts['welcome_text'] ); ?></p>
              <?php endif; ?>

              <h1 class="hpo-digital-title">
                <span><?php echo esc_html( $atts['title_line_1'] ); ?></span>
                <span><?php echo esc_html( $atts['title_line_2'] ); ?></span>
              </h1>

              <?php if ( ! empty( $atts['description'] ) ) : ?>
                <p class="hpo-digital-description"><?php echo esc_html( $atts['description'] ); ?></p>
              <?php endif; ?>

              <p class="hpo-digital-detail">
                <?php if ( ! empty( $atts['detail_text'] ) ) : ?>
                  <?php echo wp_kses_post( $atts['detail_text'] ); ?>
                <?php else : ?>
                  Tại Hiệp Phát, chúng tôi đào tạo lái xe ô tô trên nền tảng tích hợp trí tuệ nhân tạo,
                  với <strong class="hpo-class-pill">Hạng B</strong> (Bao gồm số cơ khí (số sàn) và số tự động (xe ô tô điện,...)) và
                  <strong class="hpo-class-pill">Hạng C1</strong>.
                <?php endif; ?>
              </p>

              <!-- HPO System Card -->
              <div class="hpo-sys-card" aria-labelledby="hpoSysTitle">
                <div class="hpo-sys-ring">
                  <img src="<?php echo esc_url( $ring_url ); ?>" alt="Sơ đồ hệ sinh thái HPO" width="362" height="362" />
                  <span class="hpo-sys-sweep" aria-hidden="true"></span>
                  <span class="hpo-sys-ripple" aria-hidden="true"></span>
                  <span class="hpo-sys-ripple hpo-sys-ripple--late" aria-hidden="true"></span>
                  <svg class="hpo-sys-motion" viewBox="0 0 362 362" aria-hidden="true"></svg>
                </div>

                <div class="hpo-sys-info">
                  <p class="hpo-sys-eyebrow">Hệ sinh thái số</p>
                  <h2 class="hpo-sys-title" id="hpoSysTitle">Hệ thống HPO</h2>
                  <p class="hpo-sys-lead">6 thành phần kết nối trên một nền tảng</p>
                  <ul class="hpo-sys-list">
                    <li data-hpo-node="face" tabindex="0">
                      <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 8V5a1 1 0 0 1 1-1h3m8 0h3a1 1 0 0 1 1 1v3m0 8v3a1 1 0 0 1-1 1h-3m-8 0H5a1 1 0 0 1-1-1v-3M9 10h.01M15 10h.01M9.5 15a3.5 3.5 0 0 0 5 0"/>
                      </svg>
                      <span><b>Xác thực khuôn mặt</b><small>Nhận diện học viên khi học</small></span>
                    </li>
                    <li data-hpo-node="cloud" tabindex="0">
                      <svg viewBox="0 0 24 24" aria-hidden="true">
                        <ellipse cx="9.5" cy="5" rx="6.5" ry="2.6"/>
                        <path d="M3 5v12.2c0 1.4 2.8 2.6 6.3 2.6M16 5v5.2M3 11.1c0 1.4 2.9 2.6 6.5 2.6.7 0 1.4 0 2-.1M14.6 21h5.1a2.8 2.8 0 0 0 .3-5.6 3.9 3.9 0 0 0-7.5 1.1 2.3 2.3 0 0 0 2.1 4.5Z"/>
                      </svg>
                      <span><b>Cloud (server)</b><small>Lưu trữ dữ liệu tập trung</small></span>
                    </li>
                    <li data-hpo-node="dat" tabindex="0">
                      <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M5.2 9.6 7 6.3c.3-.5.8-.8 1.4-.8h6.4c.5 0 1 .3 1.3.7l2.5 3.4M3 15.6v-3.3c0-1 .5-1.9 1.4-2.4l.8-.3h13.4l1.9.7c.9.4 1.5 1.2 1.5 2.2v3.1M3 15.6c0 .6.4 1 1 1h1.2M21 15.6c0 .6-.4 1-1 1h-1.2M8.8 16.6h6.4M6.4 9.6l.9 2.3h9.4l.9-2.3M4.4 12.6h2M17.6 12.6h2"/>
                        <circle cx="7" cy="16.8" r="1.8"/>
                        <circle cx="17" cy="16.8" r="1.8"/>
                      </svg>
                      <span><b>DAT</b><small>Giám sát quãng đường thực hành</small></span>
                    </li>
                    <li data-hpo-node="cabin" tabindex="0">
                      <svg viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="12" r="9"/>
                        <circle cx="12" cy="12" r="2"/>
                        <path d="M12 14v7M10 12H3M14 12h7"/>
                      </svg>
                      <span><b>Cabin</b><small>Cabin học lái mô phỏng</small></span>
                    </li>
                    <li data-hpo-node="sim" tabindex="0">
                      <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="2" y="3" width="20" height="14" rx="2"/>
                        <path d="M8 21h8M12 17v4M10 7.5v5l4-2.5z"/>
                      </svg>
                      <span><b>Mô phỏng</b><small>Luyện tình huống giao thông</small></span>
                    </li>
                    <li data-hpo-node="platform" tabindex="0">
                      <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="2" y="4" width="14" height="10" rx="1.5"/>
                        <path d="M6 18h6M9 14v4"/>
                        <rect x="17" y="8" width="5" height="11" rx="1"/>
                      </svg>
                      <span><b>Đa nền tảng</b><small>Học trên mọi thiết bị</small></span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- SLIDE 2: GIỚI THIỆU CÔNG TY -->
        <section class="company-banner" role="group" aria-label="2 / 2: Giới thiệu công ty">
          <div class="company-banner-sheet">
            <header class="company-banner-heading">
              <h2><?php echo esc_html( $atts['banner_heading'] ); ?></h2>
            </header>

            <div class="company-banner-copy">
              <p class="company-banner-motto"><?php echo esc_html( $atts['banner_motto'] ); ?></p>
              <ul>
                <li>Thành lập năm 2010.</li>
                <li>Hoạt động đào tạo lái xe từ năm 2015.</li>
                <li>Phương châm <strong>“Khởi đầu sự nghiệp lái xe an toàn của bạn”</strong>: đào tạo thành công nhiều học viên.</li>
              </ul>
            </div>

            <div class="company-banner-photos" data-img-group="campus" data-img-idx="0" role="button" tabindex="0" aria-label="Bấm để xem ảnh lớn cơ sở đào tạo Hiệp Phát">
              <img class="company-photo-campus" src="<?php echo esc_url( $banner_url ); ?>" alt="Cơ sở đào tạo Hiệp Phát" width="1600" height="900" />
            </div>

            <div class="company-banner-facilities">
              <img class="company-facilities-label" src="<?php echo esc_url( $facilities_img ); ?>" alt="Cơ sở vật chất" width="511" height="84" />
              <div class="company-facilities-details">
                <ul>
                  <li>02 sân tập lái</li>
                  <li>01 sân sát hạch</li>
                </ul>
                <p>Quy chuẩn kỹ thuật Quốc gia về TTSH lái xe cơ giới đường bộ<br /><strong>QCVN 15:2026/BCA</strong> ban hành ngày 29/06/2026</p>
              </div>
            </div>

            <?php if ( ! empty( $atts['website_url'] ) ) : ?>
              <a class="company-banner-website" href="<?php echo esc_url( $atts['website_url'] ); ?>" target="_blank" rel="noopener">
                <span>Website:</span> hpo.edu.vn <span aria-hidden="true">↗</span>
              </a>
            <?php endif; ?>
          </div>
        </section>

      </div>

      <!-- Controls -->
      <div class="company-slider-controls" aria-label="Điều khiển banner">
        <button type="button" data-company-step="-1" aria-label="Slide trước" aria-controls="companySliderTrack">←</button>
        <button type="button" data-company-step="1" aria-label="Slide tiếp theo" aria-controls="companySliderTrack">→</button>
      </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'hpo_hero', 'hpo_hero_shortcode' );
