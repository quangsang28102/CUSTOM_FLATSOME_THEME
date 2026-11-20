<?php
/**
 * UX Builder Element: HPO Digital Learning Platform (01 Lý thuyết & 02 Thực hành)
 * Tag: [hpo_platform]
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
			'heading' => __( 'Tiêu đề & Tải ứng dụng', 'flatsome-child' ),
			'options' => array(
				'title'          => array(
					'type'    => 'textfield',
					'heading' => __( 'Tiêu đề chính', 'flatsome-child' ),
					'default' => 'ĐÀO TẠO LÁI XE TRÊN NỀN TẢNG SỐ',
				),
				'download_label' => array(
					'type'    => 'textfield',
					'heading' => __( 'Nhãn tải ứng dụng', 'flatsome-child' ),
					'default' => 'Tải ứng dụng học đa nền tảng',
				),
				'chplay_url'     => array(
					'type'    => 'textfield',
					'heading' => __( 'Link Google Play', 'flatsome-child' ),
					'default' => 'https://play.google.com/store/apps/details?id=com.hpo.edugo',
				),
				'chplay_image'   => array(
					'type'    => 'image',
					'heading' => __( 'Ảnh Google Play', 'flatsome-child' ),
				),
				'chplay_alt'     => array(
					'type'    => 'textfield',
					'heading' => __( 'Alt Google Play', 'flatsome-child' ),
					'default' => 'Tải trên Google Play',
				),
				'appstore_url'   => array(
					'type'    => 'textfield',
					'heading' => __( 'Link App Store', 'flatsome-child' ),
					'default' => 'https://apps.apple.com/vn/app/hiep-phat-edu/id6748065752',
				),
				'appstore_image' => array(
					'type'    => 'image',
					'heading' => __( 'Ảnh App Store', 'flatsome-child' ),
				),
				'appstore_alt'   => array(
					'type'    => 'textfield',
					'heading' => __( 'Alt App Store', 'flatsome-child' ),
					'default' => 'Tải trên App Store',
				),
			),
		),
		'theory_group'   => array(
			'type'    => 'group',
			'heading' => __( '01. Lý thuyết', 'flatsome-child' ),
			'options' => array(
				'theory_num'              => array(
					'type'    => 'textfield',
					'heading' => __( 'Số thứ tự', 'flatsome-child' ),
					'default' => '01',
				),
				'theory_label'            => array(
					'type'    => 'textfield',
					'heading' => __( 'Nhãn cụm', 'flatsome-child' ),
					'default' => 'Lý thuyết',
				),
				'theory_title'            => array(
					'type'    => 'textfield',
					'heading' => __( 'Tiêu đề cụm 01', 'flatsome-child' ),
					'default' => 'Học lý thuyết trên nền tảng số',
				),
				'theory_desc'             => array(
					'type'    => 'textarea',
					'heading' => __( 'Mô tả cụm 01', 'flatsome-child' ),
					'default' => 'Người học hoàn thành nội dung, chương trình, ghi nhận thời gian học thực bằng xác thực khuôn mặt. Hệ thống ghi nhận quá trình hoàn tất đầy đủ nội dung và thời gian thực của người học.',
				),
				'theory_threshold_prefix' => array(
					'type'    => 'textfield',
					'heading' => __( 'Điều kiện (đầu câu)', 'flatsome-child' ),
					'default' => 'Người học lái xe được kiểm tra để xét hoàn thành khóa đào tạo khi tham dự',
				),
				'theory_threshold_strong' => array(
					'type'    => 'textfield',
					'heading' => __( 'Điều kiện (nhấn mạnh)', 'flatsome-child' ),
					'default' => 'tối thiểu 70%',
				),
				'theory_threshold_suffix' => array(
					'type'    => 'textfield',
					'heading' => __( 'Điều kiện (cuối câu)', 'flatsome-child' ),
					'default' => 'thời gian học nội dung đào tạo lý thuyết;',
				),
				'theory_item1_title'      => array(
					'type'    => 'textfield',
					'heading' => __( 'Mục 1 — Tiêu đề', 'flatsome-child' ),
					'default' => 'Xác thực khuôn mặt',
				),
				'theory_item1_data_title' => array(
					'type'    => 'textfield',
					'heading' => __( 'Mục 1 — Data Title / Alt', 'flatsome-child' ),
					'default' => 'Xác thực khuôn mặt',
				),
				'theory_item1_desc'       => array(
					'type'    => 'textarea',
					'heading' => __( 'Mục 1 — Nội dung', 'flatsome-child' ),
					'default' => 'Người học hoàn thành nội dung và ghi nhận thời gian học thực bằng xác thực khuôn mặt, giúp quá trình học minh bạch và đúng tiến độ.',
				),
				'theory_item1_image'      => array(
					'type'    => 'image',
					'heading' => __( 'Mục 1 — Ảnh minh họa', 'flatsome-child' ),
				),
				'theory_item2_title'      => array(
					'type'    => 'textfield',
					'heading' => __( 'Mục 2 — Tiêu đề', 'flatsome-child' ),
					'default' => 'Ứng dụng đa nền tảng (Windows, Android, iOS)',
				),
				'theory_item2_data_title' => array(
					'type'    => 'textfield',
					'heading' => __( 'Mục 2 — Data Title', 'flatsome-child' ),
					'default' => 'Ứng dụng đa nền tảng',
				),
				'theory_item2_desc'       => array(
					'type'    => 'textarea',
					'heading' => __( 'Mục 2 — Nội dung', 'flatsome-child' ),
					'default' => 'Học viên có thể học mọi lúc, mọi nơi trên Windows, Android và iOS, chủ động thời gian học và giảm chi phí di chuyển.',
				),
				'theory_item2_image'      => array(
					'type'    => 'image',
					'heading' => __( 'Mục 2 — Ảnh minh họa', 'flatsome-child' ),
				),
			),
		),
		'practice_group' => array(
			'type'    => 'group',
			'heading' => __( '02. Thực hành', 'flatsome-child' ),
			'options' => array(
				'practice_num'          => array(
					'type'    => 'textfield',
					'heading' => __( 'Số thứ tự', 'flatsome-child' ),
					'default' => '02',
				),
				'practice_label'        => array(
					'type'    => 'textfield',
					'heading' => __( 'Nhãn cụm', 'flatsome-child' ),
					'default' => 'Thực hành',
				),
				'practice_title'        => array(
					'type'    => 'textfield',
					'heading' => __( 'Tiêu đề cụm 02', 'flatsome-child' ),
					'default' => 'Rèn kỹ năng lái xe thực hành môi trường ảo',
				),
				'practice_intro'        => array(
					'type'    => 'textfield',
					'heading' => __( 'Câu mở đầu điều kiện', 'flatsome-child' ),
					'default' => 'Người học lái xe được kiểm tra để xét hoàn thành khóa đào tạo khi',
				),
				'practice_req1_prefix'  => array(
					'type'    => 'textfield',
					'heading' => __( 'Điều kiện 1 (đầu)', 'flatsome-child' ),
					'default' => 'Tham dự',
				),
				'practice_req1_strong1' => array(
					'type'    => 'textfield',
					'heading' => __( 'Điều kiện 1 (nhấn mạnh 1)', 'flatsome-child' ),
					'default' => 'đủ thời gian',
				),
				'practice_req1_mid'     => array(
					'type'    => 'textfield',
					'heading' => __( 'Điều kiện 1 (giữa)', 'flatsome-child' ),
					'default' => 'và',
				),
				'practice_req1_strong2' => array(
					'type'    => 'textfield',
					'heading' => __( 'Điều kiện 1 (nhấn mạnh 2)', 'flatsome-child' ),
					'default' => 'tối thiểu 50% quãng đường',
				),
				'practice_req1_suffix'  => array(
					'type'    => 'textfield',
					'heading' => __( 'Điều kiện 1 (cuối)', 'flatsome-child' ),
					'default' => 'học thực hành lái xe trên sân tập lái;',
				),
				'practice_req2_prefix'  => array(
					'type'    => 'textfield',
					'heading' => __( 'Điều kiện 2 (đầu)', 'flatsome-child' ),
					'default' => 'Tham dự',
				),
				'practice_req2_strong1' => array(
					'type'    => 'textfield',
					'heading' => __( 'Điều kiện 2 (nhấn mạnh 1)', 'flatsome-child' ),
					'default' => 'đủ quãng đường',
				),
				'practice_req2_mid'     => array(
					'type'    => 'textfield',
					'heading' => __( 'Điều kiện 2 (giữa)', 'flatsome-child' ),
					'default' => 'và',
				),
				'practice_req2_strong2' => array(
					'type'    => 'textfield',
					'heading' => __( 'Điều kiện 2 (nhấn mạnh 2)', 'flatsome-child' ),
					'default' => 'tối thiểu 50% thời gian',
				),
				'practice_req2_suffix'  => array(
					'type'    => 'textfield',
					'heading' => __( 'Điều kiện 2 (cuối)', 'flatsome-child' ),
					'default' => 'học thực hành lái xe trên đường (DAT)',
				),
				'practice_item1_title'  => array(
					'type'    => 'textfield',
					'heading' => __( 'Mục 1 — Tiêu đề', 'flatsome-child' ),
					'default' => 'Thực hành lái xe trên sân sa hình',
				),
				'practice_item1_caption' => array(
					'type'    => 'textfield',
					'heading' => __( 'Mục 1 — Caption / Data Title', 'flatsome-child' ),
					'default' => 'Mô phỏng sa hình',
				),
				'practice_item1_desc'   => array(
					'type'    => 'textarea',
					'heading' => __( 'Mục 1 — Nội dung', 'flatsome-child' ),
					'default' => 'Luyện xuất phát, dừng xe ngang dốc, ghép xe và xử lý giao lộ dưới sự hướng dẫn trực tiếp của giáo viên.',
				),
				'practice_item1_image'  => array(
					'type'    => 'image',
					'heading' => __( 'Mục 1 — Ảnh minh họa', 'flatsome-child' ),
				),
				'practice_item2_title'  => array(
					'type'    => 'textfield',
					'heading' => __( 'Mục 2 — Tiêu đề', 'flatsome-child' ),
					'default' => 'Thực hành lái xe trên đường (DAT)',
				),
				'practice_item2_caption' => array(
					'type'    => 'textfield',
					'heading' => __( 'Mục 2 — Caption / Data Title', 'flatsome-child' ),
					'default' => 'Mô phỏng DAT',
				),
				'practice_item2_desc'   => array(
					'type'    => 'textarea',
					'heading' => __( 'Mục 2 — Nội dung', 'flatsome-child' ),
					'default' => 'Hệ thống DAT ghi nhận đầy đủ quãng đường và thời gian thực hành, giúp học viên làm quen với tình huống giao thông thực tế.',
				),
				'practice_item2_image'  => array(
					'type'    => 'image',
					'heading' => __( 'Mục 2 — Ảnh minh họa', 'flatsome-child' ),
				),
			),
		),
	),
) );
