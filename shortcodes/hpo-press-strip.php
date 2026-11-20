<?php
/**
 * Shortcode Render: [hpo_press_strip]
 * Renders SSR Press Highlights Ticker Strip & schedules single-instance #pressListDialog.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function hpo_shortcode_press_strip( $atts ) {
    static $instance = 0;
    $instance++;

    $a = shortcode_atts(
        array(
            'label_text'           => 'Báo chí|đưa tin',
            'more_text'            => 'Xem tất cả',
            'region_aria_label'    => 'Báo chí đưa tin về Hiệp Phát',
            'max_items'            => '0',
            'marquee_duration_sec' => '300',
            'hide_on_empty'        => 'true',
            'dialog_title'         => 'Báo chí đưa tin về Hiệp Phát',
            'dialog_subtitle'      => 'bài báo, video, phát thanh sau họp báo ngày 28/10/2026',
        ),
        $atts,
        'hpo_press_strip'
    );

    $payload = function_exists( 'hpo_get_press_payload' )
        ? hpo_get_press_payload()
        : array( 'kenh' => array(), 'bai' => array() );

    $kenh_map  = isset( $payload['kenh'] ) && is_array( $payload['kenh'] ) ? $payload['kenh'] : array();
    $all_items = isset( $payload['bai'] ) && is_array( $payload['bai'] ) ? $payload['bai'] : array();

    $hide_on_empty = filter_var( $a['hide_on_empty'], FILTER_VALIDATE_BOOLEAN );
    $is_ux_active  = function_exists( 'ux_builder_is_active' ) && ux_builder_is_active();

    if ( empty( $all_items ) && $hide_on_empty ) {
        if ( $is_ux_active ) {
            return '<div class="strip strip--highlights strip--press" style="padding:16px 24px;justify-content:center;font-weight:700;">'
                . esc_html__( 'HPO Dải Báo Chí: Chưa có bài báo nào (sẽ tự ẩn trên trang chủ).', 'flatsome-child' )
                . '</div>';
        }
        return '';
    }

    $max_items   = max( 0, absint( $a['max_items'] ) );
    $duration    = absint( $a['marquee_duration_sec'] );
    if ( $duration <= 0 ) {
        $duration = 300;
    }
    $duration    = max( 30, min( 600, $duration ) );
    $strip_items = ( $max_items > 0 ) ? array_slice( $all_items, 0, $max_items ) : $all_items;
    $total_count = count( $all_items );

    $label_raw   = str_replace( '\n', "\n", (string) $a['label_text'] );
    $label_html  = str_replace( array( '|', "\r\n", "\n" ), '<br />', esc_html( $label_raw ) );
    $label_plain = trim( (string) preg_replace( '/\s+/', ' ', str_replace( array( '|', "\r", "\n" ), ' ', $label_raw ) ) );
    if ( '' === $label_plain ) {
        $label_plain = 'Báo chí đưa tin';
    }

    if ( function_exists( 'hpo_press_mark_dialog_needed' ) ) {
        hpo_press_mark_dialog_needed(
            array(
                'title'    => $a['dialog_title'],
                'subtitle' => $a['dialog_subtitle'],
                'count'    => $total_count,
            )
        );
    }

    $go_svg = '<svg class="strip-chip__go" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M9 7h8v8"/></svg>';

    $render_chips = function( $is_clone ) use ( $strip_items, $kenh_map, $go_svg ) {
        foreach ( $strip_items as $it ) {
            $bao     = isset( $it['bao'] ) ? (string) $it['bao'] : '';
            $title   = isset( $it['tieuDe'] ) ? (string) $it['tieuDe'] : '';
            $link    = isset( $it['link'] ) ? (string) $it['link'] : '';
            $kenh    = isset( $it['kenh'] ) && isset( $kenh_map[ $it['kenh'] ] ) ? (string) $it['kenh'] : 'bao-dien-tu';
            $kenh_lb = isset( $kenh_map[ $kenh ] ) ? (string) $kenh_map[ $kenh ] : '';
            if ( '' === $bao || '' === $link ) {
                continue;
            }
            $icon_svg = function_exists( 'hpo_press_channel_icon_svg' ) ? hpo_press_channel_icon_svg( $kenh ) : '';
            $tooltip  = $bao . ': ' . $title;
            $aria     = $tooltip . ' (' . mb_strtolower( $kenh_lb ) . ', mở trong tab mới)';
            ?>
            <a
              class="strip-chip strip-chip--press"
              href="<?php echo esc_url( $link ); ?>"
              target="_blank"
              rel="noopener"
              title="<?php echo esc_attr( $tooltip ); ?>"
              <?php if ( $is_clone ) : ?>
                tabindex="-1"
              <?php else : ?>
                aria-label="<?php echo esc_attr( $aria ); ?>"
              <?php endif; ?>
            >
              <span class="strip-chip__icon" aria-hidden="true"><?php echo $icon_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
              <b><?php echo esc_html( $bao ); ?></b>
              <span class="strip-chip__desc"><?php echo esc_html( $title ); ?></span>
              <?php echo $go_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </a>
            <?php
        }
    };

    ob_start();
    ?>
    <div
      class="strip strip--highlights strip--press"
      role="region"
      aria-label="<?php echo esc_attr( $a['region_aria_label'] ); ?>"
      data-max-items="<?php echo esc_attr( (string) $max_items ); ?>"
      data-hide-on-empty="<?php echo $hide_on_empty ? '1' : '0'; ?>"
      style="--marquee-duration: <?php echo esc_attr( (string) $duration ); ?>s;"
    >
      <button
        type="button"
        class="strip-press__label strip-press__open"
        data-press-open
        aria-haspopup="dialog"
        aria-controls="pressListDialog"
        aria-expanded="false"
        aria-label="<?php echo esc_attr( $label_plain . ': xem tất cả ' . $total_count . ' bài' ); ?>"
      >
        <span class="strip-press__label-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24">
            <path d="M4 5h13v14H6a2 2 0 0 1-2-2zM17 9h3v8a2 2 0 0 1-2 2" />
            <path d="M7.5 9h6M7.5 12.5h6M7.5 16h4" />
          </svg>
          <span class="strip-press__count" data-press-count><?php echo esc_html( (string) $total_count ); ?></span>
        </span>
        <span class="strip-press__text">
          <span><?php echo $label_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
          <span class="strip-press__more">
            <?php echo esc_html( $a['more_text'] ); ?>
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="m9 6 6 6-6 6" />
            </svg>
          </span>
        </span>
      </button>
      <div class="strip-press__viewport">
        <div
          class="strip-track"
          <?php echo ( 1 === $instance ) ? 'id="stripTrack"' : ''; ?>
        >
          <div class="strip-group" data-press-strip-group>
            <?php $render_chips( false ); ?>
          </div>
          <div class="strip-group" aria-hidden="true" data-press-strip-group>
            <?php $render_chips( true ); ?>
          </div>
        </div>
      </div>
    </div>
    <?php
    if ( function_exists( 'hpo_press_ensure_inline_data' ) ) {
        echo hpo_press_ensure_inline_data(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
    if ( ( ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || wp_doing_ajax() ) && ! did_action( 'wp_footer' ) && function_exists( 'hpo_press_render_dialog_markup' ) ) {
        echo hpo_press_render_dialog_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    return trim( ob_get_clean() );
}
add_shortcode( 'hpo_press_strip', 'hpo_shortcode_press_strip' );
