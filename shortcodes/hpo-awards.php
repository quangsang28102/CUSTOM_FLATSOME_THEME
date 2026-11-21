<?php
/**
 * Shortcode Render: [hpo_awards]
 * Renders #awardSlider.award-slider (Feature F10).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function hpo_shortcode_awards( $atts ) {
    $a = shortcode_atts( array(
        'section_title'         => 'Dấu ấn hành trình phát triển thương hiệu',
        'autoplay_ms'           => '6500',
        'slide1_num'            => '01',
        'slide1_choice_title'   => 'Top 10',
        'slide1_choice_sub'     => 'Global Excellent Brands 2026',
        'slide1_event_subtitle' => 'Sydney Australia, 28/06/2026 - Diễn đàn doanh nghiệp Việt Nam - Australia',
        'slide1_topline_badge'  => 'Sydney · Australia · 28/06/2026',
        'slide1_poster_image'   => '',
        'slide1_poster_alt'     => 'Top 10 Global Excellent Brands 2026 của Hiệp Phát',
        'slide2_num'            => '02',
        'slide2_choice_title'   => 'Top 5',
        'slide2_choice_sub'     => 'ASEAN Strong Brand 2026',
        'slide2_event_subtitle' => 'Singapore, 18/04/2026 - Diễn đàn hợp tác kinh tế Việt Nam - Asean',
        'slide2_topline_badge'  => 'Singapore · 18/04/2026',
        'slide2_poster_image'   => '',
        'slide2_poster_alt'     => 'Top 5 ASEAN Strong Brand 2026 của Hiệp Phát',
        'slide3_num'            => '03',
        'slide3_choice_title'   => 'Hàng Việt Tốt',
        'slide3_choice_sub'     => 'Thương hiệu Việt 2025',
        'slide3_event_subtitle' => 'Việt Nam, 13/09/2025 - Thương hiệu Hàng Việt tốt 2025',
        'slide3_topline_badge'  => 'Việt Nam · 13/09/2025',
        'slide3_poster_image'   => '',
        'slide3_poster_alt'     => 'Poster Thương hiệu Hàng Việt Tốt 2025 của Hiệp Phát',
    ), $atts, 'hpo_awards' );

    $autoplay_ms = absint( $a['autoplay_ms'] );
    if ( $autoplay_ms < 1000 ) {
        $autoplay_ms = 6500;
    }

    $slides = array(
        array(
            'num'            => $a['slide1_num'],
            'choice_title'   => $a['slide1_choice_title'],
            'choice_sub'     => $a['slide1_choice_sub'],
            'event_subtitle' => $a['slide1_event_subtitle'],
            'topline_badge'  => $a['slide1_topline_badge'],
            'poster_image'   => hpo_showcase_resolve_image( $a['slide1_poster_image'], 'awards/global-excellent-brands-2026-slide-v2.webp' ),
            'poster_alt'     => $a['slide1_poster_alt'],
            'aria_label'     => 'Xem giải ' . trim( $a['slide1_choice_title'] . ' ' . $a['slide1_choice_sub'] ),
            'slide_label'    => trim( $a['slide1_choice_title'] . ' ' . $a['slide1_choice_sub'] ),
        ),
        array(
            'num'            => $a['slide2_num'],
            'choice_title'   => $a['slide2_choice_title'],
            'choice_sub'     => $a['slide2_choice_sub'],
            'event_subtitle' => $a['slide2_event_subtitle'],
            'topline_badge'  => $a['slide2_topline_badge'],
            'poster_image'   => hpo_showcase_resolve_image( $a['slide2_poster_image'], 'awards/asean-strong-brand-2026-slide-v2.webp' ),
            'poster_alt'     => $a['slide2_poster_alt'],
            'aria_label'     => 'Xem giải ' . trim( $a['slide2_choice_title'] . ' ' . $a['slide2_choice_sub'] ),
            'slide_label'    => trim( $a['slide2_choice_title'] . ' ' . $a['slide2_choice_sub'] ),
        ),
        array(
            'num'            => $a['slide3_num'],
            'choice_title'   => $a['slide3_choice_title'],
            'choice_sub'     => $a['slide3_choice_sub'],
            'event_subtitle' => $a['slide3_event_subtitle'],
            'topline_badge'  => $a['slide3_topline_badge'],
            'poster_image'   => hpo_showcase_resolve_image( $a['slide3_poster_image'], 'awards/hang-viet-tot-2025-landscape-v3.webp' ),
            'poster_alt'     => $a['slide3_poster_alt'],
            'aria_label'     => 'Xem giải Thương hiệu ' . trim( $a['slide3_choice_title'] ) . ' 2025',
            'slide_label'    => 'Thương hiệu ' . trim( $a['slide3_choice_title'] ) . ' 2025',
        ),
    );

    $total = count( $slides );

    ob_start();
    ?>
    <section
      class="award-slider"
      id="awardSlider"
      aria-roledescription="carousel"
      aria-label="Ba giải thưởng nổi bật của HPO"
      data-autoplay-ms="<?php echo esc_attr( $autoplay_ms ); ?>"
      style="--slider-duration: <?php echo esc_attr( $autoplay_ms ); ?>ms;"
    >
      <div class="award-slider__heading">
        <div class="hpo-unified-title-wrap">
          <h3 class="hpo-unified-title"><?php echo esc_html( $a['section_title'] ); ?></h3>
        </div>
      </div>

      <p class="award-slider__heading-sub" id="awardSliderSubtitle"><?php echo esc_html( $slides[0]['event_subtitle'] ); ?></p>

      <div class="award-slider__body">
        <div class="award-slider__selector" role="group" aria-label="Chọn giải thưởng">
          <?php foreach ( $slides as $idx => $s ) : ?>
          <button
            type="button"
            class="award-slider__choice<?php echo 0 === $idx ? ' is-active' : ''; ?>"
            data-award-step="<?php echo esc_attr( $idx ); ?>"
            data-award-subtitle="<?php echo esc_attr( $s['event_subtitle'] ); ?>"
            aria-label="<?php echo esc_attr( $s['aria_label'] ); ?>"
            <?php echo 0 === $idx ? 'aria-current="step"' : ''; ?>
            aria-controls="awardSliderTrack"
          >
            <span class="award-slider__choice-number" aria-hidden="true"><?php echo esc_html( $s['num'] ); ?></span>
            <span class="award-slider__choice-copy">
              <strong><?php echo esc_html( $s['choice_title'] ); ?></strong>
              <small><?php echo esc_html( $s['choice_sub'] ); ?></small>
            </span>
          </button>
          <?php endforeach; ?>
        </div>

        <div class="award-slider__viewport">
          <div class="award-slider__track" id="awardSliderTrack">
            <?php foreach ( $slides as $idx => $s ) : ?>
            <article
              class="award-slide award-slide--poster<?php echo 0 === $idx ? ' is-active' : ''; ?>"
              aria-roledescription="slide"
              aria-label="<?php echo esc_attr( ( $idx + 1 ) . ' trên ' . $total . ': ' . $s['slide_label'] ); ?>"
              <?php echo 0 !== $idx ? 'aria-hidden="true"' : ''; ?>
            >
              <?php if ( '' !== trim( $s['topline_badge'] ) ) : ?>
              <div class="award-slide__topline award-slide__topline--absolute">
                <strong><?php echo esc_html( $s['topline_badge'] ); ?></strong>
              </div>
              <?php endif; ?>
              <img
                class="award-slide__poster"
                src="<?php echo esc_url( $s['poster_image'] ); ?>"
                alt="<?php echo esc_attr( $s['poster_alt'] ); ?>"
                loading="eager"
                decoding="sync"
              />
            </article>
            <?php endforeach; ?>
          </div>

          <div class="award-slider__arrows">
            <button type="button" class="award-slider__prev" aria-label="Giải thưởng trước">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="m15 18-6-6 6-6" />
              </svg>
            </button>
            <button type="button" class="award-slider__next" aria-label="Giải thưởng tiếp theo">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="m9 18 6-6-6-6" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <div class="award-slider__progress" aria-hidden="true"><span></span></div>
    </section>
    <?php
    return trim( ob_get_clean() );
}
add_shortcode( 'hpo_awards', 'hpo_shortcode_awards' );
