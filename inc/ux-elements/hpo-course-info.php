<?php
/**
 * UX Builder Element: HPO Course Info Panel
 * Tag: [hpo_course_info]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_ux_builder_shortcode( 'hpo_course_info', array(
    'name'     => __( 'HPO Course Info Panel', 'flatsome-child' ),
    'category' => __( 'HPO Elements', 'flatsome-child' ),
    'priority' => 8,
    'options'  => array(
        'duration_group' => array(
            'type'    => 'group',
            'heading' => __( 'Cột 1: Khóa học linh động', 'flatsome-child' ),
            'options' => array(
                'badge_text' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nhãn nổi bật', 'flatsome-child' ),
                    'default' => 'KHÓA HỌC LINH ĐỘNG',
                ),
                'left_item_1' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Mục 1', 'flatsome-child' ),
                    'default' => 'Chủ động theo thời gian của học viên',
                ),
                'left_item_2' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Mục 2', 'flatsome-child' ),
                    'default' => 'Thuận tiện để học mọi lúc, mọi nơi',
                ),
            ),
        ),
        'exam_group' => array(
            'type'    => 'group',
            'heading' => __( 'Cột 2: Kiểm tra & Ôn tập', 'flatsome-child' ),
            'options' => array(
                'right_item_1_label' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Mục 1 — Nội dung', 'flatsome-child' ),
                    'default' => 'Kiểm tra hoàn thành khóa đào tạo với xe thiết bị có chấm điểm trên sân sát hạch:',
                ),
                'right_item_1_value' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Mục 1 — Giá trị nhấn mạnh', 'flatsome-child' ),
                    'default' => '20 phút',
                ),
                'right_item_2_label' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Mục 2 — Nội dung', 'flatsome-child' ),
                    'default' => 'Ôn tập xe thiết bị:',
                ),
                'right_item_2_value' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Mục 2 — Giá trị nhấn mạnh', 'flatsome-child' ),
                    'default' => '2 giờ',
                ),
                'right_item_3_label' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Mục 3 — Nội dung', 'flatsome-child' ),
                    'default' => 'Ôn tập lý thuyết:',
                ),
                'right_item_3_value' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Mục 3 — Giá trị nhấn mạnh', 'flatsome-child' ),
                    'default' => 'Phòng lý thuyết',
                ),
            ),
        ),
        'contact_group' => array(
            'type'    => 'group',
            'heading' => __( 'Liên hệ & Quy trình', 'flatsome-child' ),
            'options' => array(
                'phone_display' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Số điện thoại hiển thị', 'flatsome-child' ),
                    'default' => '0911.739.119 — 028.36.362.362',
                ),
                'phone_href' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Link điện thoại (tel:...)', 'flatsome-child' ),
                    'default' => 'tel:0911739119',
                ),
                'website_display' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Website hiển thị', 'flatsome-child' ),
                    'default' => 'https://hpo.edu.vn',
                ),
                'website_href' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Link Website', 'flatsome-child' ),
                    'default' => 'https://hpo.edu.vn',
                ),
                'email_display' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Email hiển thị', 'flatsome-child' ),
                    'default' => 'tuyensinh@hpo.edu.vn',
                ),
                'email_href' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Link Email (mailto:...)', 'flatsome-child' ),
                    'default' => 'mailto:tuyensinh@hpo.edu.vn',
                ),
                'process_link_text' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Chữ link quy trình đào tạo', 'flatsome-child' ),
                    'default' => 'Xem chi tiết quy trình đào tạo',
                ),
                'process_link_url' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'URL quy trình đào tạo', 'flatsome-child' ),
                    'default' => '/quy-dinh-chuong-trinh-hoc-lai-xe/',
                ),
            ),
        ),
    ),
) );
