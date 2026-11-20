<?php
/**
 * Module: M5 Digital Learning Platform & Curriculum Modals
 * Covers Features F18 & F19:
 * - Enqueues hpo-platform-curriculum.css (after hpo-elements) and deferred hpo-platform-curriculum.js.
 * - Localizes window.HPO_PLATFORM_CONFIG for permalink-safe data, image, and video resolution.
 * - Renders the 5 active curriculum modals once in wp_footer:
 *   #chapVideoModal, #bbViewModal, #shViewModal, #lshViewModal, #engineViewModal.
 *
 * Note on dormant #videoLb (WEB-HPO-V2/index.html:1466-1515):
 * #videoLb is intentionally omitted because .syll-play is hidden via CSS
 * (display: none !important) and mon-01..06.mp4 assets do not exist in WEB-HPO-V2.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue M5 Platform & Curriculum CSS and deferred JS with localized config.
 */
function hpo_platform_curriculum_enqueue_assets() {
	wp_enqueue_style(
		'hpo-platform-curriculum',
		HPO_THEME_URI . '/assets/css/hpo-platform-curriculum.css',
		array( 'hpo-elements' ),
		hpo_asset_version( '/assets/css/hpo-platform-curriculum.css' )
	);

	wp_enqueue_script(
		'hpo-platform-curriculum-js',
		HPO_THEME_URI . '/assets/js/hpo-platform-curriculum.js',
		array(),
		hpo_asset_version( '/assets/js/hpo-platform-curriculum.js' ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	wp_localize_script(
		'hpo-platform-curriculum-js',
		'HPO_PLATFORM_CONFIG',
		array(
			'themeUrl'       => esc_url_raw( untrailingslashit( HPO_THEME_URI ) ),
			'themeAssetsUrl' => esc_url_raw( trailingslashit( HPO_THEME_URI . '/assets' ) ),
			'imagesBaseUrl'  => esc_url_raw( trailingslashit( HPO_THEME_URI . '/assets/images' ) ),
			'dataBaseUrl'    => esc_url_raw( trailingslashit( HPO_THEME_URI . '/assets/data' ) ),
			'videosBaseUrl'  => esc_url_raw( trailingslashit( HPO_THEME_URI . '/assets/videos' ) ),
			'version'        => HPO_VERSION,
		)
	);
}
add_action( 'hpo_enqueue_module_assets', 'hpo_platform_curriculum_enqueue_assets' );

/**
 * Render the 5 active curriculum modals once before </body>.
 * Dormant #videoLb is intentionally omitted (see file docblock).
 */
function hpo_platform_curriculum_render_modals() {
	static $rendered = false;
	if ( $rendered || is_admin() ) {
		return;
	}
	$rendered = true;

	$engine_logo_url = esc_url( HPO_THEME_URI . '/assets/images/favicon.png' );
	?>
	<!-- ── VIDEO MODAL — Chap bài giảng (Hư hỏng thông thường, 360°…) ── -->
	<div
	  class="chap-video-modal"
	  id="chapVideoModal"
	  data-chap-video-close="backdrop"
	>
	  <button
	    type="button"
	    class="chap-video-close"
	    id="chapVideoClose"
	    aria-label="Đóng"
	    data-chap-video-close="button"
	  >
	    <svg
	      viewBox="0 0 24 24"
	      fill="none"
	      stroke="currentColor"
	      stroke-width="2.4"
	      stroke-linecap="round"
	    >
	      <path d="M6 6l12 12M18 6 6 18" />
	    </svg>
	  </button>
	  <div class="chap-video-content">
	    <div
	      class="chap-video-title"
	      id="chapVideoTitle"
	    ></div>

	    <div class="chap-video-grid">
	      <button
	        type="button"
	        class="chap-panel-toggle chap-panel-toggle--left"
	        id="chapToggleSummary"
	        aria-label="Thu gọn / mở phần tóm tắt"
	        aria-expanded="true"
	        title="Thu gọn tóm tắt"
	      >
	        <svg
	          viewBox="0 0 24 24"
	          fill="none"
	          stroke="currentColor"
	          stroke-width="2.6"
	          stroke-linecap="round"
	          stroke-linejoin="round"
	        >
	          <polyline points="15 18 9 12 15 6" />
	        </svg>
	      </button>
	      <button
	        type="button"
	        class="chap-panel-toggle chap-panel-toggle--right"
	        id="chapToggleQuestions"
	        aria-label="Thu gọn / mở phần câu hỏi"
	        aria-expanded="true"
	        title="Thu gọn câu hỏi"
	      >
	        <svg
	          viewBox="0 0 24 24"
	          fill="none"
	          stroke="currentColor"
	          stroke-width="2.6"
	          stroke-linecap="round"
	          stroke-linejoin="round"
	        >
	          <polyline points="9 18 15 12 9 6" />
	        </svg>
	      </button>

	      <aside
	        class="chap-video-summary"
	        id="chapVideoSummary"
	        tabindex="0"
	        aria-label="Tóm tắt bài học"
	      >
	        <div class="chap-video-summary-inner">
	          <!-- summary loaded via script -->
	        </div>
	      </aside>

	      <div class="chap-video-player">
	        <iframe
	          id="chapVideoFrame"
	          title="Phát video bài giảng"
	          allow="autoplay; encrypted-media; picture-in-picture"
	          allowfullscreen
	        ></iframe>
	        <video
	          id="chapVideoEl"
	          controls
	          playsinline
	          preload="metadata"
	        >
	          <source
	            src=""
	            type="video/mp4"
	          />
	          Trình duyệt không hỗ trợ video HTML5.
	        </video>
	      </div>

	      <aside
	        class="chap-video-questions"
	        id="chapVideoQuestions"
	        tabindex="0"
	        aria-label="Câu hỏi trắc nghiệm"
	      >
	        <div class="chap-video-questions-inner">
	          <!-- questions loaded via script -->
	        </div>
	      </aside>
	    </div>
	  </div>
	</div>

	<!-- ── BIỂN BÁO VIEW — mở từ 5 loại biển báo ── -->
	<div
	  class="bb-view-modal"
	  id="bbViewModal"
	  role="dialog"
	  aria-modal="true"
	  aria-hidden="true"
	  aria-labelledby="bbViewTitle"
	>
	  <div class="bb-view-shell">
	    <div class="bb-view-topbar">
	      <div class="bb-view-heading">
	        <span>Hệ thống báo hiệu đường bộ</span>
	        <h2 id="bbViewTitle">5 loại biển báo</h2>
	      </div>
	      <button
	        type="button"
	        class="bb-view-close"
	        id="bbViewClose"
	        aria-label="Đóng"
	      >
	        <svg
	          viewBox="0 0 24 24"
	          fill="none"
	          stroke="currentColor"
	          stroke-width="2.4"
	          stroke-linecap="round"
	          stroke-linejoin="round"
	        >
	          <path d="M6 6l12 12M18 6 6 18" />
	        </svg>
	      </button>
	    </div>
	    <div
	      class="bb-view-scroll"
	      id="bbViewScroll"
	    >
	      <div class="bb-view-loading">Đang tải nội dung biển báo...</div>
	    </div>
	  </div>
	</div>

	<!-- ── SA HÌNH VIEW — mở từ 7 nguyên tắc đi sa hình ── -->
	<div
	  class="sh-view-modal"
	  id="shViewModal"
	  role="dialog"
	  aria-modal="true"
	  aria-hidden="true"
	  aria-labelledby="shViewTitle"
	>
	  <div class="sh-view-shell">
	    <div class="sh-view-topbar">
	      <div class="sh-view-heading">
	        <span>Các nguyên tắc đi sa hình</span>
	        <h2 id="shViewTitle">Nguyên tắc đi sa hình</h2>
	      </div>
	      <button
	        type="button"
	        class="sh-view-close"
	        id="shViewClose"
	        aria-label="Đóng"
	      >
	        <svg
	          viewBox="0 0 24 24"
	          fill="none"
	          stroke="currentColor"
	          stroke-width="2.4"
	          stroke-linecap="round"
	          stroke-linejoin="round"
	        >
	          <path d="M6 6l12 12M18 6 6 18" />
	        </svg>
	      </button>
	    </div>
	    <div
	      class="sh-view-scroll"
	      id="shViewScroll"
	    >
	      <div class="sh-view-loading">Đang tải nội dung sa hình...</div>
	    </div>
	  </div>
	</div>

	<!-- ── LỖI SA HÌNH VIEW — mở từ 11 bài thi sa hình ── -->
	<div
	  class="lsh-view-modal"
	  id="lshViewModal"
	  role="dialog"
	  aria-modal="true"
	  aria-hidden="true"
	  aria-labelledby="lshViewTitle"
	>
	  <div class="lsh-view-shell">
	    <div class="lsh-view-topbar">
	      <div class="lsh-view-heading">
	        <span>Phương pháp thực hành lái xe tổng hợp</span>
	        <h2 id="lshViewTitle">11 bài thi sa hình</h2>
	      </div>
	      <button
	        type="button"
	        class="lsh-view-close"
	        id="lshViewClose"
	        aria-label="Đóng"
	      >
	        <svg
	          viewBox="0 0 24 24"
	          fill="none"
	          stroke="currentColor"
	          stroke-width="2.4"
	          stroke-linecap="round"
	          stroke-linejoin="round"
	        >
	          <path d="M6 6l12 12M18 6 6 18" />
	        </svg>
	      </button>
	    </div>
	    <div
	      class="lsh-view-scroll"
	      id="lshViewScroll"
	    >
	      <div class="lsh-view-loading">Đang tải nội dung lỗi sa hình...</div>
	    </div>
	  </div>
	</div>

	<!-- ── ĐỘNG CƠ 4 KỲ VIEW — mở từ bài giảng Chương 2 ── -->
	<div
	  class="engine-view-modal"
	  id="engineViewModal"
	  role="dialog"
	  aria-modal="true"
	  aria-hidden="true"
	  aria-labelledby="engineViewTitle"
	>
	  <div class="engine-view-shell">
	    <div class="engine-view-topbar">
	      <div class="engine-view-heading">
	        <img
	          class="engine-view-logo"
	          src="<?php echo $engine_logo_url; ?>"
	          alt="Logo Trung tâm Hiệp Phát"
	        />
	        <div class="engine-view-heading-copy">
	          <span>Động cơ xe ô tô</span>
	          <h2 id="engineViewTitle">Nguyên lý làm việc của động cơ 4 kỳ</h2>
	        </div>
	      </div>
	      <div class="engine-view-actions">
	        <button
	          type="button"
	          class="engine-view-voice"
	          id="engineVoiceToggle"
	          aria-label="Bật giọng đọc"
	          aria-pressed="false"
	          title="Bật giọng đọc"
	        >
	          <svg
	            class="engine-view-voice-on"
	            viewBox="0 0 24 24"
	            fill="none"
	            stroke="currentColor"
	            stroke-width="2"
	            stroke-linecap="round"
	            stroke-linejoin="round"
	            aria-hidden="true"
	          >
	            <path d="M11 5 6 9H2v6h4l5 4V5z" />
	            <path d="M15.5 8.5a5 5 0 0 1 0 7" />
	            <path d="M19 5a10 10 0 0 1 0 14" />
	          </svg>
	          <svg
	            class="engine-view-voice-off"
	            viewBox="0 0 24 24"
	            fill="none"
	            stroke="currentColor"
	            stroke-width="2"
	            stroke-linecap="round"
	            stroke-linejoin="round"
	            aria-hidden="true"
	          >
	            <path d="M11 5 6 9H2v6h4l5 4V5z" />
	            <path d="m17 9 5 6m0-6-5 6" />
	          </svg>
	        </button>
	        <button
	          type="button"
	          class="engine-view-close"
	          id="engineViewClose"
	          aria-label="Đóng"
	        >
	          <svg
	            viewBox="0 0 24 24"
	            fill="none"
	            stroke="currentColor"
	            stroke-width="2.4"
	            stroke-linecap="round"
	            stroke-linejoin="round"
	          >
	            <path d="M6 6l12 12M18 6 6 18" />
	          </svg>
	        </button>
	      </div>
	    </div>
	    <div
	      class="engine-view-scroll"
	      id="engineViewScroll"
	    >
	      <div class="engine-view-loading">Đang tải nội dung động cơ 4 kỳ...</div>
	    </div>
	  </div>
	</div>
	<?php
}
add_action( 'wp_footer', 'hpo_platform_curriculum_render_modals', 25 );
