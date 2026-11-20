<?php
/**
 * UX Builder Element: HPO Awards Showcase Slider
 * Tag: [hpo_awards]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_ux_builder_shortcode( 'hpo_awards', array(
    'name'     => __( 'HPO Awards Showcase Slider', 'flatsome' ),
    'category' => __( 'HPO Elements', 'flatsome' ),
    'priority' => 20,
    'options'  => array(
        'general_group' => array(
            'type'    => 'group',
            'heading' => __( 'Cài đặt chung', 'flatsome' ),
            'options' => array(
                'section_title' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề section', 'flatsome' ),
                    'default' => 'Dấu ấn hành trình phát triển thành tựu',
                ),
                'autoplay_ms' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Thời gian tự chuyển (ms)', 'flatsome' ),
                    'default' => '6500',
                ),
            ),
        ),
        'slide_1' => array(
            'type'    => 'group',
            'heading' => __( 'Giải thưởng 01', 'flatsome' ),
            'options' => array(
                'slide1_num' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Số thứ tự', 'flatsome' ),
                    'default' => '01',
                ),
                'slide1_choice_title' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề tab', 'flatsome' ),
                    'default' => 'Top 10',
                ),
                'slide1_choice_sub' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Phụ đề tab', 'flatsome' ),
                    'default' => 'Global Excellent Brands 2026',
                ),
                'slide1_event_subtitle' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Địa điểm & sự kiện', 'flatsome' ),
                    'default' => 'Sydney Australia, 28/06/2026 - Diễn đàn doanh nghiệp Việt Nam - Australia',
                ),
                'slide1_topline_badge' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nhãn trên poster', 'flatsome' ),
                    'default' => 'Sydney · Australia · 28/06/2026',
                ),
                'slide1_poster_image' => array(
                    'type'    => 'image',
                    'heading' => __( 'Ảnh poster', 'flatsome' ),
                    'default' => '',
                ),
                'slide1_poster_alt' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Mô tả ảnh (Alt)', 'flatsome' ),
                    'default' => 'Top 10 Global Excellent Brands 2026 của Hiệp Phát',
                ),
            ),
        ),
        'slide_2' => array(
            'type'    => 'group',
            'heading' => __( 'Giải thưởng 02', 'flatsome' ),
            'options' => array(
                'slide2_num' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Số thứ tự', 'flatsome' ),
                    'default' => '02',
                ),
                'slide2_choice_title' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề tab', 'flatsome' ),
                    'default' => 'Top 5',
                ),
                'slide2_choice_sub' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Phụ đề tab', 'flatsome' ),
                    'default' => 'ASEAN Strong Brand 2026',
                ),
                'slide2_event_subtitle' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Địa điểm & sự kiện', 'flatsome' ),
                    'default' => 'Singapore, 18/04/2026 - Diễn đàn hợp tác kinh tế Việt Nam - Asean',
                ),
                'slide2_topline_badge' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nhãn trên poster', 'flatsome' ),
                    'default' => 'Singapore · 18/04/2026',
                ),
                'slide2_poster_image' => array(
                    'type'    => 'image',
                    'heading' => __( 'Ảnh poster', 'flatsome' ),
                    'default' => '',
                ),
                'slide2_poster_alt' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Mô tả ảnh (Alt)', 'flatsome' ),
                    'default' => 'Top 5 ASEAN Strong Brand 2026 của Hiệp Phát',
                ),
            ),
        ),
        'slide_3' => array(
            'type'    => 'group',
            'heading' => __( 'Giải thưởng 03', 'flatsome' ),
            'options' => array(
                'slide3_num' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Số thứ tự', 'flatsome' ),
                    'default' => '03',
                ),
                'slide3_choice_title' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề tab', 'flatsome' ),
                    'default' => 'Hàng Việt Tốt',
                ),
                'slide3_choice_sub' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Phụ đề tab', 'flatsome' ),
                    'default' => 'Thương hiệu Việt 2025',
                ),
                'slide3_event_subtitle' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Địa điểm & sự kiện', 'flatsome' ),
                    'default' => 'Việt Nam, 13/09/2025 - Thương hiệu Hàng Việt tốt 2025',
                ),
                'slide3_topline_badge' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nhãn trên poster', 'flatsome' ),
                    'default' => 'Việt Nam · 13/09/2025',
                ),
                'slide3_poster_image' => array(
                    'type'    => 'image',
                    'heading' => __( 'Ảnh poster', 'flatsome' ),
                    'default' => '',
                ),
                'slide3_poster_alt' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Mô tả ảnh (Alt)', 'flatsome' ),
                    'default' => 'Poster Thương hiệu Hàng Việt Tốt 2025 của Hiệp Phát',
                ),
            ),
        ),
    ),
) );
