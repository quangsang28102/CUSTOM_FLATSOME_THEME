<?php
/**
 * Shortcode Render: [hpo_brand_certificates]
 * Renders #so-huu-tri-tue.brand-protection (Feature F11).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function hpo_shortcode_brand_certificates( $atts ) {
    $a = shortcode_atts( array(
        'section_title'       => 'thương hiệu',
        'section_subtitle'    => 'Các tài sản trí tuệ của hệ thống HPO đã được cơ quan nhà nước có thẩm quyền cấp văn bằng bảo hộ',

        'cert1_num'           => '01',
        'cert1_tag_label'     => 'Sở hữu trí tuệ',
        'cert1_title'         => 'Giấy chứng nhận đăng ký nhãn hiệu',
        'cert1_description'   => 'Văn bằng ghi nhận nhãn hiệu của Công ty TNHH Ô Tô Hiệp Phát được bảo hộ cho dịch vụ thuộc Nhóm 41 – Giáo dục.',
        'cert1_image'         => '',
        'cert1_image_alt'     => 'Giấy chứng nhận đăng ký nhãn hiệu số 537625',
        'cert1_lightbox_idx'  => '0',
        'cert1_fact_1_label'  => 'Số chứng nhận',
        'cert1_fact_1_value'  => '537625',
        'cert1_fact_2_label'  => 'Quyết định',
        'cert1_fact_2_value'  => '46269/QĐ-SHTT',
        'cert1_fact_3_label'  => 'Ngày cấp',
        'cert1_fact_3_value'  => '11/04/2025',
        'cert1_link_text'     => '',
        'cert1_link_url'      => '',

        'cert2_num'           => '02',
        'cert2_tag_label'     => 'Website thương mại điện tử',
        'cert2_title'         => 'Website đã thông báo Bộ Công Thương',
        'cert2_description'   => 'Cổng online.gov.vn ghi nhận hpo.edu.vn là nền tảng đặt hàng trực tuyến đã thông báo Bộ Công Thương.',
        'cert2_image'         => '',
        'cert2_image_alt'     => 'Thông tin website hpo.edu.vn đã thông báo Bộ Công Thương',
        'cert2_lightbox_idx'  => '3',
        'cert2_fact_1_label'  => 'Website',
        'cert2_fact_1_value'  => 'hpo.edu.vn',
        'cert2_fact_2_label'  => 'Mã số thuế',
        'cert2_fact_2_value'  => '0309987279',
        'cert2_fact_3_label'  => 'Trạng thái',
        'cert2_fact_3_value'  => 'Đã thông báo Bộ Công Thương',
        'cert2_link_text'     => 'Xem trên online.gov.vn',
        'cert2_link_url'      => 'http://online.gov.vn/Website/chi-tiet-135372',

        'cert3_num'           => '03',
        'cert3_tag_label'     => 'Tài nguyên Internet',
        'cert3_title'         => 'Giấy chứng nhận đăng ký tên miền “hpo.edu.vn”',
        'cert3_description'   => 'Giấy chứng nhận của P.A Việt Nam ghi nhận tên miền hpo.edu.vn do Công ty TNHH Ô Tô Hiệp Phát đăng ký.',
        'cert3_image'         => '',
        'cert3_image_alt'     => 'Giấy chứng nhận đăng ký tên miền hpo.edu.vn',
        'cert3_lightbox_idx'  => '4',
        'cert3_fact_1_label'  => 'Tên miền',
        'cert3_fact_1_value'  => 'hpo.edu.vn',
        'cert3_fact_2_label'  => 'Ngày đăng ký',
        'cert3_fact_2_value'  => '23/02/2021',
        'cert3_fact_3_label'  => 'Nhà đăng ký',
        'cert3_fact_3_value'  => 'P.A Việt Nam',
        'cert3_link_text'     => '',
        'cert3_link_url'      => '',

        'cert4_num'           => '04',
        'cert4_tag_label'     => 'Quyền tác giả bài giảng',
        'cert4_title'         => 'Học liệu điện tử',
        'cert4_description'   => 'Giấy chứng nhận đăng ký quyền tác giả cho bài giảng video đào tạo lái xe ô tô hạng B và hạng C theo mô hình tập trung trên nền tảng số.',
        'cert4_image'         => '',
        'cert4_image_alt'     => 'Giấy chứng nhận quyền tác giả bài giảng video',
        'cert4_lightbox_idx'  => '1',
        'cert4_fact_1_label'  => 'Số chứng nhận',
        'cert4_fact_1_value'  => '0780/2025/QTG',
        'cert4_fact_2_label'  => 'Ngày cấp',
        'cert4_fact_2_value'  => '22/01/2025',
        'cert4_fact_3_label'  => 'Loại hình',
        'cert4_fact_3_value'  => 'Bài giảng',
        'cert4_link_text'     => '',
        'cert4_link_url'      => '',

        'cert5_num'           => '05',
        'cert5_tag_label'     => 'Quyền tác giả phần mềm',
        'cert5_title'         => 'Hệ thống đào tạo lái xe ô tô',
        'cert5_description'   => 'Giấy chứng nhận đăng ký quyền tác giả cho phần mềm đào tạo lái xe ô tô theo mô hình tập trung trên nền tảng số.',
        'cert5_image'         => '',
        'cert5_image_alt'     => 'Giấy chứng nhận quyền tác giả phần mềm đào tạo lái xe',
        'cert5_lightbox_idx'  => '2',
        'cert5_fact_1_label'  => 'Số chứng nhận',
        'cert5_fact_1_value'  => '6392/2025/QTG',
        'cert5_fact_2_label'  => 'Ngày cấp',
        'cert5_fact_2_value'  => '01/08/2025',
        'cert5_fact_3_label'  => 'Loại hình',
        'cert5_fact_3_value'  => 'Chương trình máy tính',
        'cert5_link_text'     => '',
        'cert5_link_url'      => '',
    ), $atts, 'hpo_brand_certificates' );

    $tag_svgs = array(
        1 => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z" /><path d="m9 12 2 2 4-4" /></svg>',
        2 => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 9h18l-1.5-5h-15L3 9Zm0 0v11h18V9M9 20v-6h6v6" /></svg>',
        3 => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18" /></svg>',
        4 => '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" /><path d="M8 21h8M12 17v4M10 7.5v5l4-2.5z" /></svg>',
        5 => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m8 9-4 3 4 3M16 9l4 3-4 3M14 5l-4 14" /></svg>',
    );

    $defaults_meta = array(
        1 => array( 'fallback' => 'so-huu-tri-tue/nhanHieu.png',       'w' => 1190, 'h' => 837, 'aria' => 'Xem Giấy chứng nhận đăng ký nhãn hiệu số 537625' ),
        2 => array( 'fallback' => 'so-huu-tri-tue/boCngThuong.png',    'w' => 606,  'h' => 948, 'aria' => 'Xem thông tin website hpo.edu.vn đã thông báo Bộ Công Thương' ),
        3 => array( 'fallback' => 'so-huu-tri-tue/tenMien.png',        'w' => 652,  'h' => 922, 'aria' => 'Xem Giấy chứng nhận đăng ký tên miền hpo.edu.vn' ),
        4 => array( 'fallback' => 'so-huu-tri-tue/tacGiaBaiGiang.png', 'w' => 673,  'h' => 979, 'aria' => 'Xem Giấy chứng nhận quyền tác giả bài giảng video' ),
        5 => array( 'fallback' => 'so-huu-tri-tue/tacGiaPhanMem.png',  'w' => 717,  'h' => 959, 'aria' => 'Xem Giấy chứng nhận quyền tác giả phần mềm đào tạo lái xe' ),
    );

    ob_start();
    ?>
    <section class="brand-protection" id="so-huu-tri-tue">
      <div class="container brand-protection__inner">
        <header class="brand-protection__head" data-reveal>
          <h2><?php echo esc_html( $a['section_title'] ); ?></h2>
          <?php if ( '' !== trim( $a['section_subtitle'] ) ) : ?>
          <p><?php echo esc_html( $a['section_subtitle'] ); ?></p>
          <?php endif; ?>
        </header>

        <div class="brand-cert-grid">
          <?php for ( $i = 1; $i <= 5; $i++ ) :
              $meta         = $defaults_meta[ $i ];
              $num          = $a[ "cert{$i}_num" ];
              $tag_label    = $a[ "cert{$i}_tag_label" ];
              $title        = $a[ "cert{$i}_title" ];
              $description  = $a[ "cert{$i}_description" ];
              $image_url    = hpo_showcase_resolve_image( $a[ "cert{$i}_image" ], $meta['fallback'] );
              $image_alt    = $a[ "cert{$i}_image_alt" ];
              $lightbox_idx = '' !== trim( $a[ "cert{$i}_lightbox_idx" ] ) ? (int) $a[ "cert{$i}_lightbox_idx" ] : ( $i - 1 );
              $link_text    = trim( $a[ "cert{$i}_link_text" ] );
              $link_url     = trim( $a[ "cert{$i}_link_url" ] );
              $delay_attr   = $i > 1 ? ' data-delay="' . esc_attr( $i - 1 ) . '"' : '';
              $media_aria   = '' !== trim( $image_alt ) ? 'Xem ' . $image_alt : $meta['aria'];
              if ( 1 === $i && $image_alt === 'Giấy chứng nhận đăng ký nhãn hiệu số 537625' ) {
                  $media_aria = $meta['aria'];
              } elseif ( 2 === $i && $image_alt === 'Thông tin website hpo.edu.vn đã thông báo Bộ Công Thương' ) {
                  $media_aria = $meta['aria'];
              } elseif ( 3 === $i && $image_alt === 'Giấy chứng nhận đăng ký tên miền hpo.edu.vn' ) {
                  $media_aria = $meta['aria'];
              } elseif ( 4 === $i && $image_alt === 'Giấy chứng nhận quyền tác giả bài giảng video' ) {
                  $media_aria = $meta['aria'];
              } elseif ( 5 === $i && $image_alt === 'Giấy chứng nhận quyền tác giả phần mềm đào tạo lái xe' ) {
                  $media_aria = $meta['aria'];
              }
              $facts = array();
              for ( $f = 1; $f <= 3; $f++ ) {
                  $fl = trim( $a[ "cert{$i}_fact_{$f}_label" ] );
                  $fv = trim( $a[ "cert{$i}_fact_{$f}_value" ] );
                  if ( '' !== $fl || '' !== $fv ) {
                      $facts[] = array( 'label' => $fl, 'value' => $fv );
                  }
              }
          ?>
          <article class="brand-cert" data-reveal<?php echo $delay_attr; ?>>
            <div
              class="brand-cert__media"
              data-img-group="brand-protection"
              data-img-idx="<?php echo esc_attr( $lightbox_idx ); ?>"
              role="button"
              tabindex="0"
              aria-label="<?php echo esc_attr( $media_aria ); ?>"
            >
              <span class="brand-cert__tag">
                <?php echo $tag_svgs[ $i ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php echo esc_html( $tag_label ); ?>
              </span>
              <span class="brand-cert__num" aria-hidden="true"><?php echo esc_html( $num ); ?></span>
              <img
                src="<?php echo esc_url( $image_url ); ?>"
                alt="<?php echo esc_attr( $image_alt ); ?>"
                width="<?php echo esc_attr( $meta['w'] ); ?>"
                height="<?php echo esc_attr( $meta['h'] ); ?>"
                loading="eager"
                decoding="sync"
              />
              <span class="brand-cert__zoom" aria-hidden="true">Xem ảnh</span>
            </div>
            <div class="brand-cert__body">
              <h3><?php echo esc_html( $title ); ?></h3>
              <p><?php echo esc_html( $description ); ?></p>
              <?php if ( ! empty( $facts ) ) : ?>
              <dl class="brand-cert__facts">
                <?php foreach ( $facts as $fact ) : ?>
                <div>
                  <dt><?php echo esc_html( $fact['label'] ); ?></dt>
                  <dd><?php echo esc_html( $fact['value'] ); ?></dd>
                </div>
                <?php endforeach; ?>
              </dl>
              <?php endif; ?>
              <?php if ( '' !== $link_text && '' !== $link_url ) : ?>
              <a
                class="brand-cert__link"
                href="<?php echo esc_url( $link_url ); ?>"
                target="_blank"
                rel="noopener"
              >
                <?php echo esc_html( $link_text ); ?> <span aria-hidden="true">↗</span>
              </a>
              <?php endif; ?>
            </div>
          </article>
          <?php endfor; ?>
        </div>
      </div>
    </section>
    <?php
    return trim( ob_get_clean() );
}
add_shortcode( 'hpo_brand_certificates', 'hpo_shortcode_brand_certificates' );
