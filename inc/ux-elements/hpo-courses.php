<?php
/**
 * UX Builder Element: HPO Courses Showcase
 * Tag: [hpo_courses]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$hpo_course_photo_choices = array(
    'hang-b-vios'      => __( 'Xe Hạng B (Toyota Vios 3D)', 'flatsome-child' ),
    'hang-c1-kia-k200' => __( 'Xe Hạng C1 (Kia K200 3D)', 'flatsome-child' ),
    'custom'           => __( 'Ảnh tùy chỉnh', 'flatsome-child' ),
);

$hpo_badge_variants = array(
    ''   => __( 'Mặc định (B)', 'flatsome-child' ),
    'c1' => __( 'Thu gọn chữ (C1)', 'flatsome-child' ),
);

add_ux_builder_shortcode( 'hpo_courses', array(
    'name'     => __( 'HPO Courses Showcase', 'flatsome-child' ),
    'category' => __( 'HPO Elements', 'flatsome-child' ),
    'priority' => 7,
    'options'  => array(
        'general_group' => array(
            'type'    => 'group',
            'heading' => __( 'Tiêu đề & Bối cảnh', 'flatsome-child' ),
            'options' => array(
                'section_id' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Section ID (Anchor)', 'flatsome-child' ),
                    'default' => 'khoa-hoc',
                ),
                'title' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề chính', 'flatsome-child' ),
                    'default' => 'KHÓA HỌC CỦA CHÚNG TÔI',
                ),
                'subtitle_1' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Phụ đề phần 1', 'flatsome-child' ),
                    'default' => 'ĐÀO TẠO LÁI XE Ô TÔ THÔNG MINH',
                ),
                'subtitle_2' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Phụ đề phần 2', 'flatsome-child' ),
                    'default' => 'CHI PHÍ THẤP',
                ),
                'subtitle_3' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Phụ đề phần 3', 'flatsome-child' ),
                    'default' => 'CHẤT LƯỢNG HÀNG ĐẦU',
                ),
            ),
        ),
        'promo_group' => array(
            'type'    => 'group',
            'heading' => __( 'Hộp quà ưu đãi & Thời hạn', 'flatsome-child' ),
            'options' => array(
                'promo_gift_image' => array(
                    'type'    => 'image',
                    'heading' => __( 'Ảnh hộp quà (mặc định SVG)', 'flatsome-child' ),
                    'default' => '',
                ),
                'promo_gift_alt' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Alt ảnh hộp quà', 'flatsome-child' ),
                    'default' => 'Hộp quà ưu đãi học phí',
                ),
                'promo_ribbon' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Ruy băng nổi bật', 'flatsome-child' ),
                    'default' => 'HỌC PHÍ TRỌN GÓI',
                ),
                'promo_note' => array(
                    'type'    => 'textarea',
                    'heading' => __( 'Ghi chú dưới ruy băng', 'flatsome-child' ),
                    'default' => "Minh bạch · Hiệu quả\nChất lượng cao",
                ),
                'deadline_label' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nhãn thời gian áp dụng', 'flatsome-child' ),
                    'default' => 'Thời gian áp dụng:',
                ),
                'deadline_prefix' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Nội dung trước ngày hết hạn', 'flatsome-child' ),
                    'default' => 'Chương trình ưu đãi học phí đăng ký đến hết ngày',
                ),
                'deadline_date' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Ngày hết hạn', 'flatsome-child' ),
                    'default' => '31/01/2027',
                ),
                'deadline_suffix' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Ký tự sau ngày hết hạn', 'flatsome-child' ),
                    'default' => '.',
                ),
            ),
        ),
        'course_1_group' => array(
            'type'    => 'group',
            'heading' => __( 'Khóa học 1', 'flatsome-child' ),
            'options' => array(
                'c1_slug'           => array( 'type' => 'textfield', 'heading' => __( 'Slug data-course', 'flatsome-child' ), 'default' => 'hang-b-so-tu-dong' ),
                'c1_price_id'       => array( 'type' => 'textfield', 'heading' => __( 'ID bảng giá', 'flatsome-child' ), 'default' => 'gia-hang-b-tu-dong' ),
                'c1_badge'          => array( 'type' => 'textfield', 'heading' => __( 'Ký hiệu huy hiệu', 'flatsome-child' ), 'default' => 'B' ),
                'c1_badge_variant'  => array( 'type' => 'select', 'heading' => __( 'Kiểu huy hiệu', 'flatsome-child' ), 'default' => '', 'options' => $hpo_badge_variants ),
                'c1_class'          => array( 'type' => 'textfield', 'heading' => __( 'Tên hạng', 'flatsome-child' ), 'default' => 'Hạng B' ),
                'c1_type'           => array( 'type' => 'textfield', 'heading' => __( 'Loại xe / truyền động', 'flatsome-child' ), 'default' => 'Số tự động' ),
                'c1_photo_preset'   => array( 'type' => 'select', 'heading' => __( 'Sân khấu xe 3D', 'flatsome-child' ), 'default' => 'hang-b-vios', 'options' => $hpo_course_photo_choices ),
                'c1_custom_image'   => array( 'type' => 'image', 'heading' => __( 'Ảnh xe tùy chỉnh (khi chọn Ảnh tùy chỉnh)', 'flatsome-child' ), 'default' => '' ),
                'c1_tuition_label'  => array( 'type' => 'textfield', 'heading' => __( 'Nhãn học phí', 'flatsome-child' ), 'default' => 'Học phí' ),
                'c1_tuition_value'  => array( 'type' => 'textfield', 'heading' => __( 'Giá học phí', 'flatsome-child' ), 'default' => '16.000.000đ' ),
                'c1_duration_label' => array( 'type' => 'textfield', 'heading' => __( 'Nhãn thời gian học', 'flatsome-child' ), 'default' => 'Thời gian học' ),
                'c1_duration_value' => array( 'type' => 'textfield', 'heading' => __( 'Thời gian học', 'flatsome-child' ), 'default' => '2 tháng' ),
            ),
        ),
        'course_2_group' => array(
            'type'    => 'group',
            'heading' => __( 'Khóa học 2', 'flatsome-child' ),
            'options' => array(
                'c2_slug'           => array( 'type' => 'textfield', 'heading' => __( 'Slug data-course', 'flatsome-child' ), 'default' => 'hang-b-so-co-khi' ),
                'c2_price_id'       => array( 'type' => 'textfield', 'heading' => __( 'ID bảng giá', 'flatsome-child' ), 'default' => 'gia-hang-b-co-khi' ),
                'c2_badge'          => array( 'type' => 'textfield', 'heading' => __( 'Ký hiệu huy hiệu', 'flatsome-child' ), 'default' => 'B' ),
                'c2_badge_variant'  => array( 'type' => 'select', 'heading' => __( 'Kiểu huy hiệu', 'flatsome-child' ), 'default' => '', 'options' => $hpo_badge_variants ),
                'c2_class'          => array( 'type' => 'textfield', 'heading' => __( 'Tên hạng', 'flatsome-child' ), 'default' => 'Hạng B' ),
                'c2_type'           => array( 'type' => 'textfield', 'heading' => __( 'Loại xe / truyền động', 'flatsome-child' ), 'default' => 'Số cơ khí' ),
                'c2_photo_preset'   => array( 'type' => 'select', 'heading' => __( 'Sân khấu xe 3D', 'flatsome-child' ), 'default' => 'hang-b-vios', 'options' => $hpo_course_photo_choices ),
                'c2_custom_image'   => array( 'type' => 'image', 'heading' => __( 'Ảnh xe tùy chỉnh (khi chọn Ảnh tùy chỉnh)', 'flatsome-child' ), 'default' => '' ),
                'c2_tuition_label'  => array( 'type' => 'textfield', 'heading' => __( 'Nhãn học phí', 'flatsome-child' ), 'default' => 'Học phí' ),
                'c2_tuition_value'  => array( 'type' => 'textfield', 'heading' => __( 'Giá học phí', 'flatsome-child' ), 'default' => '16.000.000đ' ),
                'c2_duration_label' => array( 'type' => 'textfield', 'heading' => __( 'Nhãn thời gian học', 'flatsome-child' ), 'default' => 'Thời gian học' ),
                'c2_duration_value' => array( 'type' => 'textfield', 'heading' => __( 'Thời gian học', 'flatsome-child' ), 'default' => '2 tháng' ),
            ),
        ),
        'course_3_group' => array(
            'type'    => 'group',
            'heading' => __( 'Khóa học 3', 'flatsome-child' ),
            'options' => array(
                'c3_slug'           => array( 'type' => 'textfield', 'heading' => __( 'Slug data-course', 'flatsome-child' ), 'default' => 'hang-c1' ),
                'c3_price_id'       => array( 'type' => 'textfield', 'heading' => __( 'ID bảng giá', 'flatsome-child' ), 'default' => 'gia-hang-c1' ),
                'c3_badge'          => array( 'type' => 'textfield', 'heading' => __( 'Ký hiệu huy hiệu', 'flatsome-child' ), 'default' => 'C1' ),
                'c3_badge_variant'  => array( 'type' => 'select', 'heading' => __( 'Kiểu huy hiệu', 'flatsome-child' ), 'default' => 'c1', 'options' => $hpo_badge_variants ),
                'c3_class'          => array( 'type' => 'textfield', 'heading' => __( 'Tên hạng', 'flatsome-child' ), 'default' => 'Hạng C1' ),
                'c3_type'           => array( 'type' => 'textfield', 'heading' => __( 'Loại xe / truyền động', 'flatsome-child' ), 'default' => 'Xe tải' ),
                'c3_photo_preset'   => array( 'type' => 'select', 'heading' => __( 'Sân khấu xe 3D', 'flatsome-child' ), 'default' => 'hang-c1-kia-k200', 'options' => $hpo_course_photo_choices ),
                'c3_custom_image'   => array( 'type' => 'image', 'heading' => __( 'Ảnh xe tùy chỉnh (khi chọn Ảnh tùy chỉnh)', 'flatsome-child' ), 'default' => '' ),
                'c3_tuition_label'  => array( 'type' => 'textfield', 'heading' => __( 'Nhãn học phí', 'flatsome-child' ), 'default' => 'Học phí' ),
                'c3_tuition_value'  => array( 'type' => 'textfield', 'heading' => __( 'Giá học phí', 'flatsome-child' ), 'default' => '18.000.000đ' ),
                'c3_duration_label' => array( 'type' => 'textfield', 'heading' => __( 'Nhãn thời gian học', 'flatsome-child' ), 'default' => 'Thời gian học' ),
                'c3_duration_value' => array( 'type' => 'textfield', 'heading' => __( 'Thời gian học', 'flatsome-child' ), 'default' => '3 tháng' ),
            ),
        ),
    ),
) );
