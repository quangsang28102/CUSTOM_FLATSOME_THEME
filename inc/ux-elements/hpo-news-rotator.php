<?php
/**
 * UX Builder Element: HPO Press News Rotator
 * Tag: [hpo_news_rotator]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_ux_builder_shortcode( 'hpo_news_rotator', array(
    'name'     => __( 'HPO Khối Bài Báo Nổi Bật', 'flatsome-child' ),
    'category' => __( 'HPO Elements', 'flatsome-child' ),
    'priority' => 4,
    'options'  => array(
        'content_group' => array(
            'type'    => 'group',
            'heading' => __( 'Nội dung giới thiệu', 'flatsome-child' ),
            'options' => array(
                'eyebrow' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nhãn trên tiêu đề (Eyebrow)', 'flatsome-child' ),
                    'default' => 'Hiệp Phát',
                ),
                'title_line_1' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề dòng 1', 'flatsome-child' ),
                    'default' => 'Bài báo về',
                ),
                'title_line_2' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề dòng 2', 'flatsome-child' ),
                    'default' => 'Hiệp Phát',
                ),
                'subtitle' => array(
                    'type'    => 'textarea',
                    'heading' => __( 'Mô tả ngắn', 'flatsome-child' ),
                    'default' => 'Bài viết, phóng sự trên báo điện tử, truyền hình và phát thanh về mô hình học lái xe tích hợp AI của Hiệp Phát.',
                ),
                'all_button_text' => array(
                    'type'        => 'textfield',
                    'heading'     => __( 'Chữ nút xem tất cả', 'flatsome-child' ),
                    'description' => __( 'Dùng {count} để tự động chèn tổng số bài báo.', 'flatsome-child' ),
                    'default'     => 'Xem tất cả {count} bài',
                ),
            ),
        ),
        'settings_group' => array(
            'type'    => 'group',
            'heading' => __( 'Cấu hình trình chiếu & Bộ lọc', 'flatsome-child' ),
            'options' => array(
                'interval_ms' => array(
                    'type'        => 'textfield',
                    'heading'     => __( 'Thời gian tự chuyển bài (ms)', 'flatsome-child' ),
                    'description' => __( 'Mặc định 6500 (từ 1500 đến 60000 ms).', 'flatsome-child' ),
                    'default'     => '6500',
                ),
                'small_count' => array(
                    'type'        => 'textfield',
                    'heading'     => __( 'Số thẻ nhỏ cột phải', 'flatsome-child' ),
                    'description' => __( 'Mặc định 3 (khối tự ẩn nếu có ít hơn số thẻ nhỏ + 1 bài có ảnh).', 'flatsome-child' ),
                    'default'     => '3',
                ),
                'category_filter' => array(
                    'type'    => 'select',
                    'heading' => __( 'Lọc theo kênh báo chí', 'flatsome-child' ),
                    'default' => '',
                    'options' => array(
                        ''            => __( 'Tất cả kênh', 'flatsome-child' ),
                        'bao-dien-tu' => __( 'Báo điện tử', 'flatsome-child' ),
                        'truyen-hinh' => __( 'Truyền hình', 'flatsome-child' ),
                        'phat-thanh'  => __( 'Phát thanh', 'flatsome-child' ),
                        'mang-xa-hoi' => __( 'Mạng xã hội', 'flatsome-child' ),
                    ),
                ),
            ),
        ),
    ),
) );
