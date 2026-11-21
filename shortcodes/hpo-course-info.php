<?php
/**
 * Shortcode Render: [hpo_course_info]
 * Renders F16 Course Info Panel (.course-info-section > .course-info-panel)
 * Updated to 14/11/2026 Brochure Redesign with integrated steps & short courses.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function hpo_resolve_course_info_url( $raw_url ) {
    $url = trim( (string) $raw_url );
    if ( '' === $url ) {
        return '';
    }
    if ( preg_match( '~^(https?://|#|tel:|mailto:)~i', $url ) ) {
        return $url;
    }
    if ( 0 === strpos( $url, '/' ) ) {
        return home_url( $url );
    }
    return home_url( '/' . ltrim( $url, '/' ) );
}

function hpo_shortcode_course_info( $atts ) {
    $a = shortcode_atts( array(
        'integrated_title'  => 'Thời gian ôn tập, kiểm tra tích hợp giữa học lý thuyết và thực hành',
        'step1_text'        => 'Ôn tập xe thiết bị',
        'step1_value'       => '2 giờ',
        'step2_text'        => 'Xét kiểm tra hoàn thành khóa học xe thiết bị có chấm điểm trên sân sát hạch',
        'step2_value'       => '20 phút',
        'pass_text'         => 'Xác suất học viên thi đậu cao',
        'note_html'         => '<strong>Lưu ý:</strong> Phí&nbsp;sát&nbsp;hạch và lệ&nbsp;phí cấp&nbsp;bằng (<strong>645.000đ</strong>) học&nbsp;viên tự thanh&nbsp;toán thông&nbsp;qua <span class="course-info-panel__keep">mã&nbsp;QR&nbsp;cơ&nbsp;sở&nbsp;đào&nbsp;tạo</span> <span class="course-info-panel__keep">cấp&nbsp;trước&nbsp;kỳ&nbsp;sát&nbsp;hạch&nbsp;7&nbsp;ngày.</span>',
        'short_badge'       => 'Khóa học ngắn hạn',
        'short_item1_dt'    => 'Hạng B',
        'short_item1_dd'    => 'Các khóa 2 tháng',
        'short_item2_dt'    => 'Hạng C1',
        'short_item2_dd'    => 'Các khóa 3 tháng',
        'phone_display'     => '0911.739.119 — 028.36.362.362',
        'phone_href'        => 'tel:0911739119',
        'website_display'   => 'https://hpo.edu.vn',
        'website_href'      => 'https://hpo.edu.vn',
        'email_display'     => 'tuyensinh@hpo.edu.vn',
        'email_href'        => 'mailto:tuyensinh@hpo.edu.vn',
        'process_link_text' => 'Xem chi tiết quy trình đào tạo',
        'process_link_url'  => 'quy-dinh-chuong-trinh-hoc-lai-xe/',
    ), $atts, 'hpo_course_info' );

    $process_url = hpo_resolve_course_info_url( $a['process_link_url'] );

    ob_start();
    ?>
    <section class="course-info-section" aria-label="Thông tin khóa học">
      <div class="course-demo-container">
        <div class="course-info-panel" role="group" aria-label="Thông tin khóa học">
          <!-- Cột trái: ôn tập, kiểm tra tích hợp -->
          <div class="course-info-panel__column course-info-panel__column--integrated">
            <h3 class="course-info-panel__heading">
              <?php echo esc_html( $a['integrated_title'] ); ?>
            </h3>
            <ol class="course-info-panel__steps">
              <li>
                <span class="course-info-panel__step-num" aria-hidden="true">1</span>
                <span class="course-info-panel__step-text"><?php echo esc_html( $a['step1_text'] ); ?></span>
                <strong class="course-info-panel__step-value"><?php echo wp_kses_post( $a['step1_value'] ); ?></strong>
              </li>
              <li>
                <span class="course-info-panel__step-num" aria-hidden="true">2</span>
                <span class="course-info-panel__step-text"><?php echo esc_html( $a['step2_text'] ); ?></span>
                <strong class="course-info-panel__step-value"><?php echo wp_kses_post( $a['step2_value'] ); ?></strong>
              </li>
            </ol>
          </div>

          <!-- Cột phải: Thẻ navy Khóa học ngắn hạn -->
          <div class="course-info-panel__column course-info-panel__column--short-course" role="group" aria-labelledby="khoa-hoc-ngan-han-title">
            <p class="course-info-panel__short-badge" id="khoa-hoc-ngan-han-title">
              <?php echo esc_html( $a['short_badge'] ); ?>
            </p>
            <dl class="course-info-panel__short-list">
              <div>
                <dt><?php echo esc_html( $a['short_item1_dt'] ); ?></dt>
                <dd><?php echo wp_kses_post( $a['short_item1_dd'] ); ?></dd>
              </div>
              <div>
                <dt><?php echo esc_html( $a['short_item2_dt'] ); ?></dt>
                <dd><?php echo wp_kses_post( $a['short_item2_dd'] ); ?></dd>
              </div>
            </dl>
          </div>

          <!-- Hàng dưới: thi đậu cao + Lưu ý phí -->
          <div class="course-info-panel__column course-info-panel__column--notes">
            <p class="course-info-panel__pass">
              <span class="course-info-panel__check" aria-hidden="true">✓</span>
              <span><?php echo esc_html( $a['pass_text'] ); ?></span>
            </p>
            <p class="course-info-panel__note">
              <?php echo wp_kses_post( $a['note_html'] ); ?>
            </p>
          </div>

          <!-- Hàng liên hệ -->
          <div class="course-info-panel__column course-info-panel__column--contact">
            <a class="course-info-panel__contact" href="<?php echo esc_url( $a['phone_href'] ); ?>">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
              </svg>
              <span><?php echo esc_html( $a['phone_display'] ); ?></span>
            </a>
            <a class="course-info-panel__contact" href="<?php echo esc_url( $a['website_href'] ); ?>" target="_blank" rel="noopener">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                <circle cx="12" cy="12" r="10"/>
                <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
              </svg>
              <span><?php echo esc_html( $a['website_display'] ); ?></span>
            </a>
            <a class="course-info-panel__contact" href="<?php echo esc_url( $a['email_href'] ); ?>">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <path d="m22 6-10 7L2 6"/>
              </svg>
              <span><?php echo esc_html( $a['email_display'] ); ?></span>
            </a>
          </div>
        </div>

        <?php if ( ! empty( $process_url ) && ! empty( $a['process_link_text'] ) ) : ?>
          <a class="course-info-panel__link" href="<?php echo esc_url( $process_url ); ?>">
            <?php echo esc_html( $a['process_link_text'] ); ?>
          </a>
        <?php endif; ?>
      </div>
    </section>
    <?php
    return trim( ob_get_clean() );
}
add_shortcode( 'hpo_course_info', 'hpo_shortcode_course_info' );
