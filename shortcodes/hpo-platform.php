<?php
/**
 * Shortcode Render: [hpo_platform]
 * Renders Digital Learning Platform section (.platform-v2.nts) with Panel 01 Lý thuyết
 * and Panel 02 Thực hành (Feature F18).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolve an image attribute (WP Attachment ID, URL, or fallback theme asset path)
 * via hpo_get_image_url().
 *
 * @param int|string $value
 * @param string     $fallback_url
 * @return string
 */
if ( ! function_exists( 'hpo_platform_resolve_image_url' ) ) {
	function hpo_platform_resolve_image_url( $value, $fallback_url ) {
		if ( is_numeric( $value ) && (int) $value > 0 ) {
			return hpo_get_image_url( (int) $value, 'full', $fallback_url );
		}
		if ( is_string( $value ) && '' !== trim( $value ) ) {
			$trimmed = trim( $value );
			if ( preg_match( '#^(https?:)?//#i', $trimmed ) || 0 === strpos( $trimmed, '/' ) || 0 === strpos( $trimmed, 'data:' ) ) {
				return $trimmed;
			}
			if ( 0 === strpos( $trimmed, 'assets/' ) ) {
				return HPO_THEME_URI . '/' . ltrim( $trimmed, '/' );
			}
			return HPO_THEME_URI . '/assets/images/' . ltrim( $trimmed, '/' );
		}
		return hpo_get_image_url( 0, 'full', $fallback_url );
	}
}

function hpo_shortcode_platform( $atts ) {
	$a = shortcode_atts( array(
		'title'                   => 'ĐÀO TẠO LÁI XE TRÊN NỀN TẢNG SỐ',
		'download_label'          => 'Tải ứng dụng học đa nền tảng',
		'chplay_url'              => 'https://play.google.com/store/apps/details?id=com.hpo.edugo',
		'chplay_image'            => '',
		'chplay_alt'              => 'Tải trên Google Play',
		'appstore_url'            => 'https://apps.apple.com/vn/app/hiep-phat-edu/id6748065752',
		'appstore_image'          => '',
		'appstore_alt'            => 'Tải trên App Store',
		// 01. Lý thuyết
		'theory_num'              => '01',
		'theory_label'            => 'Lý thuyết',
		'theory_title'            => 'Học lý thuyết trên nền tảng số',
		'theory_desc'             => 'Người học hoàn thành nội dung, chương trình, ghi nhận thời gian học thực bằng xác thực khuôn mặt. Hệ thống ghi nhận quá trình hoàn tất đầy đủ nội dung và thời gian thực của người học.',
		'theory_threshold_prefix' => 'Người học lái xe được kiểm tra để xét hoàn thành khóa đào tạo khi tham dự',
		'theory_threshold_strong' => 'tối thiểu 70%',
		'theory_threshold_suffix' => 'thời gian học nội dung đào tạo lý thuyết;',
		'theory_item1_title'      => 'Xác thực khuôn mặt',
		'theory_item1_data_title' => 'Xác thực khuôn mặt',
		'theory_item1_desc'       => 'Người học hoàn thành nội dung và ghi nhận thời gian học thực bằng xác thực khuôn mặt, giúp quá trình học minh bạch và đúng tiến độ.',
		'theory_item1_image'      => '',
		'theory_item2_title'      => 'Ứng dụng đa nền tảng (Windows, Android, iOS)',
		'theory_item2_data_title' => 'Ứng dụng đa nền tảng',
		'theory_item2_desc'       => 'Học viên có thể học mọi lúc, mọi nơi trên Windows, Android và iOS, chủ động thời gian học và giảm chi phí di chuyển.',
		'theory_item2_image'      => '',
		// 02. Thực hành
		'practice_num'            => '02',
		'practice_label'          => 'Thực hành',
		'practice_title'          => 'Rèn kỹ năng lái xe thực hành môi trường ảo',
		'practice_intro'          => 'Người học lái xe được kiểm tra để xét hoàn thành khóa đào tạo khi',
		'practice_req1_prefix'    => 'Tham dự',
		'practice_req1_strong1'   => 'đủ thời gian',
		'practice_req1_mid'       => 'và',
		'practice_req1_strong2'   => 'tối thiểu 50% quãng đường',
		'practice_req1_suffix'    => 'học thực hành lái xe trên sân tập lái;',
		'practice_req2_prefix'    => 'Tham dự',
		'practice_req2_strong1'   => 'đủ quãng đường',
		'practice_req2_mid'       => 'và',
		'practice_req2_strong2'   => 'tối thiểu 50% thời gian',
		'practice_req2_suffix'    => 'học thực hành lái xe trên đường (DAT)',
		'practice_item1_title'    => 'Thực hành lái xe trên sân sa hình',
		'practice_item1_caption'  => 'Mô phỏng sa hình',
		'practice_item1_desc'     => 'Luyện xuất phát, dừng xe ngang dốc, ghép xe và xử lý giao lộ dưới sự hướng dẫn trực tiếp của giáo viên.',
		'practice_item1_image'    => '',
		'practice_item2_title'    => 'Thực hành lái xe trên đường (DAT)',
		'practice_item2_caption'  => 'Mô phỏng DAT',
		'practice_item2_desc'     => 'Hệ thống DAT ghi nhận đầy đủ quãng đường và thời gian thực hành, giúp học viên làm quen với tình huống giao thông thực tế.',
		'practice_item2_image'    => '',
	), $atts, 'hpo_platform' );

	$chplay_img   = hpo_platform_resolve_image_url( $a['chplay_image'], HPO_THEME_URI . '/assets/images/CHPlay.png' );
	$appstore_img = hpo_platform_resolve_image_url( $a['appstore_image'], HPO_THEME_URI . '/assets/images/AppStore.png' );
	$theory_img1  = hpo_platform_resolve_image_url( $a['theory_item1_image'], HPO_THEME_URI . '/assets/images/platform/xac-thuc-khuon-mat.webp' );
	$theory_img2  = hpo_platform_resolve_image_url( $a['theory_item2_image'], HPO_THEME_URI . '/assets/images/platform/ung-dung-da-nen-tang.webp' );
	$practice_img1 = hpo_platform_resolve_image_url( $a['practice_item1_image'], HPO_THEME_URI . '/assets/images/platform/thuc-hanh-mo-phong-sa-hinh.webp' );
	$practice_img2 = hpo_platform_resolve_image_url( $a['practice_item2_image'], HPO_THEME_URI . '/assets/images/platform/thuc-hanh-mo-phong-dat.webp' );

	ob_start();
	?>
	<!-- ── HỌC LT/NTS-->
	<section class="platform-v2 nts">
	  <div class="container">
	    <div
	      class="platform-v2-head"
	      data-reveal
	    >
	      <h2 class="platform-v2-title platform-v2-title--new-color">
	        <?php echo esc_html( $a['title'] ); ?>
	      </h2>
	      <div
	        class="platform-v2-dash"
	        aria-hidden="true"
	      ></div>
	    </div>

	    <div
	      class="platform-v2-download"
	      data-reveal
	      data-delay="1"
	    >
	      <div class="platform-dl-label"><?php echo esc_html( $a['download_label'] ); ?></div>
	      <div class="platform-dl-btns">
	        <a
	          href="<?php echo esc_url( $a['chplay_url'] ); ?>"
	          target="_blank"
	          rel="noopener"
	          class="platform-dl-badge"
	          aria-label="<?php echo esc_attr( $a['chplay_alt'] ); ?>"
	        >
	          <img
	            src="<?php echo esc_url( $chplay_img ); ?>"
	            alt="<?php echo esc_attr( $a['chplay_alt'] ); ?>"
	            loading="eager"
	            decoding="sync"
	          />
	        </a>
	        <a
	          href="<?php echo esc_url( $a['appstore_url'] ); ?>"
	          target="_blank"
	          rel="noopener"
	          class="platform-dl-badge"
	          aria-label="<?php echo esc_attr( $a['appstore_alt'] ); ?>"
	        >
	          <img
	            src="<?php echo esc_url( $appstore_img ); ?>"
	            alt="<?php echo esc_attr( $a['appstore_alt'] ); ?>"
	            loading="eager"
	            decoding="sync"
	          />
	        </a>
	      </div>
	    </div>

	    <div class="platform-v2-body platform-v2-body--stacked">
	      <article class="platform-v2-panel platform-v2-panel--theory">
	        <header class="platform-v2-panel-head">
	          <span class="platform-v2-panel-eyebrow"
	            ><span class="pv-num"><?php echo esc_html( $a['theory_num'] ); ?></span
	            ><span class="pv-label"><?php echo esc_html( $a['theory_label'] ); ?></span></span
	          >
	          <h3><?php echo esc_html( $a['theory_title'] ); ?></h3>
	          <div class="platform-v2-panel-description">
	            <p>
	              <?php echo esc_html( $a['theory_desc'] ); ?>
	            </p>
	            <div class="platform-v2-threshold">
	              <p>
	                <?php echo esc_html( $a['theory_threshold_prefix'] ); ?>
	                <strong><?php echo esc_html( $a['theory_threshold_strong'] ); ?></strong>
	                <?php echo esc_html( $a['theory_threshold_suffix'] ); ?>
	              </p>
	            </div>
	          </div>
	        </header>

	        <div class="platform-v2-theory-layout">
	          <div
	            class="platform-acc platform-acc--v2"
	            data-learning-group="theory"
	            data-auto-advance="false"
	            data-reveal
	            data-delay="2"
	          >
	            <div
	              class="pacc-item"
	              data-img="<?php echo esc_url( $theory_img1 ); ?>"
	              data-title="<?php echo esc_attr( $a['theory_item1_data_title'] ); ?>"
	            >
	              <button
	                type="button"
	                class="pacc-head"
	                aria-expanded="false"
	                aria-controls="theory-face-body"
	              >
	                <span class="pacc-label"><?php echo esc_html( $a['theory_item1_title'] ); ?></span>
	                <span
	                  class="pacc-toggle"
	                  aria-hidden="true"
	                ></span>
	              </button>
	              <div
	                class="pacc-body"
	                id="theory-face-body"
	              >
	                <p>
	                  <?php echo esc_html( $a['theory_item1_desc'] ); ?>
	                </p>
	              </div>
	            </div>
	            <div
	              class="pacc-item"
	              data-img="<?php echo esc_url( $theory_img2 ); ?>"
	              data-title="<?php echo esc_attr( $a['theory_item2_data_title'] ); ?>"
	            >
	              <button
	                type="button"
	                class="pacc-head"
	                aria-expanded="false"
	                aria-controls="theory-platform-body"
	              >
	                <span class="pacc-label"
	                  ><?php echo esc_html( $a['theory_item2_title'] ); ?></span
	                >
	                <span
	                  class="pacc-toggle"
	                  aria-hidden="true"
	                ></span>
	              </button>
	              <div
	                class="pacc-body"
	                id="theory-platform-body"
	              >
	                <p>
	                  <?php echo esc_html( $a['theory_item2_desc'] ); ?>
	                </p>
	              </div>
	            </div>
	          </div>
	          <div class="platform-v2-visual platform-v2-panel-visual">
	            <div class="platform-circle platform-circle--v2">
	              <img
	                src="<?php echo esc_url( $theory_img1 ); ?>"
	                alt="<?php echo esc_attr( $a['theory_item1_data_title'] ); ?>"
	                width="640"
	                height="640"
	              />
	            </div>
	          </div>
	        </div>
	      </article>

	      <article class="platform-v2-panel platform-v2-panel--practice">
	        <header class="platform-v2-panel-head">
	          <span class="platform-v2-panel-eyebrow"
	            ><span class="pv-num"><?php echo esc_html( $a['practice_num'] ); ?></span
	            ><span class="pv-label"><?php echo esc_html( $a['practice_label'] ); ?></span></span
	          >
	          <h3><?php echo esc_html( $a['practice_title'] ); ?></h3>
	          <div class="platform-v2-panel-description">
	            <p>
	              <?php echo esc_html( $a['practice_intro'] ); ?>
	            </p>
	            <ul>
	              <li>
	                <?php echo esc_html( $a['practice_req1_prefix'] ); ?>
	                <strong><?php echo esc_html( $a['practice_req1_strong1'] ); ?></strong>
	                <?php echo esc_html( $a['practice_req1_mid'] ); ?>
	                <strong><?php echo esc_html( $a['practice_req1_strong2'] ); ?></strong>
	                <?php echo esc_html( $a['practice_req1_suffix'] ); ?>
	              </li>
	              <li>
	                <?php echo esc_html( $a['practice_req2_prefix'] ); ?>
	                <strong><?php echo esc_html( $a['practice_req2_strong1'] ); ?></strong>
	                <?php echo esc_html( $a['practice_req2_mid'] ); ?>
	                <strong><?php echo esc_html( $a['practice_req2_strong2'] ); ?></strong>
	                <?php echo esc_html( $a['practice_req2_suffix'] ); ?>
	              </li>
	            </ul>
	          </div>
	        </header>

	        <div class="platform-v2-practice-layout">
	          <div
	            class="platform-acc platform-acc--v2"
	            data-learning-group="practice"
	            data-auto-advance="false"
	            data-reveal
	            data-delay="3"
	          >
	            <div
	              class="pacc-item"
	              data-img="<?php echo esc_url( $practice_img1 ); ?>"
	              data-title="<?php echo esc_attr( $a['practice_item1_caption'] ); ?>"
	            >
	              <button
	                type="button"
	                class="pacc-head"
	                aria-expanded="false"
	                aria-controls="practice-yard-body"
	              >
	                <span class="pacc-label"><?php echo esc_html( $a['practice_item1_title'] ); ?></span>
	                <span
	                  class="pacc-toggle"
	                  aria-hidden="true"
	                ></span>
	              </button>
	              <div
	                class="pacc-body"
	                id="practice-yard-body"
	                aria-hidden="true"
	              >
	                <p>
	                  <?php echo esc_html( $a['practice_item1_desc'] ); ?>
	                </p>
	              </div>
	            </div>
	            <div
	              class="pacc-item"
	              data-img="<?php echo esc_url( $practice_img2 ); ?>"
	              data-title="<?php echo esc_attr( $a['practice_item2_caption'] ); ?>"
	            >
	              <button
	                type="button"
	                class="pacc-head"
	                aria-expanded="false"
	                aria-controls="practice-road-body"
	              >
	                <span class="pacc-label"><?php echo esc_html( $a['practice_item2_title'] ); ?></span>
	                <span
	                  class="pacc-toggle"
	                  aria-hidden="true"
	                ></span>
	              </button>
	              <div
	                class="pacc-body"
	                id="practice-road-body"
	                aria-hidden="true"
	              >
	                <p>
	                  <?php echo esc_html( $a['practice_item2_desc'] ); ?>
	                </p>
	              </div>
	            </div>
	          </div>

	          <div
	            class="platform-v2-visual platform-v2-panel-visual platform-v2-visual--practice"
	          >
	            <div
	              class="platform-circle platform-v2-practice-player platform-v2-practice-image"
	            >
	              <img
	                src="<?php echo esc_url( $practice_img1 ); ?>"
	                alt="<?php echo esc_attr( $a['practice_item1_caption'] ); ?>"
	                width="1428"
	                height="803"
	                loading="lazy"
	                decoding="async"
	              />
	            </div>
	            <div class="platform-circle-cap platform-circle-cap--v2">
	              <?php echo esc_html( $a['practice_item1_caption'] ); ?>
	            </div>
	          </div>
	        </div>
	      </article>
	    </div>
	  </div>
	</section>
	<?php
	return trim( ob_get_clean() );
}
add_shortcode( 'hpo_platform', 'hpo_shortcode_platform' );
