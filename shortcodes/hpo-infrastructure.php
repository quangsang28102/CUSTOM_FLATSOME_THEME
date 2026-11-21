<?php
/**
 * Shortcode Render: [hpo_infrastructure]
 * Renders .digital-learning-materials[aria-labelledby="digital-platform-title"] (Feature F12).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function hpo_shortcode_infrastructure( $atts ) {
    $a = shortcode_atts( array(
        'title_line_1'       => 'Hệ thống hạ tầng kỹ thuật',
        'title_line_2'       => 'hiện đại, đồng bộ, thông suốt, bảo mật',
        'stage_badge_prefix' => 'Lưu trữ tại',
        'stage_badge_brand'  => 'Viettel IDC',
        'stage_image'        => '',
        'stage_image_alt'    => 'Hạ tầng máy chủ đám mây Viettel IDC của hệ thống HPO',
        'pillar1_num'        => '01',
        'pillar1_title'      => 'Hiện đại',
        'pillar1_desc'       => 'Máy chủ đặt tại trung tâm dữ liệu Viettel IDC.',
        'pillar2_num'        => '02',
        'pillar2_title'      => 'Đồng bộ',
        'pillar2_desc'       => 'Xác thực khuôn mặt, DAT, cabin, mô phỏng chung một hệ thống HPO.',
        'pillar3_num'        => '03',
        'pillar3_title'      => 'Thông suốt',
        'pillar3_desc'       => 'Truy cập mọi lúc trên máy tính, điện thoại, máy tính bảng.',
        'pillar4_num'        => '04',
        'pillar4_title'      => 'Bảo mật',
        'pillar4_desc'       => 'Bảo mật thông tin học viên theo tiêu chuẩn an toàn dữ liệu.',
    ), $atts, 'hpo_infrastructure' );

    $stage_img_url = hpo_showcase_resolve_image( $a['stage_image'], 'so-huu-tri-tue/HaTangKyThuat.jpg' );

    $pillar_svgs = array(
        1 => '<svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="7" rx="2" /><rect x="3" y="14" width="18" height="7" rx="2" /><path d="M7 6.5h.01M7 17.5h.01M11 6.5h6M11 17.5h6" /></svg>',
        2 => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 12a9 9 0 0 1-15.5 6.2M3 12a9 9 0 0 1 15.5-6.2M21 4v5h-5M3 20v-5h5" /></svg>',
        3 => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 12h-4l-3 9L9 3l-3 9H2" /></svg>',
        4 => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22s8-3.6 8-10V5l-8-3-8 3v7c0 6.4 8 10 8 10Z" /><path d="m9 12 2 2 4-4" /></svg>',
    );

    ob_start();
    ?>
    <section
      class="digital-learning-materials"
      aria-labelledby="digital-platform-title"
    >
      <div class="digital-learning-materials__icons" aria-hidden="true">
        <svg viewBox="0 0 24 24">
          <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
          <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
        </svg>
        <svg viewBox="0 0 24 24">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z" />
          <path d="M14 2v6h6M8 13h8M8 17h6" />
        </svg>
        <svg viewBox="0 0 24 24">
          <rect x="2" y="3" width="20" height="14" rx="2" />
          <path d="M8 21h8M12 17v4M10 8l5 2.5-5 2.5Z" />
        </svg>
        <svg viewBox="0 0 24 24">
          <path d="m2 10 10-5 10 5-10 5Z" />
          <path d="M6 12.5V17c3 2.7 9 2.7 12 0v-4.5M22 10v6" />
        </svg>
        <svg viewBox="0 0 24 24">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z" />
          <path d="m9 12 2 2 4-4" />
        </svg>
      </div>

      <div class="container digital-learning-materials__inner">
        <header class="digital-learning-materials__head" data-reveal>
          <h2 id="digital-platform-title">
            <em><span class="infra-title__line infra-title__line--blue"><?php echo esc_html( $a['title_line_1'] ); ?></span><br /><span class="infra-title__line infra-title__line--red"><?php echo esc_html( $a['title_line_2'] ); ?></span></em>
          </h2>
        </header>

        <div class="infra-layout">
          <figure class="infra-stage" data-reveal data-delay="1">
            <span class="infra-stage__orbit infra-stage__orbit--outer" aria-hidden="true"><i></i></span>
            <span class="infra-stage__orbit infra-stage__orbit--inner" aria-hidden="true"><i></i></span>
            <div
              class="infra-stage__media"
              data-img-group="infrastructure"
              data-img-idx="0"
              role="button"
              tabindex="0"
              aria-label="Xem ảnh hạ tầng máy chủ Viettel IDC"
            >
              <img
                src="<?php echo esc_url( $stage_img_url ); ?>"
                alt="<?php echo esc_attr( $a['stage_image_alt'] ); ?>"
                width="829"
                height="635"
                loading="eager"
                decoding="sync"
              />
            </div>
            <figcaption class="infra-stage__badge">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z" />
              </svg><span><?php echo esc_html( $a['stage_badge_prefix'] ); ?> <b><?php echo esc_html( $a['stage_badge_brand'] ); ?></b></span>
            </figcaption>
          </figure>

          <ol class="infra-pillars" data-reveal data-delay="2">
            <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
            <li class="infra-pillar">
              <span class="infra-pillar__icon">
                <?php echo $pillar_svgs[ $i ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
              </span>
              <div>
                <h3><span class="infra-pillar__num"><?php echo esc_html( $a[ "pillar{$i}_num" ] ); ?></span> <?php echo esc_html( $a[ "pillar{$i}_title" ] ); ?></h3>
                <p><?php echo esc_html( $a[ "pillar{$i}_desc" ] ); ?></p>
              </div>
            </li>
            <?php endfor; ?>
          </ol>
        </div>
      </div>
    </section>
    <?php
    return trim( ob_get_clean() );
}
add_shortcode( 'hpo_infrastructure', 'hpo_shortcode_infrastructure' );
