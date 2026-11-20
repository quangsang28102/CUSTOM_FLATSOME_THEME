<?php
/**
 * UX Builder Element: HPO Consultation Form
 * Tag: [hpo_consultation_form]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_ux_builder_shortcode( 'hpo_consultation_form', array(
    'name'     => __( 'HPO Consultation Form', 'flatsome-child' ),
    'category' => __( 'HPO Elements', 'flatsome-child' ),
    'priority' => 9,
    'options'  => array(
        'header_group' => array(
            'type'    => 'group',
            'heading' => __( 'Tiêu đề & Thời hạn', 'flatsome-child' ),
            'options' => array(
                'eyebrow_prefix' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Dòng mở đầu (trước tên xã)', 'flatsome-child' ),
                    'default' => 'Ưu đãi cho người dân',
                ),
                'title' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề chính', 'flatsome-child' ),
                    'default' => 'Đăng ký học lái xe tại Hiệp Phát',
                ),
                'lead' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Mô tả ngắn', 'flatsome-child' ),
                    'default' => 'Để lại thông tin, nhân viên tuyển sinh sẽ gọi tư vấn miễn phí',
                ),
                'deadline_prefix' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nhãn trước ngày kết thúc', 'flatsome-child' ),
                    'default' => 'Áp dụng đến hết ngày',
                ),
                'deadline_date' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Ngày kết thúc ưu đãi', 'flatsome-child' ),
                    'default' => '31/01/2027',
                ),
            ),
        ),
        'form_group' => array(
            'type'    => 'group',
            'heading' => __( 'Nhãn trường & Nút gửi', 'flatsome-child' ),
            'options' => array(
                'form_heading' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề khung form', 'flatsome-child' ),
                    'default' => 'Đăng ký tư vấn',
                ),
                'chip_text' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nhãn chip góc phải', 'flatsome-child' ),
                    'default' => 'Miễn phí tư vấn',
                ),
                'name_label' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nhãn Họ và tên', 'flatsome-child' ),
                    'default' => 'Họ và tên',
                ),
                'name_placeholder' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Placeholder Họ và tên', 'flatsome-child' ),
                    'default' => 'Nhập họ và tên',
                ),
                'phone_label' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nhãn Số điện thoại', 'flatsome-child' ),
                    'default' => 'Số điện thoại',
                ),
                'phone_placeholder' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Placeholder Số điện thoại', 'flatsome-child' ),
                    'default' => 'Ví dụ: 0911 739 119',
                ),
                'class_label' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nhãn Hạng đào tạo', 'flatsome-child' ),
                    'default' => 'Hạng đào tạo quan tâm',
                ),
                'note_text' => array(
                    'type'    => 'textarea',
                    'heading' => __( 'Ghi chú trước nút gửi', 'flatsome-child' ),
                    'default' => 'Nhân viên tuyển sinh sẽ liên hệ để tư vấn chương trình học và học phí. Không cần thanh toán.',
                ),
                'submit_text' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Chữ nút gửi', 'flatsome-child' ),
                    'default' => 'Nhận tư vấn miễn phí',
                ),
            ),
        ),
        'policy_group' => array(
            'type'    => 'group',
            'heading' => __( 'Bảo mật & Tổng đài', 'flatsome-child' ),
            'options' => array(
                'privacy_prefix' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Chữ trước link chính sách', 'flatsome-child' ),
                    'default' => 'Khi gửi, bạn đồng ý để Hiệp Phát liên hệ theo',
                ),
                'privacy_text' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Chữ link chính sách', 'flatsome-child' ),
                    'default' => 'Chính sách bảo mật',
                ),
                'privacy_url' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'URL Chính sách bảo mật', 'flatsome-child' ),
                    'default' => '/chinh-sach-bao-mat/',
                ),
                'hotline' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Số tổng đài hỗ trợ', 'flatsome-child' ),
                    'default' => '028.36.362.362',
                ),
            ),
        ),
    ),
) );
