<?php
/**
 * Shortcode Render: [hpo_course_info]
 * Renders F16 Course Info Panel (.course-info-section--panel > .course-info-panel).
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
        'badge_text'         => 'KHÓA HỌC LINH ĐỘNG',
        'left_item_1'        => 'Chủ động theo thời gian của học viên',
        'left_item_2'        => 'Thuận tiện để học mọi lúc, mọi nơi',
        'right_item_1_label' => 'Kiểm tra hoàn thành khóa đào tạo với xe thiết bị có chấm điểm trên sân sát hạch:',
        'right_item_1_value' => '20 phút',
        'right_item_2_label' => 'Ôn tập xe thiết bị:',
        'right_item_2_value' => '2 giờ',
        'right_item_3_label' => 'Ôn tập lý thuyết:',
        'right_item_3_value' => 'Phòng lý thuyết',
        'phone_display'      => '0911.739.119 — 028.36.362.362',
        'phone_href'         => 'tel:0911739119',
        'website_display'    => 'https://hpo.edu.vn',
        'website_href'       => 'https://hpo.edu.vn',
        'email_display'      => 'tuyensinh@hpo.edu.vn',
        'email_href'         => 'mailto:tuyensinh@hpo.edu.vn',
        'process_link_text'  => 'Xem chi tiết quy trình đào tạo',
        'process_link_url'   => '/quy-dinh-chuong-trinh-hoc-lai-xe/',
    ), $atts, 'hpo_course_info' );

    $left_items = array_filter(
        array(
            trim( (string) $a['left_item_1'] ),
            trim( (string) $a['left_item_2'] ),
        ),
        static function( $val ) {
            return '' !== $val;
        }
    );

    $right_items = array();
    for ( $i = 1; $i <= 3; $i++ ) {
        $lbl = trim( (string) $a[ "right_item_{$i}_label" ] );
        $val = trim( (string) $a[ "right_item_{$i}_value" ] );
        if ( '' !== $lbl || '' !== $val ) {
            $right_items[] = array(
                'label' => $lbl,
                'value' => $val,
            );
        }
    }

    $process_url = hpo_resolve_course_info_url( $a['process_link_url'] );

    ob_start();
    ?>
    <section class="course-info-section course-info-section--panel" aria-label="Thông tin khóa học">
      <div class="course-demo-container">
        <div class="course-info-panel" role="group" aria-label="Thông tin khóa học">
          <div class="course-info-panel__column course-info-panel__column--duration">
            <?php if ( '' !== trim( (string) $a['badge_text'] ) ) : ?>
              <span class="course-info-panel__badge"><?php echo esc_html( $a['badge_text'] ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $left_items ) ) : ?>
              <ul class="course-info-panel__list">
                <?php foreach ( $left_items as $item ) : ?>
                  <li>
                    <span class="course-info-panel__check" aria-hidden="true">✓</span>
                    <span><?php echo esc_html( $item ); ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>

          <div class="course-info-panel__column course-info-panel__column--exam">
            <?php if ( ! empty( $right_items ) ) : ?>
              <ul class="course-info-panel__list">
                <?php foreach ( $right_items as $item ) : ?>
                  <li>
                    <span class="course-info-panel__check" aria-hidden="true">✓</span>
                    <span><?php echo esc_html( $item['label'] ); ?><?php if ( '' !== $item['value'] ) : ?> <strong><?php echo esc_html( $item['value'] ); ?></strong><?php endif; ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>

          <div class="course-info-panel__column course-info-panel__column--contact">
            <?php if ( '' !== trim( (string) $a['phone_display'] ) && '' !== trim( (string) $a['phone_href'] ) ) : ?>
              <a class="course-info-panel__contact" href="<?php echo esc_url( $a['phone_href'], array( 'tel', 'http', 'https' ) ); ?>">
                <svg
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  aria-hidden="true"
                  focusable="false"
                >
                  <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                </svg>
                <span><?php echo esc_html( $a['phone_display'] ); ?></span>
              </a>
            <?php endif; ?>

            <?php if ( '' !== trim( (string) $a['website_display'] ) && '' !== trim( (string) $a['website_href'] ) ) : ?>
              <a class="course-info-panel__contact" href="<?php echo esc_url( $a['website_href'] ); ?>" target="_blank" rel="noopener">
                <svg
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  aria-hidden="true"
                  focusable="false"
                >
                  <circle cx="12" cy="12" r="10" />
                  <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                </svg>
                <span><?php echo esc_html( $a['website_display'] ); ?></span>
              </a>
            <?php endif; ?>

            <?php if ( '' !== trim( (string) $a['email_display'] ) && '' !== trim( (string) $a['email_href'] ) ) : ?>
              <a class="course-info-panel__contact" href="<?php echo esc_url( $a['email_href'], array( 'mailto', 'http', 'https' ) ); ?>">
                <svg
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  aria-hidden="true"
                  focusable="false"
                >
                  <rect x="2" y="4" width="20" height="16" rx="2" />
                  <path d="m22 6-10 7L2 6" />
                </svg>
                <span><?php echo esc_html( $a['email_display'] ); ?></span>
              </a>
            <?php endif; ?>
          </div>
        </div>

        <?php if ( '' !== trim( (string) $a['process_link_text'] ) && '' !== $process_url ) : ?>
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
