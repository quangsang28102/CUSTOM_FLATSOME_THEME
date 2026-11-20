<?php
/**
 * UX Builder Element: HPO Hero Slider
 * Tag: [hpo_hero]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_ux_builder_shortcode( 'hpo_hero', array(
    'name'      => __( 'HPO Hero Slider', 'flatsome' ),
    'category'  => __( 'HPO Elements', 'flatsome' ),
    'priority'  => 1,
    'options'   => array(
        'slide1_group' => array(
            'type'  => 'group',
            'heading' => __( 'Slide 1: Kỷ nguyên AI', 'flatsome' ),
            'options' => array(
                'welcome_text' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Dòng chào mừng (Eyebrow)', 'flatsome' ),
                    'default' => 'Chào mừng các bạn đến với Hiệp Phát',
                ),
                'title_line_1' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề dòng 1 (Xanh Gradient)', 'flatsome' ),
                    'default' => 'KỶ NGUYÊN AI',
                ),
                'title_line_2' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề dòng 2 (Đỏ Gradient)', 'flatsome' ),
                    'default' => 'TRONG ĐÀO TẠO LÁI XE',
                ),
                'description' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Phụ đề nổi bật', 'flatsome' ),
                    'default' => 'Hệ sinh thái chuyển đổi số toàn diện cho đào tạo lái xe ô tô thông minh',
                ),
                'detail_text' => array(
                    'type'    => 'textarea',
                    'heading' => __( 'Mô tả chi tiết', 'flatsome' ),
                    'default' => 'Tại Hiệp Phát, chúng tôi đào tạo lái xe ô tô trên nền tảng tích hợp trí tuệ nhân tạo, với Hạng B (Bao gồm số cơ khí (số sàn) và số tự động (xe ô tô điện,...)) và Hạng C1.',
                ),
                'ring_image' => array(
                    'type'    => 'image',
                    'heading' => __( 'Ảnh vòng tròn hệ thống HPO', 'flatsome' ),
                    'default' => '',
                ),
            ),
        ),
        'slide2_group' => array(
            'type'  => 'group',
            'heading' => __( 'Slide 2: Banner Công ty', 'flatsome' ),
            'options' => array(
                'banner_heading' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề banner', 'flatsome' ),
                    'default' => 'GIỚI THIỆU CÔNG TY',
                ),
                'banner_motto' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Khẩu hiệu (Motto)', 'flatsome' ),
                    'default' => 'Đào tạo và sát hạch cùng một địa điểm',
                ),
                'banner_image' => array(
                    'type'    => 'image',
                    'heading' => __( 'Ảnh ghép cơ sở đào tạo', 'flatsome' ),
                    'default' => '',
                ),
                'website_url' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Địa chỉ Website', 'flatsome' ),
                    'default' => 'https://hpo.edu.vn/',
                ),
            ),
        ),
    ),
) );
