<?php
/**
 * UX Builder Element: HPO Intro Video Section
 * Tag: [hpo_intro_video]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_ux_builder_shortcode( 'hpo_intro_video', array(
    'name'     => __( 'HPO Intro Video', 'flatsome' ),
    'category' => __( 'HPO Elements', 'flatsome' ),
    'priority' => 23,
    'options'  => array(
        'video_group' => array(
            'type'    => 'group',
            'heading' => __( 'Nội dung & Video YouTube', 'flatsome' ),
            'options' => array(
                'title_line_1' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề dòng 1 (Xanh)', 'flatsome' ),
                    'default' => 'Trung tâm giáo dục Nghề nghiệp',
                ),
                'title_line_2' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề dòng 2 (Đỏ)', 'flatsome' ),
                    'default' => 'và sát hạch lái xe ô tô Hiệp Phát',
                ),
                'youtube_id' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'YouTube Video ID hoặc URL', 'flatsome' ),
                    'default' => 'P5yDyQ1_NqA',
                ),
                'video_title' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề iframe (Accessibility)', 'flatsome' ),
                    'default' => 'Giới thiệu trung tâm giáo dục nghề nghiệp Hiệp Phát',
                ),
                'autoplay' => array(
                    'type'    => 'select',
                    'heading' => __( 'Tự động phát (Autoplay)', 'flatsome' ),
                    'default' => 'true',
                    'options' => array(
                        'true'  => __( 'Bật', 'flatsome' ),
                        'false' => __( 'Tắt', 'flatsome' ),
                    ),
                ),
                'mute' => array(
                    'type'    => 'select',
                    'heading' => __( 'Tắt tiếng mặc định (Mute)', 'flatsome' ),
                    'default' => 'true',
                    'options' => array(
                        'true'  => __( 'Bật', 'flatsome' ),
                        'false' => __( 'Tắt', 'flatsome' ),
                    ),
                ),
                'loop' => array(
                    'type'    => 'select',
                    'heading' => __( 'Phát lặp lại (Loop)', 'flatsome' ),
                    'default' => 'true',
                    'options' => array(
                        'true'  => __( 'Bật', 'flatsome' ),
                        'false' => __( 'Tắt', 'flatsome' ),
                    ),
                ),
            ),
        ),
    ),
) );
