# QUY CHUẨN CẤU TRÚC DỰ ÁN (FLATSOME CHILD THEME ARCHITECTURE)

Tài liệu này quy định cấu trúc thư mục, quy tắc đặt tên và cách nạp tài nguyên bắt buộc cho dự án WordPress sử dụng **Flatsome Child Theme**. Mọi thao tác thêm/sửa code của Developer hoặc AI Agent đều phải tuân thủ tuyệt đối cấu trúc này.

---

## 1. NGUYÊN TẮC CỐT LÕI (CORE PRINCIPLES)

1. **Tuyệt đối không can thiệp Theme Cha:** Không chỉnh sửa bất kỳ file nào trong `wp-content/themes/flatsome/`. Mọi mã nguồn tùy biến phải đặt trong `wp-content/themes/flatsome-child/`.
2. **Kiến trúc Module hóa (Modular Architecture):** Không viết dồn code vào `functions.php` hay `style.css`. Mỗi chức năng, mỗi khối giao diện (UX Element) phải được tách thành file riêng biệt.
3. **Tiền tố dự án (Project Prefix):** Sử dụng tiền tố thống nhất (ví dụ: `hpo_` cho hàm PHP/shortcode và `hpo-` cho tên file, class CSS) để tránh xung đột với core WordPress và Flatsome.

---

## 2. CÂY THƯ MỤC CHUẨN (`flatsome-child`)

```text
wp-content/themes/flatsome-child/
├── assets/
│   ├── css/
│   │   ├── hpo-variables.css        # Biến màu sắc (:root), typography, thiết lập chung từ HTML gốc
│   │   ├── hpo-common.css           # CSS dùng chung (Header, Footer, Buttons, Form, Utilities)
│   │   └── hpo-elements.css         # CSS dành riêng cho các Custom UX Elements
│   ├── js/
│   │   └── hpo-main.js              # JS khởi tạo hiệu ứng (Slider, Tabs, Counter, Accordion...)
│   ├── fonts/                       # Font chữ local (nếu không dùng Google Fonts)
│   └── images/                      # Ảnh tĩnh/SVG/Icon cố định của giao diện
│
├── inc/
│   ├── setup.php                    # Dọn dẹp WP core, tối ưu SEO, tắt script thừa
│   ├── enqueue.php                  # Quản lý nạp CSS/JS có điều kiện và gắn defer
│   ├── cpt-acf.php                  # Khai báo Custom Post Types & Taxonomies (nếu có)
│   ├── helpers.php                  # Các hàm hỗ trợ dùng chung (xử lý ảnh, cắt chuỗi...)
│   └── ux-elements/                 # Khai báo giao diện nhập liệu Admin cho UX Builder
│       ├── hpo-hero.php
│       ├── hpo-courses.php
│       └── ...
│
├── shortcodes/                      # Nơi chứa khung HTML (Render Frontend) của UX Elements
│   ├── hpo-hero.php
│   ├── hpo-courses.php
│   └── ...
│
├── template-parts/                  # Các mảnh giao diện tái sử dụng (dùng cho Archive/Single CPT)
│   └── content-course-card.php
│
├── functions.php                    # File điều phối trung tâm (chỉ chứa lệnh require_once)
└── style.css                        # File khai báo thông tin Child Theme mặc định
```

---

## 3. QUY TẮC KHỞI TẠO CÁC FILE NỀN TẢNG

### 3.1. File `functions.php` (Chỉ dùng để nạp module)
Giữ file `functions.php` ngắn gọn, tự động nạp toàn bộ các Shortcode và UX Builder Elements trong thư mục tương ứng:

```php
<?php
/**
 * Flatsome Child Theme Functions
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'HPO_THEME_DIR', get_stylesheet_directory() );
define( 'HPO_THEME_URI', get_stylesheet_directory_uri() );
define( 'HPO_VERSION', '1.0.0' );

// 1. Nạp cấu hình hệ thống & Enqueue Assets
require_once HPO_THEME_DIR . '/inc/setup.php';
require_once HPO_THEME_DIR . '/inc/enqueue.php';
require_once HPO_THEME_DIR . '/inc/helpers.php';

// 2. Tự động nạp tất cả các file Shortcode Render trong thư mục /shortcodes/
foreach ( glob( HPO_THEME_DIR . '/shortcodes/*.php' ) as $shortcode_file ) {
    require_once $shortcode_file;
}

// 3. Tự động nạp tất cả cấu hình UX Builder Elements trong thư mục /inc/ux-elements/
add_action( 'ux_builder_setup', function() {
    foreach ( glob( HPO_THEME_DIR . '/inc/ux-elements/*.php' ) as $ux_element_file ) {
        require_once $ux_element_file;
    }
});
```

### 3.2. File `inc/enqueue.php` (Nạp CSS/JS chuẩn Core Web Vitals)
Mọi file CSS từ source HTML phải nạp sau `flatsome-main`. Mọi file JS tùy chỉnh phải có chiến lược `defer`:

```php
<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function hpo_enqueue_scripts() {
    // 1. CSS Variables & Common
    wp_enqueue_style(
        'hpo-variables',
        HPO_THEME_URI . '/assets/css/hpo-variables.css',
        array( 'flatsome-main' ),
        HPO_VERSION
    );

    wp_enqueue_style(
        'hpo-common',
        HPO_THEME_URI . '/assets/css/hpo-common.css',
        array( 'hpo-variables' ),
        HPO_VERSION
    );

    // 2. CSS cho các Custom UX Elements
    wp_enqueue_style(
        'hpo-elements',
        HPO_THEME_URI . '/assets/css/hpo-elements.css',
        array( 'hpo-common' ),
        HPO_VERSION
    );

    // 3. JS hiệu ứng chính (Bắt buộc defer để tối ưu điểm PageSpeed)
    wp_enqueue_script(
        'hpo-main-js',
        HPO_THEME_URI . '/assets/js/hpo-main.js',
        array( 'jquery' ),
        HPO_VERSION,
        array(
            'in_footer' => true,
            'strategy'  => 'defer',
        )
    );
}
add_action( 'wp_enqueue_scripts', 'hpo_enqueue_scripts', 20 );
```

### 3.3. File `inc/setup.php` (Dọn dẹp mã nguồn thừa để tối ưu SEO)
```php
<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function hpo_cleanup_wordpress_bloat() {
    // Tắt WP Emoji gây chậm trang
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );

    // Bỏ tạo thẻ <p> tự động trong Contact Form 7 để giữ nguyên cấu trúc HTML gốc
    add_filter( 'wpcf7_autop_or_not', '__return_false' );
}
add_action( 'init', 'hpo_cleanup_wordpress_bloat' );

// Gỡ CSS Gutenberg Block trên Frontend nếu trang dùng hoàn toàn UX Builder
add_action( 'wp_enqueue_scripts', function() {
    if ( ! is_single() ) {
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
    }
}, 100 );
```

---

## 4. QUY TẮC ĐỒNG BỘ TÀI NGUYÊN TỪ SOURCE HTML

1. **Hình ảnh mẫu & Icon tĩnh:** Copy toàn bộ thư mục chứa icon SVG, ảnh nền trang trí từ repo HTML sang `flatsome-child/assets/images/`. Sửa lại đường dẫn `url(...)` trong CSS thành đường dẫn tương đối `../images/...`.
2. **Hình ảnh nội dung (Banner, Khóa học, Tin tức):** Upload lên **WordPress Media Library** (ưu tiên định dạng `.webp`) để lấy `attachment_id`, phục vụ quản trị động trong UX Builder.
3. **Thư viện bên thứ 3 (Swiper, Slick, AOS, Bootstrap Grid):**
   - Kiểm tra xem Flatsome đã có sẵn tính năng tương đương chưa (Flatsome có sẵn lưới `row`/`col`, slider `Flickity`, popup `Magnific Popup`).
   - Nếu bắt buộc phải dùng thư viện từ source HTML để giữ đúng hiệu ứng đặc thù, chỉ enqueue thư viện đó ở những trang thực sự sử dụng (ví dụ: dùng `if ( is_front_page() )` trong `inc/enqueue.php`).