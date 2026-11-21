<?php
/**
 * UX Builder Element: HPO Course Info Panel (14/11/2026 Redesign)
 * Tag: [hpo_course_info]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_ux_builder_shortcode( 'hpo_course_info', array(
    'name'     => __( 'HPO Course Info Panel', 'flatsome' ),
    'category' => __( 'HPO Elements', 'flatsome' ),
    'priority' => 31,
    'options'  => array(
        'group_integrated' => array(
            'type'    => 'group',
            'heading' => __( 'Cột 1: Ôn tập & Kiểm tra tích hợp', 'flatsome' ),
            'options' => array(
                'integrated_title' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề cột', 'flatsome' ),
                    'default' => 'Thời gian ôn tập, kiểm tra tích hợp giữa học lý thuyết và thực hành',
                ),
                'step1_text' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Bước 1 — Mô tả', 'flatsome' ),
                    'default' => 'Ôn tập xe thiết bị',
                ),
                'step1_value' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Bước 1 — Thời gian', 'flatsome' ),
                    'default' => '2 giờ',
                ),
                'step2_text' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Bước 2 — Mô tả', 'flatsome' ),
                    'default' => 'Xét kiểm tra hoàn thành khóa học xe thiết bị có chấm điểm trên sân sát hạch',
                ),
                'step2_value' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Bước 2 — Thời gian', 'flatsome' ),
                    'default' => '20 phút',
                ),
            ),
        ),
        'group_short' => array(
            'type'    => 'group',
            'heading' => __( 'Cột 2: Khóa học ngắn hạn', 'flatsome' ),
            'options' => array(
                'short_badge' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nhãn badge', 'flatsome' ),
                    'default' => 'Khóa học ngắn hạn',
                ),
                'short_item1_dt' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Khóa 1 — Tên hạng', 'flatsome' ),
                    'default' => 'Hạng B',
                ),
                'short_item1_dd' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Khóa 1 — Thời gian', 'flatsome' ),
                    'default' => 'Các khóa 2 tháng',
                ),
                'short_item2_dt' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Khóa 2 — Tên hạng', 'flatsome' ),
                    'default' => 'Hạng C1',
                ),
                'short_item2_dd' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Khóa 2 — Thời gian', 'flatsome' ),
                    'default' => 'Các khóa 3 tháng',
                ),
            ),
        ),
        'group_notes' => array(
            'type'    => 'group',
            'heading' => __( 'Hàng ghi chú & Lưu ý', 'flatsome' ),
            'options' => array(
                'pass_text' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Đoạn xác suất đậu', 'flatsome' ),
                    'default' => 'Xác suất học viên thi đậu cao',
                ),
                'note_html' => array(
                    'type'    => 'textarea',
                    'heading' => __( 'Lưu ý lệ phí (HTML)', 'flatsome' ),
                    'default' => '<strong>Lưu ý:</strong> Phí&nbsp;sát&nbsp;hạch và lệ&nbsp;phí cấp&nbsp;bằng (<strong>645.000đ</strong>) học&nbsp;viên tự thanh&nbsp;toán thông&nbsp;qua <span class="course-info-panel__keep">mã&nbsp;QR&nbsp;cơ&nbsp;sở&nbsp;đào&nbsp;tạo</span> <span class="course-info-panel__keep">cấp&nbsp;trước&nbsp;kỳ&nbsp;sát&nbsp;hạch&nbsp;7&nbsp;ngày.</span>',
                ),
            ),
        ),
        'group_contact' => array(
            'type'    => 'group',
            'heading' => __( 'Thông tin liên hệ & Link', 'flatsome' ),
            'options' => array(
                'phone_display' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Số điện thoại hiển thị', 'flatsome' ),
                    'default' => '0911.739.119 — 028.36.362.362',
                ),
                'phone_href' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Link điện thoại (tel:)', 'flatsome' ),
                    'default' => 'tel:0911739119',
                ),
                'website_display' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Website hiển thị', 'flatsome' ),
                    'default' => 'https://hpo.edu.vn',
                ),
                'website_href' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Link Website', 'flatsome' ),
                    'default' => 'https://hpo.edu.vn',
                ),
                'email_display' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Email hiển thị', 'flatsome' ),
                    'default' => 'tuyensinh@hpo.edu.vn',
                ),
                'email_href' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Link Email (mailto:)', 'flatsome' ),
                    'default' => 'mailto:tuyensinh@hpo.edu.vn',
                ),
                'process_link_text' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Chữ link quy trình', 'flatsome' ),
                    'default' => 'Xem chi tiết quy trình đào tạo',
                ),
                'process_link_url' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'URL link quy trình', 'flatsome' ),
                    'default' => 'quy-dinh-chuong-trinh-hoc-lai-xe/',
                ),
            ),
        ),
    ),
) );
