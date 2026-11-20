<?php
/**
 * UX Builder Element: HPO Curriculum (6 Subjects)
 * Tag: [hpo_curriculum]
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_ux_builder_shortcode( 'hpo_curriculum', array(
	'name'     => __( 'HPO Curriculum (6 Subjects)', 'flatsome-child' ),
	'category' => __( 'HPO Elements', 'flatsome-child' ),
	'priority' => 25,
	'options'  => array(
		'header_group'         => array(
			'type'    => 'group',
			'heading' => __( 'Tiêu đề chương trình', 'flatsome-child' ),
			'options' => array(
				'section_id'   => array(
					'type'    => 'textfield',
					'heading' => __( 'Section ID (Anchor)', 'flatsome-child' ),
					'default' => 'chuong-trinh-mon-hoc',
				),
				'eyebrow'      => array(
					'type'    => 'textfield',
					'heading' => __( 'Eyebrow', 'flatsome-child' ),
					'default' => 'Chương trình đào tạo',
				),
				'title_prefix' => array(
					'type'    => 'textfield',
					'heading' => __( 'Tiêu đề (phần thường)', 'flatsome-child' ),
					'default' => 'Chương trình đào tạo lái xe ô tô',
				),
				'title_accent' => array(
					'type'    => 'textfield',
					'heading' => __( 'Tiêu đề (từ nhấn)', 'flatsome-child' ),
					'default' => 'thông minh',
				),
			),
		),
		'subjects_group'       => array(
			'type'    => 'group',
			'heading' => __( 'Thông tin 6 môn học', 'flatsome-child' ),
			'options' => array(
				'm1_title'  => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 01 — Tên môn', 'flatsome-child' ),
					'default' => 'Pháp luật về giao thông đường bộ',
				),
				'm1_meta_1' => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 01 — Nhãn meta 1', 'flatsome-child' ),
					'default' => '3 phần',
				),
				'm1_meta_2' => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 01 — Nhãn meta 2', 'flatsome-child' ),
					'default' => '15 chương',
				),
				'm1_sub'    => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 01 — Ghi chú phụ', 'flatsome-child' ),
					'default' => 'Danh mục chương chính',
				),
				'm2_title'  => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 02 — Tên môn', 'flatsome-child' ),
					'default' => 'Cấu tạo và sửa chữa thông thường',
				),
				'm2_meta'   => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 02 — Nhãn meta', 'flatsome-child' ),
					'default' => '8 chương',
				),
				'm2_sub'    => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 02 — Ghi chú phụ', 'flatsome-child' ),
					'default' => 'Danh mục nội dung chính',
				),
				'm3_title'  => array(
					'type'    => 'textarea',
					'heading' => __( 'Môn 03 — Tên môn', 'flatsome-child' ),
					'default' => 'Đạo đức người lái xe, văn hóa giao thông, phòng chống tác hại của rượu bia; kỹ năng phòng cháy chữa cháy và cứu nạn cứu hộ',
				),
				'm3_meta'   => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 03 — Nhãn meta', 'flatsome-child' ),
					'default' => '6 chương',
				),
				'm3_sub'    => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 03 — Ghi chú phụ', 'flatsome-child' ),
					'default' => 'Danh mục nội dung chính',
				),
				'm4_title'  => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 04 — Tên môn', 'flatsome-child' ),
					'default' => 'Kỹ thuật lái xe',
				),
				'm4_meta'   => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 04 — Nhãn meta', 'flatsome-child' ),
					'default' => '9 chương',
				),
				'm4_sub'    => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 04 — Ghi chú phụ', 'flatsome-child' ),
					'default' => 'Danh mục nội dung chính',
				),
				'm5_title'  => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 05 — Tên môn', 'flatsome-child' ),
					'default' => 'Phần mềm mô phỏng tình huống giao thông',
				),
				'm5_meta'   => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 05 — Nhãn meta', 'flatsome-child' ),
					'default' => '120 tình huống',
				),
				'm5_sub'    => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 05 — Ghi chú phụ', 'flatsome-child' ),
					'default' => 'Cục Đường bộ Việt Nam · 120 tình huống thực tế',
				),
				'm6_title'  => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 06 — Tên môn', 'flatsome-child' ),
					'default' => 'Thực hành lái xe',
				),
				'm6_meta'   => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 06 — Nhãn meta', 'flatsome-child' ),
					'default' => '4 chương',
				),
				'm6_sub'    => array(
					'type'    => 'textfield',
					'heading' => __( 'Môn 06 — Ghi chú phụ', 'flatsome-child' ),
					'default' => 'Danh mục nội dung chính',
				),
			),
		),
		'bienbao_images_group' => array(
			'type'    => 'group',
			'heading' => __( 'Ảnh 5 nhóm biển báo', 'flatsome-child' ),
			'options' => array(
				'bb1_image' => array(
					'type'    => 'image',
					'heading' => __( '1. Biển báo cấm', 'flatsome-child' ),
				),
				'bb2_image' => array(
					'type'    => 'image',
					'heading' => __( '2. Biển nguy hiểm', 'flatsome-child' ),
				),
				'bb3_image' => array(
					'type'    => 'image',
					'heading' => __( '3. Biển hiệu lệnh', 'flatsome-child' ),
				),
				'bb4_image' => array(
					'type'    => 'image',
					'heading' => __( '4. Biển chỉ dẫn', 'flatsome-child' ),
				),
				'bb5_image' => array(
					'type'    => 'image',
					'heading' => __( '5. Biển phụ', 'flatsome-child' ),
				),
			),
		),
		'video_lessons_group'  => array(
			'type'    => 'group',
			'heading' => __( 'Video bài giảng (Môn 02 & Môn 04)', 'flatsome-child' ),
			'options' => array(
				'v1_url'   => array(
					'type'    => 'textfield',
					'heading' => __( 'Video 1 URL (Động cơ)', 'flatsome-child' ),
					'default' => 'https://youtu.be/G9eeLeNSYB4',
				),
				'v1_title' => array(
					'type'    => 'textfield',
					'heading' => __( 'Video 1 Tiêu đề', 'flatsome-child' ),
					'default' => 'Hư hỏng thường gặp ở động cơ',
				),
				'v2_url'   => array(
					'type'    => 'textfield',
					'heading' => __( 'Video 2 URL (Hộp số)', 'flatsome-child' ),
					'default' => 'https://youtu.be/E2rwBpPNPiQ',
				),
				'v2_title' => array(
					'type'    => 'textfield',
					'heading' => __( 'Video 2 Tiêu đề', 'flatsome-child' ),
					'default' => 'Hư hỏng thường gặp ở hộp số',
				),
				'v3_url'   => array(
					'type'    => 'textfield',
					'heading' => __( 'Video 3 URL (Điều hòa & Điện)', 'flatsome-child' ),
					'default' => 'https://youtu.be/F4Fz56U2Fjc',
				),
				'v3_title' => array(
					'type'    => 'textfield',
					'heading' => __( 'Video 3 Tiêu đề', 'flatsome-child' ),
					'default' => 'Hư hỏng thường gặp ở điều hòa và hệ thống điện',
				),
				'v4_url'   => array(
					'type'    => 'textfield',
					'heading' => __( 'Video 4 URL (Hệ thống lái & Treo)', 'flatsome-child' ),
					'default' => 'https://youtu.be/3q1WpUh1AsE',
				),
				'v4_title' => array(
					'type'    => 'textfield',
					'heading' => __( 'Video 4 Tiêu đề', 'flatsome-child' ),
					'default' => 'Hư hỏng thường gặp ở hệ thống lái và treo',
				),
				'v5_url'   => array(
					'type'    => 'textfield',
					'heading' => __( 'Video 5 URL (Bài giảng 360°)', 'flatsome-child' ),
					'default' => 'https://youtu.be/8DGmYr3N-DI',
				),
				'v5_title' => array(
					'type'    => 'textfield',
					'heading' => __( 'Video 5 Tiêu đề', 'flatsome-child' ),
					'default' => 'Bài giảng 360° tham quan các bộ phận của xe ô tô',
				),
			),
		),
	),
) );
