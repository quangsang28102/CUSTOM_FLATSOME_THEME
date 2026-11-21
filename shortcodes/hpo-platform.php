<?php
/**
 * Shortcode Render: [hpo_platform]
 * Renders Digital Learning Platform section (.platform-v2.dts)
 * Updated to V3 Design (chốt 20/11/2026):
 * - Panel 01 Theory: Navy card, 70% gauge with FaceID, 3 green cards, embedded 6-subject curriculum, 2 simulation cards
 * - Panel 02 Practice: 2 rows (Sa hình & DAT) with condition badges and red cards
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
		'title'                 => 'ĐÀO TẠO LÁI XE TRÊN NỀN TẢNG SỐ',
		// 01. Lý thuyết
		'theory_num'            => '01',
		'theory_label'          => 'Lý thuyết',
		'theory_title'          => 'Học lý thuyết trên nền tảng số',
		'theory_desc'           => 'Người học hoàn thành nội dung, chương trình, ghi nhận thời gian học thực bằng xác thực khuôn mặt. Hệ thống ghi nhận quá trình hoàn tất đầy đủ nội dung và thời gian thực của người học.',
		'theory_item1_title'    => 'Xác thực khuôn mặt',
		'theory_item1_desc'     => 'Người học hoàn thành nội dung và ghi nhận thời gian học thực bằng xác thực khuôn mặt, giúp quá trình học minh bạch và đúng tiến độ.',
		'theory_item2_title'    => 'Ứng dụng đa nền tảng (Windows, Android,&nbsp;iOS)',
		'theory_item2_desc'     => 'Học viên có thể học mọi lúc, mọi nơi trên Windows, Android và iOS, chủ động thời gian học và giảm chi phí di chuyển.',
		'theory_gauge_image'    => '',
		'theory_gauge_alt'      => 'Xác thực khuôn mặt khi học lý thuyết',
		'theory_gauge_caption'  => 'Người học lái xe được kiểm tra để xét hoàn thành khóa đào tạo khi tham dự <strong>tối thiểu&nbsp;70%</strong> thời gian học nội dung đào tạo lý thuyết;',
		'theory_side_lead'      => 'HỌC LÝ THUYẾT&nbsp;- luôn sẵn&nbsp;sàng mọi&nbsp;lúc, mọi&nbsp;nơi',
		'side_img1'             => '',
		'side_img2'             => '',
		'side_img3'             => '',
		'sims_lead'             => 'Rèn kỹ năng lái xe thực hành môi trường&nbsp;ảo',
		'sim1_image'            => '',
		'sim1_caption'          => 'Mô phỏng sa hình',
		'sim2_image'            => '',
		'sim2_caption'          => 'Mô phỏng DAT',
		// 02. Thực hành
		'practice_num'          => '02',
		'practice_label'        => 'Thực hành',
		'practice_safe_text'    => 'An toàn, hiệu quả với giáo viên hướng dẫn 1&nbsp;-&nbsp;1',
		'practice_lead'         => 'Người học lái xe được kiểm tra để xét hoàn thành khóa đào tạo khi:',
		'row1_tag'              => 'SA HÌNH',
		'row1_title'            => 'Thực hành lái xe trên sân sa hình',
		'row1_desc'             => 'Luyện xuất phát, dừng xe ngang dốc, ghép xe và xử lý giao lộ dưới sự hướng dẫn trực tiếp của giáo viên.',
		'row1_cond'             => 'Tham dự <strong>đủ thời gian</strong> và <strong>tối thiểu 50% quãng đường</strong> học thực hành lái xe trên sân tập lái;',
		'card1_title'           => 'SA HÌNH',
		'card1_image'           => '',
		'card1_lead'            => 'Tích hợp ôn luyện lý thuyết trên HPO:',
		'card1_note'            => '(hạng&nbsp;B: 11&nbsp;bài&nbsp;thi, hạng&nbsp;C1: 10&nbsp;bài&nbsp;thi)',
		'row2_tag'              => 'DAT',
		'row2_title'            => 'Thực hành lái xe trên đường (DAT)',
		'row2_desc'             => 'Hệ thống DAT ghi nhận đầy đủ quãng đường và thời gian thực hành, giúp học viên làm quen với tình huống giao thông thực tế.',
		'row2_cond'             => 'Tham dự <strong>đủ quãng đường</strong> và <strong>tối thiểu 50% thời gian</strong> học thực hành lái xe trên đường (DAT)',
		'card2_title'           => 'DAT',
		'card2_image'           => '',
	), $atts, 'hpo_platform' );

	$theory_gauge_img = hpo_platform_resolve_image_url( $a['theory_gauge_image'], HPO_THEME_URI . '/assets/images/platform/xac-thuc-khuon-mat.webp' );
	$side_img1        = hpo_platform_resolve_image_url( $a['side_img1'], HPO_THEME_URI . '/assets/images/platform/hoc-ly-thuyet-5-mon.webp' );
	$side_img2        = hpo_platform_resolve_image_url( $a['side_img2'], HPO_THEME_URI . '/assets/images/platform/hoc-ly-thuyet-mo-hinh-3d.webp' );
	$side_img3        = hpo_platform_resolve_image_url( $a['side_img3'], HPO_THEME_URI . '/assets/images/platform/hoc-ly-thuyet-bai-giang-360.webp' );
	$sim_img1         = hpo_platform_resolve_image_url( $a['sim1_image'], HPO_THEME_URI . '/assets/images/platform/thuc-hanh-mo-phong-sa-hinh.webp' );
	$sim_img2         = hpo_platform_resolve_image_url( $a['sim2_image'], HPO_THEME_URI . '/assets/images/platform/thuc-hanh-mo-phong-dat.webp' );
	$drive_img1       = hpo_platform_resolve_image_url( $a['card1_image'], HPO_THEME_URI . '/assets/images/platform/thuc-hanh-sa-hinh-xe-tren-san-nhin-tu-tren.webp' );
	$drive_img2       = hpo_platform_resolve_image_url( $a['card2_image'], HPO_THEME_URI . '/assets/images/platform/thuc-hanh-dat-xe-tap-lai-tach-nen.webp' );

	ob_start();
	?>
	<!-- ===== Đào tạo lái xe trên nền tảng số — thiết kế V3 (chốt 20/11/2026) ===== -->
	<section class="platform-v2 dts" aria-labelledby="dts-title">
	  <div class="container">
	    <div class="platform-v2-head">
	      <h2 class="platform-v2-title platform-v2-title--new-color" id="dts-title"><?php echo esc_html( $a['title'] ); ?></h2>
	      <div class="platform-v2-dash" aria-hidden="true"></div>
	    </div>

	    <div class="dts-variant dts-variant--b" data-dts-variant="b">
	      <!-- 01 LÝ THUYẾT -->
	      <article class="dts-panel dts-b-theory">
	        <div class="dts-b-hero">
	          <div class="dts-b-hero__text">
	            <p class="dts-eyebrow dts-eyebrow--light">
	              <span class="dts-eyebrow__num"><?php echo esc_html( $a['theory_num'] ); ?></span>
	              <span class="dts-eyebrow__label"><?php echo esc_html( $a['theory_label'] ); ?></span>
	            </p>
	            <h3 class="dts-h3"><?php echo esc_html( $a['theory_title'] ); ?></h3>
	            <p class="dts-desc"><?php echo esc_html( $a['theory_desc'] ); ?></p>
	            <ul class="dts-b-feats">
	              <li>
	                <span class="dts-ico">
	                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
	                    <path d="M4 8V6a2 2 0 0 1 2-2h2M16 4h2a2 2 0 0 1 2 2v2M20 16v2a2 2 0 0 1-2 2h-2M8 20H6a2 2 0 0 1-2-2v-2"/><circle cx="12" cy="10" r="3"/><path d="M7.5 17a5 5 0 0 1 9 0"/>
	                  </svg>
	                </span>
	                <div>
	                  <h4><?php echo esc_html( $a['theory_item1_title'] ); ?></h4>
	                  <p><?php echo esc_html( $a['theory_item1_desc'] ); ?></p>
	                </div>
	              </li>
	              <li>
	                <span class="dts-ico">
	                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
	                    <rect x="2" y="4" width="14" height="10" rx="1.5"/><path d="M1 18h16"/><rect x="17.5" y="8" width="5" height="12" rx="1.2"/>
	                  </svg>
	                </span>
	                <div>
	                  <h4><?php echo wp_kses_post( $a['theory_item2_title'] ); ?></h4>
	                  <p><?php echo esc_html( $a['theory_item2_desc'] ); ?></p>
	                </div>
	              </li>
	            </ul>
	          </div>
	          <figure class="dts-b-hero__gauge">
	            <div class="dts-b-ring" style="--p: 70">
	              <img src="<?php echo esc_url( $theory_gauge_img ); ?>" alt="<?php echo esc_attr( $a['theory_gauge_alt'] ); ?>" width="640" height="640" loading="lazy" decoding="async" />
	              <span class="dts-b-ring__badge">70%</span>
	            </div>
	            <figcaption>
	              <?php echo wp_kses_post( $a['theory_gauge_caption'] ); ?>
	            </figcaption>
	          </figure>
	        </div>

	        <div class="dts-b-learn">
	          <aside class="dts-b-side">
	            <p class="dts-b-side__lead"><?php echo wp_kses_post( $a['theory_side_lead'] ); ?></p>
	            <ul class="dts-b-side__list">
	              <li class="dts-b-side__item">
	                <img src="<?php echo esc_url( $side_img1 ); ?>" alt="Minh họa 5 môn lý thuyết: đèn giao thông, giáo viên, sách luật và xe tải" width="560" height="430" loading="lazy" decoding="async" />
	                <div><h5>5 môn lý thuyết</h5></div>
	              </li>
	              <li class="dts-b-side__item">
	                <img src="<?php echo esc_url( $side_img2 ); ?>" alt="Minh họa mô hình xe ô tô 3D trên màn hình" width="560" height="396" loading="lazy" decoding="async" />
	                <div><h5>Mô hình minh họa 3D</h5><p>Trực quan, sinh động</p></div>
	              </li>
	              <li class="dts-b-side__item">
	                <img src="<?php echo esc_url( $side_img3 ); ?>" alt="Minh họa bài giảng 360 độ trên điện thoại" width="560" height="514" loading="lazy" decoding="async" />
	                <div><h5>Bài giảng 360&nbsp;độ</h5><p>Dễ hiểu, dễ nhớ, dễ tiếp thu</p></div>
	              </li>
	            </ul>
	          </aside>

	          <div class="dts-curr-slot">
	            <?php
	            // Render the 6 curriculum subjects inside the theory slot
	            if ( function_exists( 'hpo_shortcode_curriculum' ) ) {
	                echo hpo_shortcode_curriculum( array( 'is_embedded' => 'true' ) );
	            }
	            ?>
	          </div>

	          <p class="dts-b-side__lead dts-b-sims__lead"><?php echo wp_kses_post( $a['sims_lead'] ); ?></p>
	          <div class="dts-b-sims">
	            <figure class="dts-b-sim">
	              <img src="<?php echo esc_url( $sim_img1 ); ?>" alt="Mô phỏng sa hình: sân sát hạch đúng kích thước sân thật" width="1428" height="803" loading="lazy" decoding="async" />
	              <figcaption><?php echo esc_html( $a['sim1_caption'] ); ?></figcaption>
	            </figure>
	            <figure class="dts-b-sim">
	              <img src="<?php echo esc_url( $sim_img2 ); ?>" alt="Mô phỏng DAT: tuyến đường và tình huống lái xe thực tế" width="1428" height="803" loading="lazy" decoding="async" />
	              <figcaption><?php echo esc_html( $a['sim2_caption'] ); ?></figcaption>
	            </figure>
	          </div>
	        </div>
	      </article>

	      <!-- 02 THỰC HÀNH -->
	      <article class="dts-panel dts-panel--practice dts-b-practice">
	        <header class="dts-b-phead">
	          <p class="dts-eyebrow dts-eyebrow--red">
	            <span class="dts-eyebrow__num"><?php echo esc_html( $a['practice_num'] ); ?></span>
	            <span class="dts-eyebrow__label"><?php echo esc_html( $a['practice_label'] ); ?></span>
	          </p>
	          <p class="dts-safe">
	            <span class="dts-ico dts-ico--sm">
	              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
	                <circle cx="8" cy="8" r="3"/><circle cx="17" cy="9" r="2.5"/><path d="M2 20a6 6 0 0 1 12 0M14 20a4.5 4.5 0 0 1 8 0"/>
	              </svg>
	            </span>
	            <?php echo wp_kses_post( $a['practice_safe_text'] ); ?>
	          </p>
	          <p class="dts-b-phead__lead"><?php echo esc_html( $a['practice_lead'] ); ?></p>
	        </header>

	        <div class="dts-b-rows">
	          <!-- Hàng 1: Sa hình -->
	          <article class="dts-b-row">
	            <div class="dts-b-row__main">
	              <p class="dts-b-row__tag"><?php echo esc_html( $a['row1_tag'] ); ?></p>
	              <h4><?php echo esc_html( $a['row1_title'] ); ?></h4>
	              <p class="dts-b-row__desc"><?php echo esc_html( $a['row1_desc'] ); ?></p>
	              <p class="dts-cond">
	                <span class="dts-cond__ico">
	                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
	                    <path d="M20 6 9 17l-5-5"/>
	                  </svg>
	                </span>
	                <span><?php echo wp_kses_post( $a['row1_cond'] ); ?></span>
	              </p>
	            </div>
	            <div class="dts-b-row__side dts-b-row__side--card">
	              <article class="pv2-drive-card pv2-drive-card--yard" aria-labelledby="dts-b-drive-yard-title">
	                <h4 id="dts-b-drive-yard-title" class="pv2-drive-card__title"><?php echo esc_html( $a['card1_title'] ); ?></h4>
	                <img class="pv2-drive-card__photo" src="<?php echo esc_url( $drive_img1 ); ?>" alt="Xe tập lái trên sân sa hình nhìn từ trên xuống" width="509" height="294" loading="lazy" decoding="async" />
	                <div class="pv2-drive-card__body">
	                  <p class="pv2-drive-card__lead"><?php echo esc_html( $a['card1_lead'] ); ?></p>
	                  <ol class="pv2-drive-card__steps">
	                    <li>Các nguyên tắc xử lý trên sa hình</li>
	                    <li>Hướng dẫn thao tác các bài thực hành</li>
	                  </ol>
	                  <p class="pv2-drive-card__note"><?php echo wp_kses_post( $a['card1_note'] ); ?></p>
	                </div>
	              </article>
	            </div>
	          </article>

	          <!-- Hàng 2: DAT -->
	          <article class="dts-b-row">
	            <div class="dts-b-row__main">
	              <p class="dts-b-row__tag"><?php echo esc_html( $a['row2_tag'] ); ?></p>
	              <h4><?php echo esc_html( $a['row2_title'] ); ?></h4>
	              <p class="dts-b-row__desc"><?php echo esc_html( $a['row2_desc'] ); ?></p>
	              <p class="dts-cond">
	                <span class="dts-cond__ico">
	                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
	                    <path d="M20 6 9 17l-5-5"/>
	                  </svg>
	                </span>
	                <span><?php echo wp_kses_post( $a['row2_cond'] ); ?></span>
	              </p>
	            </div>
	            <div class="dts-b-row__side dts-b-row__side--card">
	              <article class="pv2-drive-card pv2-drive-card--road" aria-labelledby="dts-b-drive-road-title">
	                <h4 id="dts-b-drive-road-title" class="pv2-drive-card__title"><?php echo esc_html( $a['card2_title'] ); ?></h4>
	                <img class="pv2-drive-card__photo" src="<?php echo esc_url( $drive_img2 ); ?>" alt="Xe tập lái chở giáo viên và học viên trên đường" width="296" height="244" loading="lazy" decoding="async" />
	                <div class="pv2-drive-card__body">
	                  <ol class="pv2-drive-card__steps">
	                    <li>Tích hợp môn học lý thuyết kỹ thuật lái xe:
	                      <ul class="pv2-drive-card__bullets">
	                        <li>Các video kỹ thuật lái xe</li>
	                        <li>Kỹ năng xử lý tình huống giao thông phức tạp</li>
	                      </ul>
	                    </li>
	                    <li>Thời gian:
	                      <ul class="pv2-drive-card__bullets pv2-drive-card__times">
	                        <li><span class="pv2-drive-card__key">Hạng B số tự động</span><span class="pv2-drive-card__val">: 710km&nbsp;-&nbsp;17&nbsp;giờ</span></li>
	                        <li><span class="pv2-drive-card__key">Hạng B số cơ khí</span><span class="pv2-drive-card__val">: 810km&nbsp;-&nbsp;20&nbsp;giờ</span></li>
	                        <li><span class="pv2-drive-card__key">Hạng C1</span><span class="pv2-drive-card__val">: 825km&nbsp;-&nbsp;24&nbsp;giờ</span></li>
	                      </ul>
	                    </li>
	                  </ol>
	                </div>
	              </article>
	            </div>
	          </article>
	        </div>
	      </article>
	    </div>
	  </div>
	</section>
	<?php
	return trim( ob_get_clean() );
}
add_shortcode( 'hpo_platform', 'hpo_shortcode_platform' );
