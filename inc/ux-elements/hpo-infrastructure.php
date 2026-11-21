<?php
/**
 * UX Builder Element: HPO Technical Infrastructure Stage
 * Tag: [hpo_infrastructure]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_ux_builder_shortcode( 'hpo_infrastructure', array(
    'name'     => __( 'HPO Technical Infrastructure', 'flatsome' ),
    'category' => __( 'HPO Elements', 'flatsome' ),
    'priority' => 22,
    'options'  => array(
        'heading_stage_group' => array(
            'type'    => 'group',
            'heading' => __( 'Tiêu đề & Sân khấu hạ tầng', 'flatsome' ),
            'options' => array(
                'title_line_1' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề dòng 1 (Xanh)', 'flatsome' ),
                    'default' => 'Hệ thống hạ tầng kỹ thuật',
                ),
                'title_line_2' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề dòng 2 (Đỏ)', 'flatsome' ),
                    'default' => 'hiện đại, đồng bộ, thông suốt, bảo mật',
                ),
                'stage_badge_prefix' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nhãn badge — Tiền tố', 'flatsome' ),
                    'default' => 'Lưu trữ tại',
                ),
                'stage_badge_brand' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nhãn badge — Thương hiệu', 'flatsome' ),
                    'default' => 'Viettel IDC',
                ),
                'stage_image' => array(
                    'type'    => 'image',
                    'heading' => __( 'Ảnh hạ tầng máy chủ', 'flatsome' ),
                    'default' => '',
                ),
                'stage_image_alt' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Alt ảnh hạ tầng', 'flatsome' ),
                    'default' => 'Hạ tầng máy chủ đám mây Viettel IDC của hệ thống HPO',
                ),
            ),
        ),
        'pillar_1' => array(
            'type'    => 'group',
            'heading' => __( 'Trụ cột 01', 'flatsome' ),
            'options' => array(
                'pillar1_num'   => array( 'type' => 'textfield', 'heading' => __( 'Số thứ tự', 'flatsome' ), 'default' => '01' ),
                'pillar1_title' => array( 'type' => 'textfield', 'heading' => __( 'Tiêu đề', 'flatsome' ), 'default' => 'Hiện đại' ),
                'pillar1_desc'  => array( 'type' => 'textarea',  'heading' => __( 'Mô tả', 'flatsome' ), 'default' => 'Máy chủ đặt tại trung tâm dữ liệu Viettel IDC.' ),
            ),
        ),
        'pillar_2' => array(
            'type'    => 'group',
            'heading' => __( 'Trụ cột 02', 'flatsome' ),
            'options' => array(
                'pillar2_num'   => array( 'type' => 'textfield', 'heading' => __( 'Số thứ tự', 'flatsome' ), 'default' => '02' ),
                'pillar2_title' => array( 'type' => 'textfield', 'heading' => __( 'Tiêu đề', 'flatsome' ), 'default' => 'Đồng bộ' ),
                'pillar2_desc'  => array( 'type' => 'textarea',  'heading' => __( 'Mô tả', 'flatsome' ), 'default' => 'Xác thực khuôn mặt, DAT, cabin, mô phỏng chung một hệ thống HPO.' ),
            ),
        ),
        'pillar_3' => array(
            'type'    => 'group',
            'heading' => __( 'Trụ cột 03', 'flatsome' ),
            'options' => array(
                'pillar3_num'   => array( 'type' => 'textfield', 'heading' => __( 'Số thứ tự', 'flatsome' ), 'default' => '03' ),
                'pillar3_title' => array( 'type' => 'textfield', 'heading' => __( 'Tiêu đề', 'flatsome' ), 'default' => 'Thông suốt' ),
                'pillar3_desc'  => array( 'type' => 'textarea',  'heading' => __( 'Mô tả', 'flatsome' ), 'default' => 'Truy cập mọi lúc trên máy tính, điện thoại, máy tính bảng.' ),
            ),
        ),
        'pillar_4' => array(
            'type'    => 'group',
            'heading' => __( 'Trụ cột 04', 'flatsome' ),
            'options' => array(
                'pillar4_num'   => array( 'type' => 'textfield', 'heading' => __( 'Số thứ tự', 'flatsome' ), 'default' => '04' ),
                'pillar4_title' => array( 'type' => 'textfield', 'heading' => __( 'Tiêu đề', 'flatsome' ), 'default' => 'Bảo mật' ),
                'pillar4_desc'  => array( 'type' => 'textarea',  'heading' => __( 'Mô tả', 'flatsome' ), 'default' => 'Bảo mật thông tin học viên theo tiêu chuẩn an toàn dữ liệu.' ),
            ),
        ),
    ),
) );
