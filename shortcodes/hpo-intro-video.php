<?php
/**
 * Shortcode Render: [hpo_intro_video]
 * Renders #gioi_thieu_ve_chung_toi.intro-video (Feature F13).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function hpo_shortcode_intro_video( $atts ) {
    $a = shortcode_atts( array(
        'title_line_1' => 'Trung tâm giáo dục Nghề nghiệp',
        'title_line_2' => 'và sát hạch lái xe ô tô Hiệp Phát',
        'youtube_id'   => 'P5yDyQ1_NqA',
        'video_title'  => 'Giới thiệu trung tâm giáo dục nghề nghiệp Hiệp Phát',
        'autoplay'     => 'true',
        'mute'         => 'true',
        'loop'         => 'true',
    ), $atts, 'hpo_intro_video' );

    // Extract & sanitize YouTube ID if user pastes a full YouTube URL.
    $raw_yt = trim( (string) $a['youtube_id'] );
    $yt_id  = 'P5yDyQ1_NqA';
    if ( '' !== $raw_yt ) {
        if ( preg_match( '/^[A-Za-z0-9_-]{6,20}$/', $raw_yt ) ) {
            $yt_id = $raw_yt;
        } elseif ( preg_match( '#(?:youtube\.com/(?:watch\?.*v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{6,20})#i', $raw_yt, $matches ) ) {
            $yt_id = $matches[1];
        }
    }

    $is_autoplay = in_array( strtolower( trim( (string) $a['autoplay'] ) ), array( '1', 'true', 'yes', 'on' ), true ) ? '1' : '0';
    $is_mute     = in_array( strtolower( trim( (string) $a['mute'] ) ), array( '1', 'true', 'yes', 'on' ), true ) ? '1' : '0';
    $is_loop     = in_array( strtolower( trim( (string) $a['loop'] ) ), array( '1', 'true', 'yes', 'on' ), true ) ? '1' : '0';

    $embed_url = sprintf(
        'https://www.youtube.com/embed/%s?autoplay=%s&mute=%s&loop=%s&playlist=%s&playsinline=1&vq=hd1080',
        rawurlencode( $yt_id ),
        $is_autoplay,
        $is_mute,
        $is_loop,
        rawurlencode( $yt_id )
    );

    $line_2_escaped = esc_html( $a['title_line_2'] );
    $line_2_html    = str_replace( 'sát hạch', '<span class="intro-video__nowrap">sát hạch</span>', $line_2_escaped );

    ob_start();
    ?>
    <section class="intro-video" id="gioi_thieu_ve_chung_toi">
      <div class="container intro-video__inner">
        <header class="intro-video__head" data-reveal>
          <h2>
            <span><?php echo esc_html( $a['title_line_1'] ); ?></span>
            <em>
              <?php echo $line_2_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </em>
          </h2>
        </header>

        <div class="intro-video__frame" data-reveal data-delay="1">
          <iframe
            width="1027"
            height="578"
            src="<?php echo esc_url( $embed_url ); ?>"
            title="<?php echo esc_attr( $a['video_title'] ); ?>"
            frameborder="0"
            allow="autoplay; encrypted-media; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin"
            allowfullscreen
          ></iframe>
        </div>
      </div>
    </section>
    <?php
    return trim( ob_get_clean() );
}
add_shortcode( 'hpo_intro_video', 'hpo_shortcode_intro_video' );
