<?php
/**
 * UX Builder Element: HPO Press Highlights Strip & Dialog
 * Tag: [hpo_press_strip]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_ux_builder_shortcode( 'hpo_press_strip', array(
    'name'     => __( 'HPO Dải Báo Chí Đưa Tin', 'flatsome-child' ),
    'category' => __( 'HPO Elements', 'flatsome-child' ),
    'priority' => 2,
    'options'  => array(
        'strip_group' => array(
            'type'    => 'group',
            'heading' => __( 'Dải chạy báo chí', 'flatsome-child' ),
            'options' => array(
                'label_text' => array(
                    'type'        => 'textfield',
                    'heading'     => __( 'Nhãn bên trái', 'flatsome-child' ),
                    'description' => __( 'Dùng dấu | để xuống dòng (ví dụ: Báo chí|đưa tin).', 'flatsome-child' ),
                    'default'     => 'Báo chí|đưa tin',
                ),
                'more_text' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Chữ nút xem tất cả', 'flatsome-child' ),
                    'default' => 'Xem tất cả',
                ),
                'region_aria_label' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nhãn trợ năng (aria-label)', 'flatsome-child' ),
                    'default' => 'Báo chí đưa tin về Hiệp Phát',
                ),
                'max_items' => array(
                    'type'        => 'slider',
                    'heading'     => __( 'Số bài tối đa trên dải chạy (0 = tất cả)', 'flatsome-child' ),
                    'default'     => 0,
                    'min'         => 0,
                    'max'         => 50,
                    'step'        => 1,
                ),
                'marquee_duration_sec' => array(
                    'type'    => 'slider',
                    'heading' => __( 'Thời lượng 1 vòng chạy (giây)', 'flatsome-child' ),
                    'default' => 300,
                    'min'     => 30,
                    'max'     => 600,
                    'step'    => 10,
                    'unit'    => 's',
                ),
                'hide_on_empty' => array(
                    'type'    => 'checkbox',
                    'heading' => __( 'Tự ẩn dải nếu chưa có bài báo nào', 'flatsome-child' ),
                    'default' => 'true',
                ),
            ),
        ),
        'dialog_group' => array(
            'type'    => 'group',
            'heading' => __( 'Hộp thoại danh sách bài báo', 'flatsome-child' ),
            'options' => array(
                'dialog_title' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề hộp thoại', 'flatsome-child' ),
                    'default' => 'Báo chí đưa tin về Hiệp Phát',
                ),
                'dialog_subtitle' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Phụ đề sau số bài', 'flatsome-child' ),
                    'default' => 'bài báo, video, phát thanh sau họp báo ngày 28/10/2026',
                ),
            ),
        ),
    ),
) );
