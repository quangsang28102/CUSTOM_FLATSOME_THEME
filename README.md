# HPO - Theme Con Tùy Biến Cho Flatsome (Flatsome Child Theme)

[![WordPress](https://img.shields.io/badge/WordPress-6.x-blue.svg)](https://wordpress.org/)
[![Flatsome](https://img.shields.io/badge/Flatsome-Child%20Theme-orange.svg)](https://uxthemes.com/)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-purple.svg)](https://php.net/)
[![Core Web Vitals](https://img.shields.io/badge/Core%20Web%20Vitals-Optimized-brightgreen.svg)]()

Theme con (Child Theme) chuyên nghiệp được xây dựng trên nền tảng **Flatsome Theme**, thiết kế riêng cho dự án **HPO**. Kiến trúc theme được chuẩn hóa 100% theo mô hình module hóa, tích hợp sâu vào công cụ kéo thả **UX Builder** của Flatsome và tối ưu hóa toàn diện cho **SEO On-page & Core Web Vitals**.

---

## 🌟 Điểm Nổi Bật Về Kiến Trúc

- **Cách ly tuyệt đối (100% Non-destructive):** Không chỉnh sửa bất kỳ dòng code nào của theme mẹ `flatsome/`. An toàn tuyệt đối khi cập nhật theme mẹ trong tương lai.
- **Ghép cặp Shortcode & UX Builder Element:** Mỗi khối section trang chủ được phân tách thành 1 cặp file độc lập:
  - Khung giao diện HTML Frontend: `shortcodes/{prefix}-{slug}.php`
  - Bảng điều khiển trực quan trong UX Builder: `inc/ux-elements/{prefix}-{slug}.php` (giúp người quản trị dễ dàng kéo thả, sửa text, đổi ảnh mà không cần biết code).
- **Tối ưu Core Web Vitals & SEO:**
  - `CLS = 0`: Mọi ảnh đều có thuộc tính tỉ lệ khung hình (aspect-ratio) hoặc kích thước rõ ràng, triệt tiêu hoàn toàn hiện tượng giật màn hình khi tải trang.
  - `LCP Tối ưu`: Banner đầu trang tải với ưu tiên cao (`loading="eager"` + `fetchpriority="high"`).
  - Tải script không chặn hiển thị: Toàn bộ JavaScript tùy biến được nạp với chiến lược `defer`.
- **Dọn dẹp Bloatware:** Tự động gỡ bỏ các script mặc định không cần thiết của WordPress core (wp-emoji, css thừa) để đạt tốc độ tải trang cao nhất.

---

## 📁 Cấu Trúc Thư Mục Theme

```text
flatsome-child/
├── assets/
│   ├── css/
│   │   ├── hpo-variables.css       # Biến màu sắc (:root), font chữ, spacing
│   │   ├── hpo-common.css          # CSS dùng chung (Header, Footer, Button, Form)
│   │   └── hpo-elements.css        # CSS cho từng khối UX Elements tùy biến
│   ├── js/
│   │   └── hpo-main.js             # JavaScript hiệu ứng (Tabs, Accordion, Slider...)
│   └── media/                      # Ảnh tĩnh, icon SVG và media phục vụ giao diện
│
├── inc/
│   ├── setup.php                   # Tối ưu WP core, dọn dẹp script thừa
│   ├── enqueue.php                 # Nạp CSS/JS chuẩn thứ tự phụ thuộc và defer
│   ├── helpers.php                 # Các hàm tiện ích hỗ trợ xử lý ảnh, chuỗi
│   ├── cpt-acf.php                 # Khai báo Custom Post Types (nếu có)
│   └── ux-elements/                # Đăng ký các khối tùy biến vào UX Builder
│
├── shortcodes/                     # Nơi chứa mã HTML Render Frontend của từng block
├── template-parts/                 # Các mảnh giao diện tái sử dụng (Card khóa học, blog...)
├── FLATSOME CHILD THEME ARCHITECTURE.md # Bản đặc tả quy chuẩn kiến trúc chi tiết
├── functions.php                   # File nạp tự động toàn bộ module qua glob()
├── style.css                       # Khai báo thông tin Child Theme
└── README.md                       # Tài liệu hướng dẫn sử dụng
```

---

## 🚀 Hướng Dẫn Cài Đặt & Kích Hoạt

### 1. Yêu cầu hệ thống
- WordPress 6.x trở lên.
- Đã cài đặt theme mẹ **Flatsome** bản quyền trong thư mục `wp-content/themes/flatsome/`.
- PHP 8.0+.

### 2. Cài đặt vào website WordPress
1. Clone hoặc tải mã nguồn theme con này về máy:
   ```bash
   git clone https://github.com/quangsang28102/CUSTOM_FLATSOME_THEME.git flatsome-child
   ```
2. Đặt thư mục vừa tải vào đường dẫn:
   ```text
   wp-content/themes/flatsome-child/
   ```
3. Truy cập vào trang Quản trị WordPress: **Giao diện (Appearance) -> Giao diện (Themes)**.
4. Nhấn **Kích hoạt (Activate)** giao diện **Flatsome Child - HPO**.

### 3. Tùy biến nội dung qua UX Builder
- Truy cập vào bất kỳ Trang nào (ví dụ: Trang chủ), chọn **Sửa bằng UX Builder (Edit with UX Builder)**.
- Trong danh sách các Element, tìm nhóm phần tử **HPO Elements** để kéo thả các section tùy biến vào trang và chỉnh sửa trực quan.

---

## 👤 Tác Giả & Bản Quyền
- **Tác giả:** Quang Sang ([@quangsang28102](https://github.com/quangsang28102))
- **Mã nguồn:** Toàn bộ code tùy biến trong Child Theme này được phát hành theo giấy phép GNU General Public License v2 hoặc mới hơn.
- **Theme mẹ:** Flatsome Theme thuộc bản quyền của UX Themes.
