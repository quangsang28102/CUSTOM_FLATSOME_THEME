<?php
/**
 * Shortcode Render: [hpo_courses]
 * Renders F15 Courses Showcase section (#khoa-hoc.courses-section).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function hpo_shortcode_courses( $atts ) {
    $a = shortcode_atts( array(
        'section_id'        => 'khoa-hoc',
        'title'             => 'KHÓA HỌC CỦA CHÚNG TÔI',
        'subtitle_1'        => 'ĐÀO TẠO LÁI XE Ô TÔ THÔNG MINH',
        'subtitle_2'        => 'CHI PHÍ THẤP',
        'subtitle_3'        => 'CHẤT LƯỢNG HÀNG ĐẦU',
        'promo_gift_image'  => '',
        'promo_gift_alt'    => 'Hộp quà ưu đãi học phí',
        'promo_ribbon'      => 'HỌC PHÍ TRỌN GÓI',
        'promo_note'        => "Minh bạch · Hiệu quả\nChất lượng cao",
        'deadline_label'    => 'Thời gian áp dụng:',
        'deadline_prefix'   => 'Chương trình ưu đãi học phí đăng ký đến hết ngày',
        'deadline_date'     => '31/01/2027',
        'deadline_suffix'   => '.',
        // Course 1
        'c1_slug'           => 'hang-b-so-tu-dong',
        'c1_price_id'       => 'gia-hang-b-tu-dong',
        'c1_badge'          => 'B',
        'c1_badge_variant'  => '',
        'c1_class'          => 'Hạng B',
        'c1_type'           => 'Số tự động',
        'c1_photo_preset'   => 'hang-b-vios',
        'c1_custom_image'   => '',
        'c1_tuition_label'  => 'Học phí',
        'c1_tuition_value'  => '16.000.000đ',
        'c1_duration_label' => 'Thời gian học',
        'c1_duration_value' => '2 tháng',
        // Course 2
        'c2_slug'           => 'hang-b-so-co-khi',
        'c2_price_id'       => 'gia-hang-b-co-khi',
        'c2_badge'          => 'B',
        'c2_badge_variant'  => '',
        'c2_class'          => 'Hạng B',
        'c2_type'           => 'Số cơ khí',
        'c2_photo_preset'   => 'hang-b-vios',
        'c2_custom_image'   => '',
        'c2_tuition_label'  => 'Học phí',
        'c2_tuition_value'  => '16.000.000đ',
        'c2_duration_label' => 'Thời gian học',
        'c2_duration_value' => '2 tháng',
        // Course 3
        'c3_slug'           => 'hang-c1',
        'c3_price_id'       => 'gia-hang-c1',
        'c3_badge'          => 'C1',
        'c3_badge_variant'  => 'c1',
        'c3_class'          => 'Hạng C1',
        'c3_type'           => 'Xe tải',
        'c3_photo_preset'   => 'hang-c1-kia-k200',
        'c3_custom_image'   => '',
        'c3_tuition_label'  => 'Học phí',
        'c3_tuition_value'  => '18.000.000đ',
        'c3_duration_label' => 'Thời gian học',
        'c3_duration_value' => '3 tháng',
    ), $atts, 'hpo_courses' );

    $section_id = '' !== trim( $a['section_id'] ) ? sanitize_html_class( $a['section_id'] ) : 'khoa-hoc';
    $title_id   = 'khoa-hoc' === $section_id ? 'courses-title' : $section_id . '-title';
    $gift_img   = hpo_get_image_url( $a['promo_gift_image'], 'full', HPO_THEME_URI . '/assets/images/courses-demo/gift-box.svg' );

    $subtitles = array_values(
        array_filter(
            array(
                trim( (string) $a['subtitle_1'] ),
                trim( (string) $a['subtitle_2'] ),
                trim( (string) $a['subtitle_3'] ),
            ),
            static function( $val ) {
                return '' !== $val;
            }
        )
    );

    $promo_note_norm = str_replace( array( '\n', "\r\n", "\r" ), "\n", (string) $a['promo_note'] );
    $promo_note_html = nl2br( esc_html( $promo_note_norm ), true );

    $courses = array();
    for ( $i = 1; $i <= 3; $i++ ) {
        $courses[] = array(
            'slug'           => $a[ "c{$i}_slug" ],
            'price_id'       => $a[ "c{$i}_price_id" ],
            'badge'          => $a[ "c{$i}_badge" ],
            'badge_variant'  => $a[ "c{$i}_badge_variant" ],
            'class'          => $a[ "c{$i}_class" ],
            'type'           => $a[ "c{$i}_type" ],
            'photo_preset'   => $a[ "c{$i}_photo_preset" ],
            'custom_image'   => $a[ "c{$i}_custom_image" ],
            'tuition_label'  => $a[ "c{$i}_tuition_label" ],
            'tuition_value'  => $a[ "c{$i}_tuition_value" ],
            'duration_label' => $a[ "c{$i}_duration_label" ],
            'duration_value' => $a[ "c{$i}_duration_value" ],
        );
    }

    ob_start();
    ?>
    <section
      class="courses-section"
      id="<?php echo esc_attr( $section_id ); ?>"
      aria-labelledby="<?php echo esc_attr( $title_id ); ?>"
      data-courses-section
    >
      <div class="courses-bg" aria-hidden="true">
        <div class="courses-bg__sky"></div>
        <div class="courses-bg__cloud courses-bg__cloud--1"></div>
        <div class="courses-bg__cloud courses-bg__cloud--2"></div>
        <div class="courses-bg__cloud courses-bg__cloud--3"></div>
        <div class="courses-bg__city"></div>
        <div class="courses-bg__fade"></div>
      </div>

      <div class="course-demo-container">
        <header class="section-head">
          <h2 class="section-head__title" id="<?php echo esc_attr( $title_id ); ?>">
            <?php echo esc_html( $a['title'] ); ?>
          </h2>
          <?php if ( ! empty( $subtitles ) ) : ?>
          <p class="section-head__subtitle">
            <?php foreach ( $subtitles as $idx => $part ) : ?>
              <?php if ( $idx > 0 ) : ?><span class="sep"> - </span><?php endif; ?><span class="nowrap"><?php echo esc_html( $part ); ?></span>
            <?php endforeach; ?>
          </p>
          <?php endif; ?>
          <span class="section-head__lane" aria-hidden="true"></span>
        </header>

        <div class="courses-layout">
          <aside class="promo" aria-label="Ưu đãi học phí">
            <div class="promo__gift">
              <span class="promo__glow" aria-hidden="true"></span>
              <span class="promo__spark" aria-hidden="true"></span>
              <span class="promo__spark" aria-hidden="true"></span>
              <span class="promo__spark" aria-hidden="true"></span>
              <span class="promo__spark" aria-hidden="true"></span>
              <span class="promo__spark" aria-hidden="true"></span>
              <img
                class="promo__box"
                src="<?php echo esc_url( $gift_img ); ?>"
                alt="<?php echo esc_attr( $a['promo_gift_alt'] ); ?>"
                width="240"
                height="228"
                loading="eager"
                decoding="sync"
              />
              <span class="promo__shadow" aria-hidden="true"></span>
            </div>
            <p class="promo__ribbon"><span><?php echo esc_html( $a['promo_ribbon'] ); ?></span></p>
            <p class="promo__note"><?php echo $promo_note_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
          </aside>

          <div class="course-demo-list" data-courses>
            <?php foreach ( $courses as $course ) : ?>
              <?php
              $badge_cls = 'course-card__badge';
              if ( 'c1' === $course['badge_variant'] ) {
                  $badge_cls .= ' course-card__badge--c1';
              }
              $custom_url = '';
              if ( 'custom' === $course['photo_preset'] && ! empty( $course['custom_image'] ) ) {
                  $custom_url = hpo_get_image_url( $course['custom_image'], 'full', '' );
              }
              ?>
              <article class="course-card" data-course="<?php echo esc_attr( $course['slug'] ); ?>">
                <h3 class="course-card__title">
                  <button class="course-card__toggle" type="button" data-toggle>
                    <span class="<?php echo esc_attr( $badge_cls ); ?>" aria-hidden="true"><?php echo esc_html( $course['badge'] ); ?></span>
                    <span class="course-card__name">
                      <span class="course-card__class"><?php echo esc_html( $course['class'] ); ?></span><span class="visually-hidden"> - </span>
                      <span class="course-card__type"><?php echo esc_html( $course['type'] ); ?></span>
                    </span>
                    <span class="course-card__chevron" aria-hidden="true"></span>
                  </button>
                </h3>
                <?php if ( '' !== $custom_url ) : ?>
                <div
                  class="stage"
                  data-stage
                  data-image="<?php echo esc_url( $custom_url ); ?>"
                  data-image-alt="<?php echo esc_attr( trim( $course['class'] . ' - ' . $course['type'] ) ); ?>"
                  aria-hidden="true"
                ></div>
                <?php else : ?>
                <?php
                $preset = 'custom' === $course['photo_preset'] || '' === $course['photo_preset']
                    ? 'hang-b-vios'
                    : $course['photo_preset'];
                ?>
                <div
                  class="stage"
                  data-stage
                  data-photo="<?php echo esc_attr( $preset ); ?>"
                  aria-hidden="true"
                ></div>
                <?php endif; ?>
                <dl class="price-list" id="<?php echo esc_attr( $course['price_id'] ); ?>">
                  <div class="price price--deal">
                    <dt class="price__label"><?php echo esc_html( $course['tuition_label'] ); ?></dt>
                    <dd class="price__value"><?php echo esc_html( $course['tuition_value'] ); ?></dd>
                  </div>
                  <div class="price price--duration">
                    <dt class="price__label"><?php echo esc_html( $course['duration_label'] ); ?></dt>
                    <dd class="price__value"><?php echo esc_html( $course['duration_value'] ); ?></dd>
                  </div>
                </dl>
              </article>
            <?php endforeach; ?>
          </div>

          <p class="course-deadline" role="note">
            <span class="course-deadline__icon" aria-hidden="true">
              <svg viewBox="0 0 24 24">
                <rect x="3.5" y="5" width="17" height="15.5" rx="3" />
                <path d="M3.5 10h17M8 3v4M16 3v4M8.5 14.5l2.3 2.3 4.7-4.6" />
              </svg>
            </span>
            <span class="course-deadline__label"><?php echo esc_html( $a['deadline_label'] ); ?></span>
            <span class="course-deadline__text">
              <?php echo esc_html( $a['deadline_prefix'] ); ?>
              <strong><?php echo esc_html( $a['deadline_date'] ); ?></strong><?php echo esc_html( $a['deadline_suffix'] ); ?>
            </span>
          </p>
        </div>
      </div>
    </section>
    <?php
    return trim( ob_get_clean() );
}
add_shortcode( 'hpo_courses', 'hpo_shortcode_courses' );
