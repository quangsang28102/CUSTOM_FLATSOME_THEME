<?php
/**
 * Shortcode Render: [hpo_news_rotator]
 * Renders Press News Rotator section hydrated by assets/js/hpo-press.js.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function hpo_shortcode_news_rotator( $atts ) {
    static $instance = 0;
    $instance++;

    $a = shortcode_atts(
        array(
            'eyebrow'         => 'Hiệp Phát',
            'title_line_1'    => 'Bài báo về',
            'title_line_2'    => 'Hiệp Phát',
            'subtitle'        => 'Bài viết, phóng sự trên báo điện tử, truyền hình và phát thanh về mô hình học lái xe tích hợp AI của Hiệp Phát.',
            'interval_ms'     => '6500',
            'small_count'     => '3',
            'all_button_text' => 'Xem tất cả {count} bài',
            'category_filter' => '',
        ),
        $atts,
        'hpo_news_rotator'
    );

    $interval_ms = absint( $a['interval_ms'] );
    if ( $interval_ms <= 0 ) {
        $interval_ms = 6500;
    }
    $interval_ms = max( 1500, min( 60000, $interval_ms ) );

    $small_count = absint( $a['small_count'] );
    if ( $small_count <= 0 ) {
        $small_count = 3;
    }
    $small_count = max( 1, min( 10, $small_count ) );

    $category_filter = sanitize_text_field( (string) $a['category_filter'] );
    $heading_id      = ( 1 === $instance ) ? 'news-rot-title' : 'news-rot-title-' . $instance;
    $rest_url        = rest_url( 'hpo/v1/press' );

    $payload     = function_exists( 'hpo_get_press_payload' ) ? hpo_get_press_payload() : array( 'bai' => array() );
    $total_count = isset( $payload['bai'] ) && is_array( $payload['bai'] ) ? count( $payload['bai'] ) : 0;

    $all_btn_raw  = (string) $a['all_button_text'];
    $all_btn_html = str_replace(
        '{count}',
        '<span data-news-all-count>' . ( $total_count > 0 ? esc_html( (string) $total_count ) : '' ) . '</span>',
        esc_html( $all_btn_raw )
    );

    if ( function_exists( 'hpo_press_mark_dialog_needed' ) ) {
        hpo_press_mark_dialog_needed();
    }

    ob_start();
    ?>
    <section
      class="news-rot"
      data-news-rotator
      data-interval-ms="<?php echo esc_attr( (string) $interval_ms ); ?>"
      data-small-count="<?php echo esc_attr( (string) $small_count ); ?>"
      data-category-filter="<?php echo esc_attr( $category_filter ); ?>"
      data-rest-url="<?php echo esc_url( $rest_url ); ?>"
      style="--news-interval: <?php echo esc_attr( (string) $interval_ms ); ?>ms;"
      aria-labelledby="<?php echo esc_attr( $heading_id ); ?>"
      aria-roledescription="carousel"
    >
      <div class="news-rot__inner">
        <header class="news-rot__intro">
          <?php if ( '' !== trim( (string) $a['eyebrow'] ) ) : ?>
            <span class="news-rot__eyebrow"><?php echo esc_html( $a['eyebrow'] ); ?></span>
          <?php endif; ?>
          <h3 class="news-rot__title" id="<?php echo esc_attr( $heading_id ); ?>">
            <span><?php echo esc_html( $a['title_line_1'] ); ?></span>
            <?php if ( '' !== trim( (string) $a['title_line_2'] ) ) : ?>
              <span><?php echo esc_html( $a['title_line_2'] ); ?></span>
            <?php endif; ?>
          </h3>
          <span class="news-rot__line" aria-hidden="true"></span>
          <?php if ( '' !== trim( (string) $a['subtitle'] ) ) : ?>
            <p class="news-rot__sub"><?php echo esc_html( $a['subtitle'] ); ?></p>
          <?php endif; ?>
        </header>

        <div class="news-rot__feature" data-news-feature></div>

        <div class="news-rot__side">
          <div class="news-rot__list" data-news-list></div>
          <div class="news-rot__bar">
            <button
              type="button"
              class="news-rot__all"
              data-news-all
              aria-haspopup="dialog"
              aria-controls="pressListDialog"
            >
              <span><?php echo $all_btn_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 6.5v11l7-5.5zM12.5 6.5v11l7-5.5z" />
              </svg>
            </button>
            <button
              type="button"
              class="news-rot__btn"
              data-news-prev
              aria-label="Bài trước"
            >
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="m15 18-6-6 6-6" />
              </svg>
            </button>
            <button
              type="button"
              class="news-rot__btn"
              data-news-next
              aria-label="Bài tiếp theo"
            >
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="m9 18 6-6-6-6" />
              </svg>
            </button>
            <button
              type="button"
              class="news-rot__btn"
              data-news-pause
              aria-label="Tạm dừng tự chuyển bài"
              aria-pressed="false"
            >
              <svg class="i-pause" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M9 6v12M15 6v12" />
              </svg>
              <svg class="i-play" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M8 5.5v13l10-6.5z" />
              </svg>
            </button>
          </div>
        </div>
      </div>
      <span class="news-rot__track" data-news-track aria-hidden="true"><i data-news-progress></i></span>
      <p class="news-rot__sr" data-news-live aria-live="off"></p>
    </section>
    <?php
    if ( function_exists( 'hpo_press_ensure_inline_data' ) ) {
        echo hpo_press_ensure_inline_data(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
    if ( ( ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || wp_doing_ajax() ) && ! did_action( 'wp_footer' ) && function_exists( 'hpo_press_render_dialog_markup' ) ) {
        echo hpo_press_render_dialog_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    return trim( ob_get_clean() );
}
add_shortcode( 'hpo_news_rotator', 'hpo_shortcode_news_rotator' );
