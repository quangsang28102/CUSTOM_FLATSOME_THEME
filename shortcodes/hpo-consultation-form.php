<?php
/**
 * Shortcode Render: [hpo_consultation_form]
 * Renders F17 Consultation Registration Form (#dang-ky-tu-van.uu-reg.uu-reg--home).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function hpo_resolve_consultation_url( $raw_url ) {
    $url = trim( (string) $raw_url );
    if ( '' === $url ) {
        return home_url( '/chinh-sach-bao-mat/' );
    }
    if ( preg_match( '~^(https?://|#)~i', $url ) ) {
        return $url;
    }
    if ( 0 === strpos( $url, '/' ) ) {
        return home_url( $url );
    }
    return home_url( '/' . ltrim( $url, '/' ) );
}

function hpo_shortcode_consultation_form( $atts ) {
    $a = shortcode_atts( array(
        'eyebrow_prefix'    => 'Ưu đãi cho người dân',
        'title'             => 'Đăng ký học lái xe tại Hiệp Phát',
        'lead'              => 'Để lại thông tin, nhân viên tuyển sinh sẽ gọi tư vấn miễn phí',
        'deadline_prefix'   => 'Áp dụng đến hết ngày',
        'deadline_date'     => '31/01/2027',
        'form_heading'      => 'Đăng ký tư vấn',
        'chip_text'         => 'Miễn phí tư vấn',
        'name_label'        => 'Họ và tên',
        'name_placeholder'  => 'Nhập họ và tên',
        'phone_label'       => 'Số điện thoại',
        'phone_placeholder' => 'Ví dụ: 0911 739 119',
        'class_label'       => 'Hạng đào tạo quan tâm',
        'note_text'         => 'Nhân viên tuyển sinh sẽ liên hệ để tư vấn chương trình học và học phí. Không cần thanh toán.',
        'submit_text'       => 'Nhận tư vấn miễn phí',
        'privacy_prefix'    => 'Khi gửi, bạn đồng ý để Hiệp Phát liên hệ theo',
        'privacy_text'      => 'Chính sách bảo mật',
        'privacy_url'       => '/chinh-sach-bao-mat/',
        'hotline'           => '028.36.362.362',
    ), $atts, 'hpo_consultation_form' );

    $privacy_url = hpo_resolve_consultation_url( $a['privacy_url'] );

    ob_start();
    ?>
    <section class="course-info-section course-info-section--form" aria-label="Đăng ký tư vấn khóa học">
      <div class="course-demo-container">
        <div class="uu-reg uu-reg--home" id="dang-ky-tu-van" aria-labelledby="uu-reg-title">
          <header class="uu-reg__head">
            <div>
              <p class="uu-reg__eyebrow">
                <?php echo esc_html( $a['eyebrow_prefix'] ); ?> <span data-ten-xa></span>
              </p>
              <h2 class="uu-reg__title" id="uu-reg-title">
                <?php echo esc_html( $a['title'] ); ?>
              </h2>
              <p class="uu-reg__lead">
                <?php echo esc_html( $a['lead'] ); ?>
              </p>
            </div>
            <p class="uu-reg__date">
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3.5" y="5" width="17" height="15" rx="3" />
                <path d="M3.5 10h17M8 3v4M16 3v4" />
              </svg>
              <span>
                <?php echo esc_html( $a['deadline_prefix'] ); ?> <strong data-ngay-ket-thuc><?php echo esc_html( $a['deadline_date'] ); ?></strong>
              </span>
            </p>
          </header>

          <div class="uu-reg__grid">
            <form
              class="uu-reg__panel uu-reg__form"
              id="uu-reg-form"
              novalidate
              data-xa-base="<?php echo esc_url( HPO_THEME_URI . '/assets/data/locations/' ); ?>"
              data-endpoint="<?php echo esc_url( rest_url( 'hpo/v1/consultation' ) ); ?>"
              data-hotline="<?php echo esc_attr( $a['hotline'] ); ?>"
              aria-labelledby="uu-reg-form-title"
            >
              <div class="uu-reg__panel-head">
                <span class="uu-reg__icon" aria-hidden="true">
                  <svg viewBox="0 0 24 24">
                    <path d="M4 14v-2a8 8 0 0 1 16 0v2" />
                    <rect x="3" y="13.5" width="4" height="6" rx="1.6" />
                    <rect x="17" y="13.5" width="4" height="6" rx="1.6" />
                    <path d="M20 19.5c0 1.4-1.6 2-4 2h-2" />
                  </svg>
                </span>
                <div>
                  <h3 id="uu-reg-form-title"><?php echo esc_html( $a['form_heading'] ); ?></h3>
                </div>
                <span class="uu-reg__chip"><?php echo esc_html( $a['chip_text'] ); ?></span>
              </div>

              <div class="uu-reg__field">
                <label for="uu-reg-name"><?php echo esc_html( $a['name_label'] ); ?> <span class="uu-reg__req" aria-hidden="true">*</span></label>
                <input
                  id="uu-reg-name"
                  name="hoTen"
                  type="text"
                  autocomplete="name"
                  placeholder="<?php echo esc_attr( $a['name_placeholder'] ); ?>"
                  required
                  maxlength="80"
                  aria-describedby="uu-reg-name-err"
                />
                <p class="uu-reg__err" id="uu-reg-name-err" hidden>Vui lòng nhập họ và tên.</p>
              </div>

              <div class="uu-reg__field">
                <label for="uu-reg-phone"><?php echo esc_html( $a['phone_label'] ); ?> <span class="uu-reg__req" aria-hidden="true">*</span></label>
                <input
                  id="uu-reg-phone"
                  name="soDienThoai"
                  type="tel"
                  inputmode="tel"
                  autocomplete="tel"
                  placeholder="<?php echo esc_attr( $a['phone_placeholder'] ); ?>"
                  required
                  maxlength="16"
                  aria-describedby="uu-reg-phone-err"
                />
                <p class="uu-reg__err" id="uu-reg-phone-err" hidden>Số điện thoại chưa đúng (10–11 số, bắt đầu bằng 0).</p>
              </div>

              <fieldset class="uu-reg__field uu-reg__classes" aria-describedby="uu-reg-class-err">
                <legend><?php echo esc_html( $a['class_label'] ); ?> <span class="uu-reg__req" aria-hidden="true">*</span></legend>
                <div class="uu-reg__options">
                  <label class="uu-reg__option"><input type="radio" name="hangDaoTao" value="Hạng B - Số tự động" required /><span><b>Hạng B</b> Số tự động</span></label>
                  <label class="uu-reg__option"><input type="radio" name="hangDaoTao" value="Hạng B - Số cơ khí" /><span><b>Hạng B</b> Số cơ khí</span></label>
                  <label class="uu-reg__option"><input type="radio" name="hangDaoTao" value="Hạng C1 - Xe tải" /><span><b>Hạng C1</b> Xe tải</span></label>
                  <label class="uu-reg__option"><input type="radio" name="hangDaoTao" value="Chưa xác định" /><span><b>Chưa xác định</b> Cần tư vấn thêm</span></label>
                </div>
                <p class="uu-reg__err" id="uu-reg-class-err" hidden>Vui lòng chọn hạng đào tạo.</p>
              </fieldset>

              <div class="uu-reg__trap" aria-hidden="true">
                <label for="uu-reg-web">Website</label>
                <input id="uu-reg-web" name="website" type="text" tabindex="-1" autocomplete="off" />
              </div>

              <p class="uu-reg__note"><?php echo esc_html( $a['note_text'] ); ?></p>

              <button class="uu-reg__submit" type="submit">
                <span data-submit-text><?php echo esc_html( $a['submit_text'] ); ?></span>
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7" /></svg>
              </button>

              <p class="uu-reg__consent">
                <?php echo esc_html( $a['privacy_prefix'] ); ?> <a href="<?php echo esc_url( $privacy_url ); ?>"><?php echo esc_html( $a['privacy_text'] ); ?></a>.
              </p>

              <p class="uu-reg__status" role="status" aria-live="polite" hidden></p>
            </form>
          </div>
        </div>
      </div>
    </section>
    <?php
    return trim( ob_get_clean() );
}
add_shortcode( 'hpo_consultation_form', 'hpo_shortcode_consultation_form' );
