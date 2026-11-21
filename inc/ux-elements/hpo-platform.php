<?php
/**
 * UX Builder Element: HPO Digital Learning Platform (01 Lý thuyết & 02 Thực hành)
 * Tag: [hpo_platform]
 * Updated to V3 Design: 01 Theory (Navy + Gauge 70% FaceID + 3 green cards + 6 curriculum subjects + 2 virtual simulation cards)
 * & 02 Practice (2 rows Yard & Road with condition badges + 2 red cards).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_ux_builder_shortcode( 'hpo_platform', array(
	'name'     => __( 'HPO Digital Learning Platform', 'flatsome-child' ),
	'category' => __( 'HPO Elements', 'flatsome-child' ),
	'priority' => 24,
	'options'  => array(
		'header_group'   => array(
			'type'    => 'group',
			'heading' => __( 'Tiêu đề chung', 'flatsome-child' ),
			'options' => array(
				'title' => array(
					'type'    => 'textfield',
					'heading' => __( 'Tiêu đề khối', 'flatsome-child' ),
					'default' => 'ĐÀO TẠO LÁI XE TRÊN NỀN TẢNG SỐ',
				),
			),
		),
		'theory_group'   => array(
			'type'    => 'group',
			'heading' => __( '01. Lý thuyết (Panel Navy)', 'flatsome-child' ),
			'options' => array(
				'theory_num'             => array(
					'type'    => 'textfield',
					'heading' => __( 'Số thứ tự', 'flatsome-child' ),
					'default' => '01',
				),
				'theory_label'           => array(
					'type'    => 'textfield',
					'heading' => __( 'Nhãn cụm', 'flatsome-child' ),
					'default' => 'Lý thuyết',
				),
				'theory_title'           => array(
					'type'    => 'textfield',
					'heading' => __( 'Tiêu đề cụm 01', 'flatsome-child' ),
					'default' => 'Học lý thuyết trên nền tảng số',
				),
				'theory_desc'            => array(
					'type'    => 'textarea',
					'heading' => __( 'Mô tả cụm 01', 'flatsome-child' ),
					'default' => 'Người học hoàn thành nội dung, chương trình, ghi nhận thời gian học thực bằng xác thực khuôn mặt. Hệ thống ghi nhận quá trình hoàn tất đầy đủ nội dung và thời gian thực của người học.',
				),
				'theory_item1_title'     => array(
					'type'    => 'textfield',
					'heading' => __( 'Tính năng 1 — Tiêu đề', 'flatsome-child' ),
					'default' => 'Xác thực khuôn mặt',
				),
				'theory_item1_desc'      => array(
					'type'    => 'textarea',
					'heading' => __( 'Tính năng 1 — Nội dung', 'flatsome-child' ),
					'default' => 'Người học hoàn thành nội dung và ghi nhận thời gian học thực bằng xác thực khuôn mặt, giúp quá trình học minh bạch và đúng tiến độ.',
				),
				'theory_item2_title'     => array(
					'type'    => 'textfield',
					'heading' => __( 'Tính năng 2 — Tiêu đề', 'flatsome-child' ),
					'default' => 'Ứng dụng đa nền tảng (Windows, Android,&nbsp;iOS)',
				),
				'theory_item2_desc'      => array(
					'type'    => 'textarea',
					'heading' => __( 'Tính năng 2 — Nội dung', 'flatsome-child' ),
					'default' => 'Học viên có thể học mọi lúc, mọi nơi trên Windows, Android và iOS, chủ động thời gian học và giảm chi phí di chuyển.',
				),
				'theory_gauge_image'     => array(
					'type'    => 'image',
					'heading' => __( 'Ảnh vòng tròn Gauge (FaceID)', 'flatsome-child' ),
				),
				'theory_gauge_alt'       => array(
					'type'    => 'textfield',
					'heading' => __( 'Alt ảnh Gauge', 'flatsome-child' ),
					'default' => 'Xác thực khuôn mặt khi học lý thuyết',
				),
				'theory_gauge_caption'   => array(
					'type'    => 'textarea',
					'heading' => __( 'Chú thích Gauge (70%)', 'flatsome-child' ),
					'default' => 'Người học lái xe được kiểm tra để xét hoàn thành khóa đào tạo khi tham dự <strong>tối thiểu&nbsp;70%</strong> thời gian học nội dung đào tạo lý thuyết;',
				),
				'theory_side_lead'       => array(
					'type'    => 'textfield',
					'heading' => __( 'Tiêu đề 3 thẻ xanh', 'flatsome-child' ),
					'default' => 'HỌC LÝ THUYẾT&nbsp;- luôn sẵn&nbsp;sàng mọi&nbsp;lúc, mọi&nbsp;nơi',
				),
				'side_img1'              => array(
					'type'    => 'image',
					'heading' => __( 'Ảnh thẻ xanh 1 (5 môn)', 'flatsome-child' ),
				),
				'side_img2'              => array(
					'type'    => 'image',
					'heading' => __( 'Ảnh thẻ xanh 2 (Mô hình 3D)', 'flatsome-child' ),
				),
				'side_img3'              => array(
					'type'    => 'image',
					'heading' => __( 'Ảnh thẻ xanh 3 (Bài giảng 360)', 'flatsome-child' ),
				),
				'sims_lead'              => array(
					'type'    => 'textfield',
					'heading' => __( 'Tiêu đề cụm mô phỏng ảo', 'flatsome-child' ),
					'default' => 'Rèn kỹ năng lái xe thực hành môi trường&nbsp;ảo',
				),
				'sim1_image'             => array(
					'type'    => 'image',
					'heading' => __( 'Ảnh mô phỏng sa hình', 'flatsome-child' ),
				),
				'sim1_caption'           => array(
					'type'    => 'textfield',
					'heading' => __( 'Chú thích mô phỏng sa hình', 'flatsome-child' ),
					'default' => 'Mô phỏng sa hình',
				),
				'sim2_image'             => array(
					'type'    => 'image',
					'heading' => __( 'Ảnh mô phỏng DAT', 'flatsome-child' ),
				),
				'sim2_caption'           => array(
					'type'    => 'textfield',
					'heading' => __( 'Chú thích mô phỏng DAT', 'flatsome-child' ),
					'default' => 'Mô phỏng DAT',
				),
			),
		),
		'practice_group' => array(
			'type'    => 'group',
			'heading' => __( '02. Thực hành (Panel Đỏ)', 'flatsome-child' ),
			'options' => array(
				'practice_num'       => array(
					'type'    => 'textfield',
					'heading' => __( 'Số thứ tự', 'flatsome-child' ),
					'default' => '02',
				),
				'practice_label'     => array(
					'type'    => 'textfield',
					'heading' => __( 'Nhãn cụm', 'flatsome-child' ),
					'default' => 'Thực hành',
				),
				'practice_safe_text' => array(
					'type'    => 'textfield',
					'heading' => __( 'Nhãn an toàn', 'flatsome-child' ),
					'default' => 'An toàn, hiệu quả với giáo viên hướng dẫn 1&nbsp;-&nbsp;1',
				),
				'practice_lead'      => array(
					'type'    => 'textfield',
					'heading' => __( 'Lời dẫn điều kiện', 'flatsome-child' ),
					'default' => 'Người học lái xe được kiểm tra để xét hoàn thành khóa đào tạo khi:',
				),
				// Hàng 1: Sa hình
				'row1_tag'           => array(
					'type'    => 'textfield',
					'heading' => __( 'Hàng 1 — Tag', 'flatsome-child' ),
					'default' => 'SA HÌNH',
				),
				'row1_title'         => array(
					'type'    => 'textfield',
					'heading' => __( 'Hàng 1 — Tiêu đề', 'flatsome-child' ),
					'default' => 'Thực hành lái xe trên sân sa hình',
				),
				'row1_desc'          => array(
					'type'    => 'textarea',
					'heading' => __( 'Hàng 1 — Mô tả', 'flatsome-child' ),
					'default' => 'Luyện xuất phát, dừng xe ngang dốc, ghép xe và xử lý giao lộ dưới sự hướng dẫn trực tiếp của giáo viên.',
				),
				'row1_cond'          => array(
					'type'    => 'textarea',
					'heading' => __( 'Hàng 1 — Điều kiện đào tạo', 'flatsome-child' ),
					'default' => 'Tham dự <strong>đủ thời gian</strong> và <strong>tối thiểu 50% quãng đường</strong> học thực hành lái xe trên sân tập lái;',
				),
				'card1_title'        => array(
					'type'    => 'textfield',
					'heading' => __( 'Thẻ đỏ 1 — Tiêu đề', 'flatsome-child' ),
					'default' => 'SA HÌNH',
				),
				'card1_image'        => array(
					'type'    => 'image',
					'heading' => __( 'Thẻ đỏ 1 — Ảnh xe sa hình', 'flatsome-child' ),
				),
				'card1_lead'         => array(
					'type'    => 'textfield',
					'heading' => __( 'Thẻ đỏ 1 — Lời dẫn ôn luyện', 'flatsome-child' ),
					'default' => 'Tích hợp ôn luyện lý thuyết trên HPO:',
				),
				'card1_note'         => array(
					'type'    => 'textfield',
					'heading' => __( 'Thẻ đỏ 1 — Ghi chú bài thi', 'flatsome-child' ),
					'default' => '(hạng&nbsp;B: 11&nbsp;bài&nbsp;thi, hạng&nbsp;C1: 10&nbsp;bài&nbsp;thi)',
				),
				// Hàng 2: DAT
				'row2_tag'           => array(
					'type'    => 'textfield',
					'heading' => __( 'Hàng 2 — Tag', 'flatsome-child' ),
					'default' => 'DAT',
				),
				'row2_title'         => array(
					'type'    => 'textfield',
					'heading' => __( 'Hàng 2 — Tiêu đề', 'flatsome-child' ),
					'default' => 'Thực hành lái xe trên đường (DAT)',
				),
				'row2_desc'          => array(
					'type'    => 'textarea',
					'heading' => __( 'Hàng 2 — Mô tả', 'flatsome-child' ),
					'default' => 'Hệ thống DAT ghi nhận đầy đủ quãng đường và thời gian thực hành, giúp học viên làm quen với tình huống giao thông thực tế.',
				),
				'row2_cond'          => array(
					'type'    => 'textarea',
					'heading' => __( 'Hàng 2 — Điều kiện đào tạo', 'flatsome-child' ),
					'default' => 'Tham dự <strong>đủ quãng đường</strong> và <strong>tối thiểu 50% thời gian</strong> học thực hành lái xe trên đường (DAT)',
				),
				'card2_title'        => array(
					'type'    => 'textfield',
					'heading' => __( 'Thẻ đỏ 2 — Tiêu đề', 'flatsome-child' ),
					'default' => 'DAT',
				),
				'card2_image'        => array(
					'type'    => 'image',
					'heading' => __( 'Thẻ đỏ 2 — Ảnh xe DAT', 'flatsome-child' ),
				),
			),
		),
	),
) );
